
<?php
require_once '../../db/connect.php';
require_once '../../includes/functions.php';
require_once '../../controller/BookController.php';

$BookController = new BookController($conn);

header('Content-Type: application/json'); // กำหนดว่า output เป็น JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $bkName = $_POST['bk_name'] ?? '';
    $bkQuantity = $_POST['bk_quantity'] ?? '';
    $bkDetail = $_POST['bk_detail'] ?? '';
    $bkStudentLoanPeriod = $_POST['bk_student_loan_period'] ?? '';
    $bkTeacherLoanPeriod = $_POST['bk_teacher_loan_period'] ?? '';
    $bkPublisher = $_POST['bk_publisher'] ?? '';
    $bkAuthor = $_POST['bk_author'] ?? '';
    $btId = $_POST['bt_id'] ?? '';
    $bkShow = $_POST['bk_show'] ?? '';


    validateFormBook($bkName, $bkQuantity, $bkStudentLoanPeriod, $bkTeacherLoanPeriod, $bkDetail, $bkPublisher, $bkAuthor, $btId, $bkShow);

    $check = $BookController->checkBookExists($bkName);

    if ($check) {
        // มีชื่อหนังสือนี้อยู่แล้ว
        echo json_encode(['success' => false, 'message' => 'ชื่อหนังสือนี้ มีอยู่แล้ว']);
        exit;
    } else {
        // ยังไม่มีชื่อหนังสือนี้
        $insertBook = $BookController->insertBook($bkName, $bkQuantity,$bkStudentLoanPeriod, $bkTeacherLoanPeriod, $bkDetail, $bkPublisher, $bkAuthor, $btId, $bkShow);

        if ($insertBook) {
            echo json_encode(['success' => true, 'message' => 'เพิ่มหนังสือสําเร็จ']);
        } else {
            echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการเพิ่มข้อมูลผู้ดูแลระบบ']);
        }
    }
}
