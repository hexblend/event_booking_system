<?php
require_once('../../core/init.php');
if(!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit();
}

// Get data from url
$venue_id = (int)htmlentities($_GET['venue_id']);
$recs = (int)htmlentities($_GET['recs'] + 1);


// INSERT SQL
$sql = 'UPDATE venues SET recommended = :recs WHERE ID = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute(['recs' => $recs, 'id' => $venue_id]);

// Output recommendations
if ($recs === 1){
    echo $recs . ' recommendation';
} else {
    echo $recs . ' recommendations';
}
