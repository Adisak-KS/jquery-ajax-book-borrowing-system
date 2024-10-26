<?php
require_once '../../db/connect.php';
require_once '../../controller/BookController.php';

$BookController = new BookController($conn);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $data = $BookController->getBookBorrowTopFive();

    
    $response = [
        'labels' => array_column($data, 'bk_name'),
        'data' => array_column($data, 'borrow_count')
    ];
    echo json_encode($response);
}