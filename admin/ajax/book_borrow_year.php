<?php
require_once '../../db/connect.php';
require_once '../../controller/BookController.php';

$BookController = new BookController($conn);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $data = $BookController->getSumBorrowYear();

    $response = [
        'labels' => array_column($data, 'month'),
        'data' => array_column($data, 'count')
    ];
    echo json_encode($response);
}