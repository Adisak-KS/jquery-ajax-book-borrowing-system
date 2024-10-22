<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/BookController.php';

$BookController = new BookController($conn);
header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bkId = $_POST['bk_id'] ?? '';
    $bkImg = $_POST['bk_img'] ?? '';

    $deleteBook = $BookController->deleteBook($bkId);

    if ($deleteBook) {
        // ลบรูปภาพ
        $folderUploads = "../../uploads/img_book/";

        if (!empty($bkImg)) {
            deleteImg($bkImg, $folderUploads);
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล']);
    }
}
