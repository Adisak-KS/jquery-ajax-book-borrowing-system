<?php
require_once '../../db/connect.php';
require_once '../../controller/UserController.php';

$UserController = new UserController($conn);

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start = $_POST['start'] ?? 0;
    $length = $_POST['length'] ?? 10;
    $search = $_POST['search']['value'] ?? '';

    // รับคอลัมน์ที่ใช้จัดเรียงและทิศทางการจัดเรียงจาก DataTable
    $orderColumn = $_POST['order'][0]['column'] ?? 0;
    $orderDir = $_POST['order'][0]['dir'] ?? 'asc';

    $data = $UserController->getUserList($start, $length, $search, $orderColumn, $orderDir);

   
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
