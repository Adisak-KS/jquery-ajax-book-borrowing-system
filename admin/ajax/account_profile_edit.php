<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/AdminController.php';

$AdminController = new AdminController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admId = $_SESSION['adm_id'] ?? '';
    $admFname = $_POST['admFname'] ?? '';
    $admLname = $_POST['admLname'] ?? '';
    $admStaffId = $_POST['admStaffId'] ?? '';
    $admOldProfile = $_POST['admOldProfile'] ?? '';

    // ตรวจสอบว่ามีการอัปโหลดไฟล์ใหม่หรือไม่
    $admNewProfile = $_FILES['admNewProfile']['name'] ?? '';



    validateFormAdmin($admId,$admFname, $admLname, $admStaffId);


    // ตรวจสอบว่ารหัสเจ้าหน้าที่ซ้ำหรือไม่
    $check = $AdminController->checkAdminExists($admStaffId, $admId);

    if ($check) {
        echo json_encode(['success' => false, 'message' => 'รหัสเจ้าหน้าที่นี้ มีอยู่แล้ว']);
        exit;
    } else {
        // จัดการการอัปโหลดรูปภาพใหม่ (ถ้ามี)
        if ($admNewProfile) {

            $folderUploads = "../../uploads/img_admin/";
            $allowedExtensions = ['png', 'jpg', 'jpeg'];
            $maxFileSize = 2 * 1024 * 1024; // 2 MB in bytes

            $fileExtension = strtolower(pathinfo($admNewProfile, PATHINFO_EXTENSION));
            $fileSize = $_FILES["admNewProfile"]["size"];

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
                if (move_uploaded_file($_FILES['admNewProfile']['tmp_name'], $targetFilePath)) {

                    // อัปเดตรูปโปรไฟล์ใหม่ในฐานข้อมูล
                    $profileImage = $newImg;

                    // ลบรูปเดิม
                    if (!empty($admOldProfile)) {
                        deleteImg($admOldProfile, $folderUploads);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'ไม่สามารถอัปโหลดรูปภาพใหม่ได้']);
                    exit;
                }
            }
        } else {
            // ถ้าไม่มีการอัปโหลดใหม่ ใช้รูปเดิม
            $profileImage = $admOldProfile;
        }

        // อัปเดตข้อมูลผู้ดูแลระบบในฐานข้อมูล
        $updateAdmin = $AdminController->updateAdmin($admId, $admFname, $admLname, $admStaffId, $profileImage);

        if ($updateAdmin) {
            echo json_encode(['success' => true, 'message' => 'แก้ไขข้อมูลส่วนตัวสำเร็จ']);
        } else {
            echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการแก้ไขข้อมูลส่วนตัว']);
        }
    }
}
