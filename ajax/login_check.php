
<?php
require_once '../db/connect.php';
require_once '../includes/functions.php';
require_once '../controller/UserController.php';

$UserController = new UserController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usrUsername = $_POST['usr_username'] ?? '';
    $usrPassword = $_POST['usr_password'] ?? '';

    if (empty($usrUsername) || empty($usrPassword)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบ']);
        exit;
    }

    $check = $UserController->checkUserLogin($usrUsername, $usrPassword);

    if ($check) {
        $_SESSION['usr_id'] = $check['usr_id'];
        echo json_encode(['success' => true]); // ส่งค่ากลับเมื่อเข้าสำเร็จ
    } else {
        echo json_encode(['success' => false, 'message' => 'ชื่อผู้ใช้งาน หรือรหัสผ่านไม่ถูกต้อง']);
    }
}
