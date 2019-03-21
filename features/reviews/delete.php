<?php
require_once('../../core/init.php');
if (!isset($_SESSION['logged_in'])){
    header('Location: index.php');
    exit();
}

$reviewID = $_GET['review'];

// Update approved column
$sql = 'DELETE FROM reviews WHERE ID = ?';
$stmt = $pdo->prepare($sql);
$stmt -> execute([$reviewID]);
