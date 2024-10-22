
<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/BookTypeController.php';

$BookTypeController = new BookTypeController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $btName = $_POST['bt_name'] ?? '';

    $check = $BookTypeController->checkBookTypeExists($btName);

    if ($check) {
        // มีชื่อประเภทนี้อยู่แล้ว
        echo json_encode(['success' => false, 'message' => 'ชื่อประเภทนี้ มีอยู่แล้ว']);
        exit;
    } else {
        // ยังไม่มีชื่อประเภทนี้

        $insertBookType = $BookTypeController->insertBookType($btName);
        
        if ($insertBookType) {
            echo json_encode(['success' => true, 'message' => 'เพิ่มประเภทหนังสือสําเร็จ']);
        } else {
            echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการเพิ่มประเภทหนังสือ']);
        }
    }
}
