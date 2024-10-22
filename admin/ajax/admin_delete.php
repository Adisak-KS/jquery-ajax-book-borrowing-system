<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/AdminController.php';

$AdminController = new AdminController($conn);
header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admId = $_POST['adm_id'] ?? '';
    $admProfile = $_POST['adm_profile'] ?? '';

    $deleteAdmin = $AdminController->deleteAdmin($admId);

    if ($deleteAdmin) {
        // ลบรูปภาพ
        $folderUploads = "../../uploads/img_admin/";
        if (!empty($admProfile)) {
            deleteImg($admProfile, $folderUploads);
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล']);
    }
}
