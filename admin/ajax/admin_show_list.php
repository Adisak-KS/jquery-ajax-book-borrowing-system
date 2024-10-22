<?php
require_once '../../db/connect.php';
require_once '../../controller/AdminController.php';

$AdminController = new AdminController($conn);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start = $_POST['start'] ?? 0;
    $length = $_POST['length'] ?? 10;
    $search = $_POST['search']['value'] ?? '';

    // รับคอลัมน์ที่ใช้จัดเรียงและทิศทางการจัดเรียงจาก DataTable
    $orderColumn = $_POST['order'][0]['column'] ?? 0;
    $orderDir = $_POST['order'][0]['dir'] ?? 'asc';

    $admId = $_SESSION['adm_id'];

    $data = $AdminController->getAdminList($start, $length, $search, $orderColumn, $orderDir, $admId);

    header('Content-Type: application/json');

    // ส่งข้อมูล JSON แบบ Debug
    $response = [
        "draw" => intval($_POST['draw']),
        "recordsTotal" => $data['total'],
        "recordsFiltered" => $data['totalFiltered'],
        "data" => $data['data']
    ];
    
    echo json_encode($response);
    exit;
}
