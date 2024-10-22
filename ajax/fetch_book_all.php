<?php
require_once '../db/connect.php';
require_once '../controller/BookController.php';

$BookController = new BookController($conn);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 9;
    $offset = ($page - 1) * $limit;

    $btId = isset($_GET['bt_id']) ? $_GET['bt_id'] : [];
    $books = $BookController->getBooks($limit, $offset, $btId);

    // ดึงจำนวนหนังสือทั้งหมด
    $totalBooks = $BookController->countBooks($btId);

    // ส่งข้อมูลกลับไปในรูปแบบ JSON
    echo json_encode([
        'books' => $books,
        'totalBooks' => $totalBooks,
        'page' => $page,
        'limit' => $limit
    ]);
}
