<?php
require_once('../../core/init.php');
if (!isset($_SESSION['logged_in'])){
    header('Location: index.php');
    exit();
}

$reviewID = $_GET['review'];

// Update approved column
$sql = 'UPDATE reviews SET approved = :approved WHERE ID = :id';
$stmt = $pdo->prepare($sql);
$stmt -> execute(['approved' => '1', 'id' => $reviewID]);
