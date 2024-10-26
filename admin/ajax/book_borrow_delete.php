<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/BookController.php';

$BookController = new BookController($conn);
header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brId = $_POST['br_id'] ?? '';
    $bkId = $_POST['bk_id'] ?? '';

    $deleteBookBorrow = $BookController->deleteBookBorrow($brId, $bkId);

    if ($deleteBookBorrow) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล']);
    }
}
