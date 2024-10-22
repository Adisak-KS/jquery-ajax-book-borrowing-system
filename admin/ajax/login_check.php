
<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/AdminController.php';

$AdminController = new AdminController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admStaffId = $_POST['adm_staff_id'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($admStaffId) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบ']);
        exit;
    }

    $check = $AdminController->checkAdminLogin($admStaffId, $password);

    if ($check) {
        $_SESSION['adm_id'] = $check['adm_id'];
        echo json_encode(['success' => true]); // ส่งค่ากลับเมื่อเข้าสำเร็จ
    } else {
        echo json_encode(['success' => false, 'message' => 'รหัสเจ้าหน้าที่หรือรหัสผ่านไม่ถูกต้อง']);
    }
}
