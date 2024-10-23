<?php
require_once '../db/connect.php';
require_once '../controller/BookController.php';

$BookController = new BookController($conn);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 9;
    $offset = ($page - 1) * $limit;

    // รับค่า search จาก URL
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // รับค่า bt_id (ประเภทหนังสือ)
    $btId = isset($_GET['bt_id']) ? $_GET['bt_id'] : [];

    // เรียกใช้ฟังก์ชัน getBooks โดยส่งค่าที่ค้นหาไปด้วย
    $books = $BookController->getBooks($limit, $offset, $btId, $search);

    // ดึงจำนวนหนังสือทั้งหมดโดยกรองจากค่า search
    $totalBooks = $BookController->countBooks($btId, $search);

    // ส่งข้อมูลกลับไปในรูปแบบ JSON
    echo json_encode([
        'books' => $books,
        'totalBooks' => $totalBooks,
        'page' => $page,
        'limit' => $limit
    ]);
}
