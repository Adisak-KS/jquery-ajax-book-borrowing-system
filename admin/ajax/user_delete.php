<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/UserController.php';

$UserController = new UserController($conn);
header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usrId = $_POST['usr_id'] ?? '';
    $usrProfile = $_POST['usr_profile'] ?? '';

    $deleteUser = $UserController->deleteUser($usrId);

    if ($deleteUser) {
        // ลบรูปภาพ
        $folderUploads = "../../uploads/img_user/";
        if (!empty($usrProfile)) {
            deleteImg($usrProfile, $folderUploads);
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล']);
    }
}
