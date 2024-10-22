<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/BookTypeController.php';

$BookTypeController = new BookTypeController($conn);
header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $btId = $_POST['bt_id'] ?? '';

    $deleteBookType = $BookTypeController->deleteBookType($btId);

    if ($deleteBookType) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล']);
    }
}
