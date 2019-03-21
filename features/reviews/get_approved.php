<?php
require_once('../../core/init.php');
if(!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit();
}

$venue_id = $_GET['venue_id'];

// Request Reviews for selected venue
$sql = 'SELECT * FROM reviews WHERE venueID = ? AND approved = ?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$venue_id, 1]);
$reviews = $stmt->fetchAll();

// Response
foreach ($reviews as $review) {
    echo '<li class="list-group-item">' . $review->review . ' <span class="float-right">By ' . $review->username . '</span></li>';
}
echo '<div id="response-'.$venue_id.'"></div>';
