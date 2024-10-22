
<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/AdminController.php';

$AdminController = new AdminController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $admId = $_SESSION['adm_id'];

    $myAccount = $AdminController->getMyAccount($admId);

    if ($myAccount) {
        $_SESSION['adm_super_admin'] = $myAccount['adm_super_admin'];

        // ส่งค่าข้อมูลผู้ใช้กลับไปในรูปแบบ JSON
        echo json_encode([
            'first_name' => $myAccount['adm_fname'],
            'last_name' => $myAccount['adm_lname'],
            'staff_id' => $myAccount['adm_staff_id'],
            'profileImage' => $myAccount['adm_profile']
        ]);
    } else {
        // หากไม่มีข้อมูลในฐานข้อมูล ให้ลบ session และส่งค่า redirect กลับไป
        unset($_SESSION['adm_id']);
        unset($_SESSION['adm_super_admin']);
        echo json_encode(['redirect' => true]);
        exit();
    }
}
