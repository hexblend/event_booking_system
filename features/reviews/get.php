<?php
require_once('../../core/init.php');
if(!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit();
}

// Get all unapproved reviews
$sql = 'SELECT * FROM reviews WHERE approved = ?';
$stmt = $pdo->prepare($sql);
$stmt->execute([0]);
$reviews = $stmt->fetchAll();
?>


<?php foreach($reviews as $review):
    // Get venues name/type
    $sql2 = 'SELECT ID, name, type FROM venues WHERE ID = ?';
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([$review->venueID]);
    $venue_details = $stmt2->fetchAll();
?>
<li class="list-group-item list-group-item-action flex-column align-items-start"
    id="pendingReview-<?= $review->ID ?>">
    <div class="d-flex w-100 justify-content-between mb-2">
        <h5 class="mb-0"><?= $venue_details[0]->name; ?>  -  <?= ucfirst($venue_details[0]->type); ?></h5>
        <small class="username">By <?= $review->username ?></small>
    </div>

    <p class="mb-3"><?= $review->review ?></p>

    <div class="btn-group" role="group" aria-label="Basic example">
        <form onsubmit="event.preventDefault();
                        ajaxApproveReview(<?= $review->ID ?>);
                        decreasePendingReviews();
                        setTimeout(ajaxGetApprovedReviews(<?= $review->venueID ?>), 300);">
            <button type="submit" class="btn btn-primary approve-btn">
                Approve
            </button>
        </form>
        <form onsubmit="event.preventDefault(); ajaxDeleteReview(<?= $review->ID ?>); decreasePendingReviews();">
            <button type="submit" class="btn btn-danger delete-btn">
                Delete
            </button>
        </form>
    </div>
</li>
<?php endforeach; ?>
