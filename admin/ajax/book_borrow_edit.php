<?php
require_once '../../db/connect.php';
require_once '../../controller/BookController.php';

$BookController = new BookController($conn);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brId = $_POST['brId'];
    $bkId = $_POST['bkId'];


    $updateBookBorrow = $BookController->updateBookBorrowStatusReturn($brId, $bkId);

    if ($updateBookBorrow) {
        $response = [
            'success' => true,
            'message' => 'ยืนยันการคืนหนังสือสําเร็จ!'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'เกิดข้อผิดพลาดในการยืนยันการคืนหนังสือ!'
        ];
    }
    
    echo json_encode($response);
}
