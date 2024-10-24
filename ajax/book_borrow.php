<?php
require_once '../db/connect.php';
require_once '../includes/functions.php';
require_once '../controller/BookController.php';

$BookController = new BookController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if (!isset($_SESSION['usr_id'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบ']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usrId = $_SESSION['usr_id'];
    $bkId = $_POST['bk_id'] ?? '';

    validateFormInsertBorrow($bkId);

    $check = $BookController->checkBookBorrow($usrId, $bkId);

    if ($check) {
        echo json_encode(['success' => false, 'message' => 'หนังสือนี้คุณยืมไปแล้ว และยังไม่คืน']);
    } else {
        
    }
}
