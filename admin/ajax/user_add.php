
<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/UserController.php';

$UserController = new UserController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usrFname = $_POST['usr_fname'] ?? '';
    $usrLname = $_POST['usr_lname'] ?? '';
    $usrUsername = $_POST['usr_username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $usrType = $_POST['usr_type'] ?? '';


    validateFormUser($usrFname, $usrLname, $usrUsername, $password, $confirmPassword);

    $check = $UserController->checkUserExists($usrUsername);

    if ($check) {
        // มี Username อยู่แล้ว
        echo json_encode(['success' => false, 'message' => 'ชื่อผู้ใช้นี้ มีอยู่แล้ว']);
        exit;
    } else {
        // ยังไม่มี Username 
        $insertUser = $UserController->insertUser($usrFname, $usrLname, $usrUsername, $password, $usrType);

        if ($insertUser) {
            echo json_encode(['success' => true, 'message' => 'เพิ่มผู้ใช้งานสําเร็จ']);
        } else {
            echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการเพิ่มผู้ใช้งาน']);
        }
    }
}
