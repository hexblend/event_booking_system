<?php
require_once('../../core/init.php');
if(!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit();
}

// Data to be sent
$review = htmlentities($_POST['new_review']);
$venue_id = $_POST['venue_id'];
$username = $_SESSION['logged_in'];
$approved = 0;

if ($review === '') {
    echo '<div class="alert alert-danger mt-2" id="danger-'.$venue_id.'" role="alert">Your review can\'t be empty!</div>';
    exit();
}

// Add to DB
$sql = 'INSERT INTO reviews (venueID, username, review, approved) VALUES (:venue_id, :username, :review, :approved)';
$stmt = $pdo->prepare($sql);
$stmt->execute(['venue_id' => $venue_id,
    'username' => $username,
    'review' => $review,
    'approved' => $approved]);

// Output New Review
echo '<div class="alert alert-success mt-2" id="success-'.$venue_id.'" role="alert">Success! Your review will be added after an admin approves it!</div>';
