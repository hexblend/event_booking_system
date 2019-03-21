<?php
require_once('../../core/init.php');
if(!isset($_SESSION['logged_in'])){
    header('Location: index.php');
    exit();
}

$name = htmlentities($_POST['name']);
$type = htmlentities($_POST['type']);
$description = htmlentities($_POST['description']);
$recommended = 0;
$username = $_SESSION['logged_in'];

$sql = 'INSERT INTO venues (name, type, description, recommended, username)
        VALUES (:name, :type, :description, :recommended, :username)';
$stmt = $pdo->prepare($sql);
$stmt->execute(['name' => $name,
                'type' => $type,
                'description' => $description,
                'recommended' => $recommended,
                'username' => $username]);

header('Location: ../../landing.php');
