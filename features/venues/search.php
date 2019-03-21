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

    // Request Reviews for selected venue
    $sql = 'SELECT * FROM reviews WHERE venueID = ? AND approved = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$venue->ID, 1]);
    $reviews = $stmt->fetchAll();

    ?>
    <div class="card">
        <div class="card-body">

            <div class="title-bar">
                <button class="btn btn-link text-dark py-0" data-toggle="collapse"
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
                </div>

            </div>
        </div>
    </div>
    <?php
}
?>


