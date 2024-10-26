<?php
$namePage = "รายงาน";
$nameWebsite = "ยืม-คืนหนังสือห้องสมุด";

require_once '../db/connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('layouts/head.php'); ?>
    <link href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once('layouts/sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require_once('layouts/topbar.php'); ?>


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?php echo $namePage ?></h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between">
                                <p class="m-0 font-weight-bold text-primary mb-2">รายงานการยืมหนังสือ</p>
                            </div>
                            <div class="col-12">
                                <form id="formBookReport">
                                    <div class="row align-items-end">
                                        <div class="col-12 col-md-3">
                                            <div class="form-group">
                                                <label for="time_start">วันเริ่มต้น</label>
                                                <input type="datetime-local" id="time_start" name="time_start" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="form-group">
                                                <label for="time_end">วันสิ้นสุด</label>
                                                <input type="datetime-local" id="time_end" name="time_end" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="form-group">
                                                <button type="button" id="searchButton" class="btn btn-primary">ค้นหา</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tableBookReport" class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">วัน เวลาคืน</th>
                                            <th class="text-center">ชื่อ</th>
                                            <th class="text-center">นามสกุล</th>
                                            <th class="text-center">ชื่อหนังสือ</th>
                                            <th class="text-center">จำนวน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- แสดงข้อมูลด้วย AJAX จากไฟล์  book_borrow_list.php -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <?php require_once('layouts/footer.php'); ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php require_once('layouts/vendor.php'); ?>

    <!-- SELECT  -->
    <script>
        pdfMake.fonts = {
            THSarabun: {
                normal: 'THSarabun.ttf',
                bold: 'THSarabun-Bold.ttf',
                italics: 'THSarabun-Italic.ttf',
                bolditalics: 'THSarabun-BoldItalic.ttf'
            }
        };

        $(document).ready(function() {
            // Initialize the DataTable
            let table = $('#tableBookReport').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                layout: {
                    topStart: {
                        buttons: [
                            'copy',
                            {
                                extend: 'excel',
                                text: 'Excel',
                                title: 'Book Report', // ตั้งชื่อไฟล์ Excel ที่จะดาวน์โหลด
                                exportOptions: {
                                    columns: ':visible' // ส่งออกเฉพาะคอลัมน์ที่มองเห็น
                                }
                            },
                            {
                                extend: 'pdf',
                                text: 'PDF',
                                title: 'Book Report',
                                pageSize: 'A4',
                                margin: [10, 10, 10, 10],
                                customize: function(doc) {
                                    doc.defaultStyle = {
                                        font: 'THSarabun',
                                        fontSize: 12
                                    };

                                    // ดึงข้อมูลจาก DataTable
                                    let data = table.rows({
                                        search: 'applied'
                                    }).data().toArray();

                                    // กำหนดหัวข้อสำหรับตาราง
                                    let body = [
                                        ['วัน เวลา คืน', 'ชื่อ', 'นามสกุล', 'ชื่อหนังสือ', 'จำนวน'], // หัวข้อ
                                    ];

                                    // เพิ่มข้อมูลในแต่ละแถวลงใน body
                                    data.forEach(function(row) {
                                        body.push([
                                            row.br_return_date,
                                            row.usr_fname,
                                            row.usr_lname,
                                            row.bk_name,
                                            row.br_amount
                                        ]);
                                    });

                                    // กำหนด body ให้กับตาราง
                                    doc.content[1].table = {
                                        widths: ['*', '*', '*', '*', '*'], // กำหนดความกว้างให้ถูกต้อง
                                        body: body
                                    };
                                }
                            },

                            'print'
                        ],
                    },
                },
                ajax: {
                    url: 'ajax/book_report_list.php',
                    type: 'POST',
                    data: function(d) {
                        d.time_start = $('#time_start').val();
                        d.time_end = $('#time_end').val();
                    },
                    error: function(xhr, error, thrown) {
                        console.error("Error loading data: " + error);
                    }
                },
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: 'br_return_date',
                        class: 'text-center'
                    },
                    {
                        data: 'usr_fname',
                        class: 'text-left'
                    },
                    {
                        data: 'usr_lname',
                        class: 'text-left'
                    },
                    {
                        data: 'bk_name',
                        class: 'text-left'
                    },
                    {
                        data: 'br_amount',
                        class: 'text-center'
                    }
                ]
            });

            // Handle the search button click
            $('#searchButton').on('click', function() {
                table.ajax.reload(); // Reload table with new date filters
            });
        });
    </script>


</body>

</html>