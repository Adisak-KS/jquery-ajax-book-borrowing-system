
<?php
require_once '../db/connect.php';
require_once '../includes/functions.php';
require_once '../controller/UserController.php';

$UserController = new UserController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $usrId = $_SESSION['usr_id'];

    $myAccount = $UserController->getMyAccount($usrId);

    if ($myAccount) {
        // ส่งค่าข้อมูลผู้ใช้กลับไปในรูปแบบ JSON
        echo json_encode([
            'usr_fname' => $myAccount['usr_fname'],
            'usr_lname' => $myAccount['usr_lname'],
            'usr_username' => $myAccount['usr_username'],
            'usr_type' => $myAccount['usr_type'],
            'profileImage' => $myAccount['usr_profile']
        ]);
    } else {
        // หากไม่มีข้อมูลในฐานข้อมูล ให้ลบ session และส่งค่า redirect กลับไป
        unset($_SESSION['adm_id']);
        unset($_SESSION['adm_super_admin']);
        echo json_encode(['redirect' => true]);
        exit();
    }
}
