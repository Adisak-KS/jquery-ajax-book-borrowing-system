<?php
require_once '../../db/connect.php';
require_once '../../controller/BookController.php';

$BookController = new BookController($conn);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $data = $BookController->getBookBorrowAndReturnCount();

    if ($data !== false) {
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'เกิดข้อผิดพลาดในการนับจำนวน']);
    }
}