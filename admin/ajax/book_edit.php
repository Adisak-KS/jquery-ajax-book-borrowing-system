<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/BookController.php';

$BookController = new BookController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bkId = $_POST['bkId'] ?? '';
    $bkName = $_POST['bkName'] ?? '';
    $bkAuthor = $_POST['bkAuthor'] ?? '';
    $bkPublisher = $_POST['bkPublisher'] ?? '';
    $bkQuantity = $_POST['bkQuantity'] ?? '';
    $bkStudentLoanPeriod = $_POST['bkStudentLoanPeriod'] ?? '';
    $bkTeacherLoanPeriod = $_POST['bkTeacherLoanPeriod'] ?? '';
    $bkDetail = $_POST['bkDetail'] ?? '';
    $btId = $_POST['btId'] ?? '';
    $bkShow = $_POST['bkShow'] ?? '';
    $bkOldImg = $_POST['bkOldImg'] ?? '';
    $bkNewImg = $_FILES['bkNewImg']['name'] ?? '';

    validateFormBook($bkName, $bkQuantity, $bkStudentLoanPeriod, $bkTeacherLoanPeriod, $bkDetail, $bkPublisher, $bkAuthor, $btId, $bkShow);


    // ตรวจสอบว่ารหัสเจ้าหน้าที่ซ้ำหรือไม่
    $check = $BookController->checkBookExists($bkName, $bkId);

    if ($check) {
        echo json_encode(['success' => false, 'message' => 'ชื่อหนังสือนี้ มีอยู่แล้ว']);
        exit;
    } else {
        // จัดการการอัปโหลดรูปภาพใหม่ (ถ้ามี)
        if ($bkNewImg) {

            $folderUploads = "../../uploads/img_book/";
            $allowedExtensions = ['png', 'jpg', 'jpeg'];
            $maxFileSize = 2 * 1024 * 1024; // 2 MB in bytes

            $fileExtension = strtolower(pathinfo($bkNewImg, PATHINFO_EXTENSION));
            $fileSize = $_FILES["bkNewImg"]["size"];

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
                if (move_uploaded_file($_FILES['bkNewImg']['tmp_name'], $targetFilePath)) {

                    // อัปเดตรูปโปรไฟล์ใหม่ในฐานข้อมูล
                    $bookImage = $newImg;

                    // ลบรูปเดิม
                    if (!empty($bkOldImg)) {
                        deleteImg($bkOldImg, $folderUploads);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'ไม่สามารถอัปโหลดรูปภาพใหม่ได้']);
                    exit;
                }
            }
        } else {
            // ถ้าไม่มีการอัปโหลดใหม่ ใช้รูปเดิม
            $bookImage = $bkOldImg;
        }

        // อัปเดตข้อมูลผู้ดูแลระบบในฐานข้อมูล
        $updateBook = $BookController->updateBook($bkId, $bkName, $bkQuantity, $bkStudentLoanPeriod, $bkTeacherLoanPeriod, $bkDetail, $bkPublisher, $bkAuthor, $btId, $bkShow, $bookImage);

        if ($updateBook) {
            echo json_encode(['success' => true, 'message' => 'แก้ไขหนังสือสำเร็จ']);
        } else {
            echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการแก้ไขหนังสือ']);
        }
    }
}
