<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'dfti';

$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
$pdo = new PDO($dsn, $username, $password);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

