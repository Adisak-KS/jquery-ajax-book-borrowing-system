<?php


function generateUniqueImg($fileExtension, $folderUploads)
{
    do {
        // สร้างชื่อไฟล์ในรูปแบบ img_<unique_id>.<file_extension>
        $fileName = 'img_' . uniqid() . '.' . $fileExtension;
    } while (file_exists($folderUploads . $fileName));

    return $fileName;
}


function deleteImg($img, $folderUploads)
{

    // ตรวจสอบว่ามีชื่อไฟล์และไฟล์นั้นมีอยู่ในโฟลเดอร์ที่กำหนดหรือไม่
    if (!empty($img) && file_exists($folderUploads . $img)) {
        // ลบไฟล์รูปภาพ
        if (unlink($folderUploads . $img)) {
            return true; // คืนค่า true เมื่อการลบสำเร็จ
        }
    }
}

function validateFormAdmin($admFname, $admLname, $admStaffId, $password = NULL, $confirmPassword = NULL)
{
    if (empty($admFname)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกชื่อจริง']);
        exit;
    } elseif (mb_strlen($admFname, 'UTF-8') > 50) {
        echo json_encode(['success' => false, 'message' => 'ชื่อจริง ต้องไม่เกิน 50 ตัวอักษร']);
        exit;
    }


    if (empty($admLname)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกนามสกุล']);
        exit;
    } elseif (mb_strlen($admLname, 'UTF-8') > 50) {
        echo json_encode(['success' => false, 'message' => 'นามสกุล ต้องไม่เกิน 50 ตัวอักษร']);
        exit;
    }

    if (empty($admStaffId)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกรหัสเจ้าหน้าที่']);
        exit;
    }


    if ($password != NULL) {
        if (empty($password)) {
            echo json_encode(['success' => false, 'message' => 'กรุณากรอกรหัสผ่าน']);
            exit;
        } elseif (mb_strlen($password, 'UTF-8') < 8 && mb_strlen($password, 'UTF-8') > 255) {
            echo json_encode(['success' => false, 'message' => 'รหัสผ่าน ต้องมี 8-255 ตัวอักษร']);
        }
    }

    if ($confirmPassword != NULL) {
        if ($password != $confirmPassword) {
            echo json_encode(['success' => false, 'message' => 'รหัสผ่านไม่ตรงกัน']);
            exit;
        }
    }
}


function validateFormUser($usrFname, $usrLname, $usrUsername, $password = NULL, $confirmPassword = NULL)
{
    if (empty($usrFname)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกชื่อจริง']);
        exit;
    } elseif (mb_strlen($usrFname, 'UTF-8') > 50) {
        echo json_encode(['success' => false, 'message' => 'ชื่อจริง ต้องไม่เกิน 50 ตัวอักษร']);
        exit;
    }

    if (empty($usrLname)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกนามสกุล']);
        exit;
    } elseif (mb_strlen($usrLname, 'UTF-8') > 50) {
        echo json_encode(['success' => false, 'message' => 'นามสกุล ต้องไม่เกิน 50 ตัวอักษร']);
        exit;
    }

    if (empty($usrUsername)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกชื่อผู้ใช้งาน']);
        exit;
    } elseif (mb_strlen($usrUsername, 'UTF-8') < 6 && mb_strlen($usrUsername, 'UTF-8') > 50) {
        echo json_encode(['success' => false, 'message' => 'ชื่อผู้ใช้งาน ต้องมี 6-50 ตัวอักษร']);
    }

    if ($password != NULL) {
        if (empty($password)) {
            echo json_encode(['success' => false, 'message' => 'กรุณากรอกรหัสผ่าน']);
            exit;
        } elseif (mb_strlen($password, 'UTF-8') < 8 && mb_strlen($password, 'UTF-8') > 255) {
            echo json_encode(['success' => false, 'message' => 'รหัสผ่าน ต้องมี 8-255 ตัวอักษร']);
        }
    }

    if ($confirmPassword != NULL) {
        if ($password != $confirmPassword) {
            echo json_encode(['success' => false, 'message' => 'รหัสผ่านไม่ตรงกัน']);
            exit;
        }
    }
}

function validateFormBook($bkName, $bkQuantity, $bkStudentLoanPeriod, $bkTeacherLoanPeriod, $bkDetail, $bkPublisher, $bkAuthor, $btId, $bkShow){

    if (empty($bkName)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกชื่อหนังสือ']);
        exit;
    } elseif (mb_strlen($bkName, 'UTF-8') > 100) {  
        echo json_encode(['success' => false, 'message' => 'ชื่อหนังสือ ต้องไม่เกิน 100 ตัวอักษร']);
        exit;
    }

    if (empty($bkQuantity)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกจํานวนหนังสือ']);
        exit;
    } elseif (!is_numeric($bkQuantity)) {
        echo json_encode(['success' => false, 'message' => 'จํานวนหนังสือต้องเป็นตัวเลข']);
        exit;
    }

    if (empty($bkStudentLoanPeriod)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกระยะเวลายืมหนังสือ ของนักเรียน']);
        exit;
    } elseif (!is_numeric($bkStudentLoanPeriod)) {
        echo json_encode(['success' => false, 'message' => 'ระยะเวลายืมหนังสือของนักเรียน ต้องเป็นตัวเลข']);
        exit;
    }

    if (empty($bkTeacherLoanPeriod)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกระยะเวลายืมหนังสือ ของครู']);
        exit;
    } elseif (!is_numeric($bkTeacherLoanPeriod)) {
        echo json_encode(['success' => false, 'message' => 'ระยะเวลายืมหนังสือของครู ต้องเป็นตัวเลข']);
        exit;
    }

    if (empty($bkDetail)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกรายละเอียดหนังสือ']);
        exit;
    }

    if (empty($bkPublisher)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกชื่อผู้แต่ง']);
        exit;
    } elseif (mb_strlen($bkPublisher, 'UTF-8') > 100) {
        echo json_encode(['success' => false, 'message' => 'ชื่อผู้แต่ง ต้องไม่เกิน 100 ตัวอักษร']);
        exit;
    }

    if (empty($bkAuthor)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกชื่อผู้แต่ง']);
        exit;
    } elseif (mb_strlen($bkAuthor, 'UTF-8') > 100) {
        echo json_encode(['success' => false, 'message' => 'ชื่อผู้แต่ง ต้องไม่เกิน 100 ตัวอักษร']);
        exit;
    }

    if (empty($btId)) {
        echo json_encode(['success' => false, 'message' => 'กรุณาเลือกประเภทหนังสือ']);
        exit;
    }

    if (!isset($bkShow)) {
        echo json_encode(['success' => false, 'message' => 'กรุณาเลือกสถานะหนังสือ']);
        exit;
    }
}

function validateFormAccountPassword($oldPassword, $newPassword, $confirmPassword){

    if (empty($oldPassword)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกรหัสผ่านเก่า']);
        exit;
    }elseif(mb_strlen($oldPassword, 'UTF-8') < 8){
        echo json_encode(['success' => false, 'message' => 'รหัสผ่านเก่าต้องมากกว่า 8 ตัวอักษร']);
        exit;
    }

    if (empty($newPassword)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกรหัสผ่านใหม่']);
        exit;
    }elseif(mb_strlen($newPassword, 'UTF-8') < 8){
        echo json_encode(['success' => false, 'message' => 'รหัสผ่านใหม่ต้องมากกว่า 8 ตัวอักษร']);
        exit;
    }elseif($newPassword == $oldPassword){
        echo json_encode(['success' => false, 'message' => 'รหัสผ่านใหม่ต้องไม่เหมือนกับรหัสผ่านเก่า']);
        exit;
    }

    if (empty($confirmPassword)) {
        echo json_encode(['success' => false, 'message' => 'กรุณา ยืนยันรหัสผ่านใหม่']);
        exit;
    }elseif($newPassword != $confirmPassword){
        echo json_encode(['success' => false, 'message' => 'ยืนยันรหัสผ่านใหม่ไม่ถูกต้อง']);
        exit;
    }
}
