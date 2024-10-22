<?php
session_start();

$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "library";

$dsn = "mysql:host=$serverName;dbname=$dbName";

try {
    $conn = new PDO($dsn, $userName, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // echo "Connection Success";
} catch (PDOException $e) {
    echo "Connection Failed : " . $e->getMessage();
}
