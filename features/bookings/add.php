<?php
require_once('../../core/init.php');
if(!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit();
}

// Get Vars from URL
$venueID = htmlentities($_GET['venue_id']);
$dayofmonth = htmlentities($_GET['day_of_month']);
$noOfSeats = intval(htmlentities($_GET['no_of_seats']));

// Collect Updated Availabity
$sql = 'SELECT availability FROM availability WHERE venueID = :venueID AND dayofmonth = :dayofmonth';
$stmt = $pdo->prepare($sql);
$stmt->execute(['venueID' => $venueID, 'dayofmonth' => $dayofmonth]);
$availability = $stmt->fetch();
$availability = intval($availability->availability);
$curr_availability = $availability - $noOfSeats;

// Update availability column in DB
$sql = 'UPDATE availability SET availability = :curr_availability WHERE venueID = :venueID AND dayofmonth = :dayofmonth';
$stmt = $pdo->prepare($sql);
$stmt->execute(['curr_availability' => $curr_availability,
                'venueID' => $venueID,
                'dayofmonth' => $dayofmonth]);

// Booking Confirmation
if($curr_availability != 0) {
    echo '<div class="alert alert-success d-inline mr-4" role="alert">Congrats! You just booked '.$noOfSeats.' seat'.(($noOfSeats > 1)?'s':'').'.</div><span class="badge badge-success mr-2">'.$curr_availability.' More Seat'.(($curr_availability > 1)?'s':'').' Available</span></div>';
} else {
    echo '<div class="alert alert-success d-inline mr-4" role="alert">Congrats! You just booked '.$noOfSeats.' seat'.(($noOfSeats > 1)?'s':'').'.</div><span class="badge badge-danger mr-2" id="fully-booked-badge-'.$dayofmonth.'">Fully booked</span></div>';
}




