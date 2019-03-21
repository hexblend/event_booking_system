<?php
require_once('../../core/init.php');

$username = htmlentities($_POST['username']);
$password = htmlentities($_POST['password']);

$sql = 'SELECT * FROM users WHERE username = ?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user->password != $password) {
    header('Location: ../../index.php');
    exit();
} else {
    $_SESSION['logged_in'] = $user->username;
    header('Location: ../../landing.php');
    exit();
}

