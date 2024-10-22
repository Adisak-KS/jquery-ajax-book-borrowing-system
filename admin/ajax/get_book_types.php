<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/BookController.php';

$BookController = new BookController($conn);
header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
    $bookType = $BookController->getBookType();

    echo json_encode($bookType);
}
