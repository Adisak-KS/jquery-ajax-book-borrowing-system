<?php
$namePage = "ประวัติการยืมหนังสือ";
$nameWebsite = "ยืม-คืนหนังสือห้องสมุด";

session_start();

if (!isset($_SESSION['usr_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('layouts/head.php'); ?>

    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js"></script>

</head>

<body>
    <!-- Topbar Start -->
    <?php require_once('layouts/topbar.php'); ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <?php require_once('layouts/navbar.php'); ?>
    <!-- Navbar End -->



    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="index.php">หน้าหลัก</a>
                    <span class="breadcrumb-item text-dark">ประวัติการยืมหนังสือ</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12 bg-light">
                <table id="tableHistoryBorrow" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">วัน เวลายืม</th>
                            <th class="text-center">ชื่อหนังสือ</th>
                            <th class="text-center">จำนวน</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">วัน เวลาคืน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- แสดงข้อมูลด้วย AJAX จากไฟล์ fetch_history_borrow.php -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Shop End -->


    <!-- Footer Start -->
    <?php require_once('layouts/footer.php');  ?>



    <?php require_once('layouts/vendor.php'); ?>

    <!-- SELECT  -->
    <script>
        $(document).ready(function() {
            $('#tableHistoryBorrow').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'ajax/history_book_list.php',
                    type: 'POST',
                    error: function(xhr, error, thrown) {
                        console.error("Error loading data: " + error);
                    }
                },
                order: [[0, 'desc']], 
                columns: [{
                        data: 'br_borrow_date',
                        class: 'text-center'
                    },
                    {
                        data: 'bk_name',
                        class: 'text-left'
                    },
                    {
                        data: 'br_amount',
                        class: 'text-center'
                    },
                    {
                        data: 'br_status',
                        class: 'text-center',
                        render: function(data, type, row) {
                            if(data == 'return') {
                                return '<span class="badge badge-pill badge-success">return</span>';
                            }else{
                                return '<span class="badge badge-pill badge-danger">borrow</span>';
                            }
                        },

                    },
                    {
                        data: 'br_return_date',
                        class: 'text-center',
                        render: function(data, type, row) {
                            return data === null ? '-' : data;
                        },
                    }
                ]
            })
        });
    </script>
</body>

</html>