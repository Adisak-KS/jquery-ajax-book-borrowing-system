<?php
require_once '../db/connect.php';
require_once '../includes/functions.php';
require_once '../controller/UserController.php';

$UserController = new UserController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usrId = $_SESSION['usr_id'] ?? '';
    $usrOldPassword = $_POST['edit_acc_usr_old_password'] ?? '';
    $usrNewPassword = $_POST['edit_acc_usr_new_password'] ?? '';
    $usrConfirmPassword = $_POST['edit_acc_usr_confirm_password'] ?? '';


    validateFormAccountPassword($usrOldPassword, $usrNewPassword, $usrConfirmPassword);

    $check = $UserController->checkUserAccountPassword($usrId, $usrOldPassword);

    if ($check) {
        $updatePassword = $UserController->updateUserPassword($usrId, $usrNewPassword);

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
