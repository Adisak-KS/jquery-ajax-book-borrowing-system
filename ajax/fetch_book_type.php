<?php
require_once '../db/connect.php';
require_once '../controller/BookController.php';

$BookController = new BookController($conn);

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $bookType = $BookController->getBookTypeCount();
    echo json_encode($bookType);
}
