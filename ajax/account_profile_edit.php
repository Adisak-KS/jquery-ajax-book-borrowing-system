<?php
require_once '../db/connect.php';
require_once '../includes/functions.php';
require_once '../controller/UserController.php';

$UserController = new UserController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usrId = $_SESSION['usr_id'] ?? '';
    $usrFname = $_POST['usrFname'] ?? '';
    $usrLname = $_POST['usrLname'] ?? '';
    $usrUsername = $_POST['usrUsername'] ?? '';
    $usrType = $_POST['usrType'] ?? '';
    $usrOldProfile = $_POST['usrOldProfile'] ?? '';

    // ตรวจสอบว่ามีการอัปโหลดไฟล์ใหม่หรือไม่
    $usrNewProfile = $_FILES['usrNewProfile']['name'] ?? '';



    validateFormUser($usrFname, $usrLname, $usrUsername);


    // ตรวจสอบว่ารหัสเจ้าหน้าที่ซ้ำหรือไม่
    $check = $UserController->checkUserExists($usrUsername, $usrId);

    if ($check) {
        echo json_encode(['success' => false, 'message' => 'ชื่อผู้ใช้งานนี้ มีอยู่แล้ว']);
        exit;
    } else {
        // จัดการการอัปโหลดรูปภาพใหม่ (ถ้ามี)
        if ($usrNewProfile) {

            $folderUploads = "../uploads/img_user/";
            $allowedExtensions = ['png', 'jpg', 'jpeg'];
            $maxFileSize = 2 * 1024 * 1024; // 2 MB in bytes

            $fileExtension = strtolower(pathinfo($usrNewProfile, PATHINFO_EXTENSION));
            $fileSize = $_FILES["usrNewProfile"]["size"];

            // Validate file type and size
            if (!in_array($fileExtension, $allowedExtensions)) {
                echo json_encode(['success' => false, 'message' => 'ไฟล์รูปภาพต้องเป็น png, jpg หรือ jpeg เท่านั้น']);
                exit;
            } elseif ($fileSize > $maxFileSize) {
                echo json_encode(['success' => false, 'message' => 'ไฟล์รูปภาพต้องมีขนาดไม่เกิน 2 MB']);
                exit;
            } else {

                // Random File Name
                $newImg =  generateUniqueImg($fileExtension, $folderUploads);
                $targetFilePath = $folderUploads . $newImg;

                // ตรวจสอบว่าการอัปโหลดสำเร็จหรือไม่
                if (move_uploaded_file($_FILES['usrNewProfile']['tmp_name'], $targetFilePath)) {

                    // อัปเดตรูปโปรไฟล์ใหม่ในฐานข้อมูล
                    $profileImage = $newImg;

                    // ลบรูปเดิม
                    if (!empty($usrOldProfile)) {
                        deleteImg($usrOldProfile, $folderUploads);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'ไม่สามารถอัปโหลดรูปภาพใหม่ได้']);
                    exit;
                }
            }
        } else {
            // ถ้าไม่มีการอัปโหลดใหม่ ใช้รูปเดิม
            $profileImage = $usrOldProfile;
        }

        // อัปเดตข้อมูลผู้ดูแลระบบในฐานข้อมูล
        $updateUser = $UserController->updateUser($usrId, $usrFname, $usrLname, $usrUsername, $usrType,$profileImage);

        if ($updateUser) {
            echo json_encode(['success' => true, 'message' => 'แก้ไขข้อมูลส่วนตัวสำเร็จ']);
        } else {
            echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการแก้ไขข้อมูลส่วนตัว']);
        }
    }
}
