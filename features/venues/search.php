<?php
require_once('../../core/init.php');
if(!isset($_SESSION['logged_in'])){
    header('Location: index.php');
    exit();
};

// User input
$search = trim('%' . htmlentities($_GET['search']) . '%');

// Check if empty
if($search == '%%'){
    echo '
    <div class="alert alert-danger" role="alert">
        You need to insert a venue type!
    </div>
    ';
    die();
}

// Request Venues
$sql = 'SELECT * FROM venues WHERE type LIKE ?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$search]);
$venues = $stmt->fetchAll();

// Check if there are results
if(count($venues) === 0){
    echo '<div class="alert alert-danger" role="alert">Sorry, no venues found!</div>';
    die();
}

// Output results
foreach ($venues as $venue) {

    // Array of all dates for next month
    $dates=array();
    $next_month = date('m', mktime(0,0,0, date('m')+1, 1));
    $year = date('Y');
    for($d=1; $d<=31; $d++)
    {
        $time=mktime(12, 0, 0, $next_month, $d, $year);
        if (date('m', $time)==$next_month){
            $dates[]=date( 'd', $time);
            $full_dates[]=date( 'l, d/m/Y', $time);
        }
    }

    foreach($dates as $date) {
        // Insert each Venue for each Date into DB; Check if the record doesn't exist already
        $sql = 'INSERT INTO availability (venueID, dayofmonth, availability) 
                SELECT :venueID, :dayofmonth, :availability
                WHERE NOT EXISTS (SELECT venueID, dayofmonth, availability FROM availability WHERE venueID = :venueID AND dayofmonth = :dayofmonth)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'venueID' => $venue->ID,
            'dayofmonth' => $date,
            'availability' => 20
        ]);
    }

    // Request Reviews for selected venue
    $sql = 'SELECT * FROM reviews WHERE venueID = ? AND approved = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$venue->ID, 1]);
    $reviews = $stmt->fetchAll();

    ?>
    <div class="card">
        <div class="card-body">

            <div class="title-bar">
                <button class="btn btn-link text-dark py-0 pl-0" data-toggle="collapse"
                        data-target="#venue-<?= $venue->ID ?>" aria-expanded="true"
                        aria-controls="venue-<?= $venue->ID ?>">
                        <?= $venue->name ?>
                </button>

                <?php
                if (intval($venue->recommended) == 0) {
                    echo '<span class="badge badge-danger float-right" id="rec-'.$venue->ID.'">0 recommendations</span>';
                } else {
                    echo '<span class="badge badge-success float-right" id="rec-'.$venue->ID.'">'. $venue->recommended
                         .' recommendation' . (intval($venue->recommended) > 1 ? 's' : '') . '</span>';
                }
                ?>
            </div>

            <div id="venue-<?= $venue->ID ?>" class="collapse" aria-labelledby="heading-<?= $venue->ID ?>"
                 data-parent="#venues">
                <div class="description mb-3 mt-4">
                    <p class="mb-1 text-primary">Description</p>
                    <p><?= $venue->description ?></p>
                </div>

                <div class="reviews mt-4">
                    <p class="mb-1 text-primary">Reviews</p>
                    <ul class="list-group mb-3" id="reviews-<?=$venue->ID?>">
                        <?php
                        foreach ($reviews as $review) {
                            echo '<li class="list-group-item">' . $review->review . ' <span class="float-right">By ' . $review->username . '</span></li>';
                        }
                        ?>
                        <div id="response-<?=$venue->ID?>"></div>
                    </ul>
                    <row class="mt-3 mb-2">
                        <button class="btn btn-primary float-right" type="button" data-toggle="collapse"
                                data-target="#booking-box-<?= $venue->ID ?>" aria-expanded="false"
                                aria-controls="booking-box-<?=$venue->ID?>">
                            Book this venue
                        </button>
                        <button class="btn btn-primary" type="button" data-toggle="collapse"
                                data-target="#add-review-box-<?= $venue->ID ?>" aria-expanded="false"
                                aria-controls="add-review-box-<?=$venue->ID?>">
                            Add a review
                        </button>
                        <form onsubmit="event.preventDefault(); ajaxAddRec(<?=$venue->ID?>, <?=$venue->recommended?>);" style="display: inline-block;">
                            <button class="btn btn-success" type="submit">+1 Recommendation</button>
                        </form>
                    </row>
                    <div class="collapse" id="add-review-box-<?= $venue->ID ?>">
                        <div class="card-body">
                            <h4 class="card-title text-center">Add a review</h4>
                            <form onsubmit="event.preventDefault();
                                              ajaxAddReview(<?=$venue->ID?>);
                                              setTimeout(ajaxGetReviews, 100);
                                              increasePendingReviews();"
                                  id="add-review-form-<?=$venue->ID?>">
                                <div class="form-group">
                                    <textarea class="form-control" name="new_review" id="new_review_<?=$venue->ID?>" rows="3" placeholder="Add text to your review..."></textarea>
                                </div>
                                <button class="btn btn-primary btn-block text-uppercase mt-3" type="submit">Add review</button>
                            </form>
                        </div>
                    </div>

                    <div class="collapse mt-3" id="booking-box-<?= $venue->ID ?>">
                        <?php
                        // View availability details for a venue
                        $sql = 'SELECT * FROM availability WHERE venueID = ?';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$venue->ID]);
                        $availabilities = $stmt->fetchAll();
                        ?>

                        <?php foreach($availabilities as $availability): ?>
                            <div class="card px-3">
                                <div class="py-3 d-flex align-items-center">
                                    <div id="seats_available-<?= $availability->ID ?>">
                                    <?php
                                        if($availability->availability != 0) {
                                            echo '<span class="badge badge-success mr-2">'.$availability->availability.' Seat'.(($availability->availability > 1)?'s':'').' Available</span></div>';
                                        } else {
                                            echo '<span class="badge badge-danger mr-2">Fully booked</span></div>';
                                        }

                                        $dayofmonth = $availability->dayofmonth;
                                        $dayofmonth = $dayofmonth - 1;
                                        $seatsAvailable = $availability->availability;

                                        echo $full_dates[$dayofmonth];
                                    ?>
                                    <?php if($seatsAvailable != 0): ?>
                                        <form class="form-inline float-right ml-auto"
                                              onsubmit="event.preventDefault(); ajaxAddBooking(<?= $availability->ID ?>,
                                                                                               <?= $availability->venueID ?>,
                                                                                               <?= $availability->dayofmonth ?>,
                                                                                               <?= $availability->availability ?>);"
                                              id="booking-form-<?= $availability->ID ?>">
                                            <div class="form-group mr-2">
                                                <select id="no_of_seats-<?= $availability->ID ?>" class="form-control form-control-sm d-inline-block" style="width: 100px;">
                                                    <option value="" selected disabled hidden>No. of seats</option>
                                                    <?php
                                                    for ($seats = 1; $seats <= $seatsAvailable; $seats++) {
                                                        echo '<option value="'.$seats.'">'.$seats.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <button class="btn btn-primary text-uppercase" type="submit">Book</button>
                                        </form>
                                    <?php else: ?>
                                        <?= '' ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>


