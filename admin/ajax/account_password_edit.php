<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/AdminController.php';

$AdminController = new AdminController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admId = $_SESSION['adm_id'] ?? '';
    $admOldPassword = $_POST['edit_acc_adm_old_password'] ?? '';
    $admNewPassword = $_POST['edit_acc_adm_new_password'] ?? '';
    $admConfirmPassword = $_POST['edit_acc_adm_confirm_password'] ?? '';


    validateFormAccountPassword($admOldPassword, $admNewPassword, $admConfirmPassword);

    $check = $AdminController->checkAdminAccountPassword($admId, $admOldPassword);

    if ($check) {
        $updatePassword = $AdminController->updateAdminPassword($admId, $admNewPassword);

        if ($updatePassword) {
            echo json_encode(['success' => true, 'message' => 'เปลี่ยนรหัสผ่านเรียบร้อย']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'เปลี่ยนรหัสผ่านไม่สำเร็จ']);
            exit;
        }
    }else{
        echo json_encode(['success' => false, 'message' => 'รหัสผ่านเก่าไม่ถูกต้อง']);
        exit;
    }

}
