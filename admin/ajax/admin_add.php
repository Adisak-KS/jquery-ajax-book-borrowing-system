
<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/AdminController.php';

$AdminController = new AdminController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $admFname = $_POST['adm_fname'] ?? '';
    $admLname = $_POST['adm_lname'] ?? '';
    $admStaffId = $_POST['adm_staff_id'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $admSuperAdmin = 0;


    validateFormAdmin($admFname, $admLname, $admStaffId, $password, $confirmPassword);

    $check = $AdminController->checkAdminExists($admStaffId);

    if ($check) {
        // มีรหัสเจ้าหน้าที่อยู่แล้ว
        echo json_encode(['success' => false, 'message' => 'รหัสเจ้าหน้าที่นี้ มีอยู่แล้ว']);
        exit;
    } else {
        // ยังไม่มีรหัสเจ้าหน้าที่
        $insertAdmin = $AdminController->insertAdmin($admFname, $admLname, $admStaffId, $password, $admSuperAdmin);

        if ($insertAdmin) {
            echo json_encode(['success' => true, 'message' => 'เพิ่มผู้ดูแลระบบสําเร็จ']);
        } else {
            echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการเพิ่มข้อมูลผู้ดูแลระบบ']);
        }
    }
}
