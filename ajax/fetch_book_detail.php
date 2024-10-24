<?php
require_once '../db/connect.php';
require_once '../controller/BookController.php';

$BookController = new BookController($conn);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $bkId = $_GET['bk_id'] ?? '';
    $bookDetail = $BookController->getBookDetail($bkId);
    echo json_encode($bookDetail);
}