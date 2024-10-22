<?php
require_once '../db/connect.php';
require_once '../controller/BookController.php';

$BookController = new BookController($conn);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 9;
    $offset = ($page - 1) * $limit;

    $bookTypes = isset($_GET['book_type']) ? $_GET['book_type'] : [];
    $books = $BookController->getBooks($limit, $offset, $bookTypes);

    // ดึงจำนวนหนังสือทั้งหมด
    $totalBooks = $BookController->countBooks();

    // ส่งข้อมูลกลับไปในรูปแบบ JSON
    echo json_encode([
        'books' => $books,
        'totalBooks' => $totalBooks,
        'page' => $page,
        'limit' => $limit
    ]);
}
