<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/BookTypeController.php';

$BookTypeController = new BookTypeController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $btId = $_POST['btId'] ?? '';
    $btName = $_POST['btName'] ?? '';


    // ตรวจสอบว่ามีชื่อประเภทนี้อยู่แล้วหรือยัง
    $check = $BookTypeController->checkBookTypeExists($btName, $btId);

    if ($check) {
        echo json_encode(['success' => false, 'message' => 'ชื่อประเภทนี้ มีอยู่แล้ว']);
        exit;
    } else {

       
        $updateBookType = $BookTypeController->updateBookType($btId, $btName);

        if ($updateBookType) {
            echo json_encode(['success' => true, 'message' => 'แก้ไขประเภทหนังสือสำเร็จ']);
        } else {
            echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการแก้ไขประเภทหนังสือ']);
        }
    }
}
