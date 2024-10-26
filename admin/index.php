<?php
$namePage = "หน้าหลัก";
$nameWebsite = "ยืม-คืนหนังสือห้องสมุด";

require_once '../db/connect.php';
require_once '../controller/AdminController.php';

$AdminController = new AdminController($conn);
$AdminController->insertSuperAdminDefault();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('layouts/head.php'); ?>
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="borrow_show.php" class="text-decoration-none">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="h6 mb-0 font-weight-bold text-primary mb-2">
                                                    รายการยืมหนังสือ
                                                </div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" id="BookBorrowCount"></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa-solid fa-book fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="report.php" class="text-decoration-none">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="h6 mb-0 font-weight-bold text-success mb-2">
                                                    รายงาน
                                                </div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800" id="BookReturnCount"></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa-solid fa-clipboard fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">สถิติการยืมหนังสือ 12 เดือน ล่าสุด</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body" style="height: 400px;">

                                    <canvas id="chartBookBorrowYear"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">หนังสือที่นิยม 5 อันดับ ในเดือนนี้</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <canvas id="chartBookBorrowTopFive"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            // ฟังก์ชันเพื่อดึงข้อมูลจำนวนหนังสือที่ถูกยืม
            function fetchBookCounts() {
                $.ajax({
                    url: 'ajax/book_count.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#BookBorrowCount').text(response.borrowCount.toLocaleString() + ' รายการ');
                        $('#BookReturnCount').text(response.returnCount.toLocaleString() + ' รายการ');
                    },
                    error: function(xhr, status, error) {
                        console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
                    }
                });
            }

            // เรียกใช้ฟังก์ชันเมื่อเอกสารโหลดเสร็จ
            fetchBookCounts();
        });
    </script>

    <script>
        $(document).ready(function() {
            // ฟังก์ชันเพื่อโหลดข้อมูลด้วย AJAX
            function loadChartBookBorrowYear() {
                $.ajax({
                    url: 'ajax/book_borrow_year.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const labels = response.labels;
                        const data = response.data;

                        // สร้างกราฟ
                        const ctx = document.getElementById('chartBookBorrowYear').getContext('2d');
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'รายการ',
                                    data: data,
                                    borderWidth: 1,
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                    }
                });
            }

            loadChartBookBorrowYear(); // เรียกฟังก์ชันเพื่อโหลดข้อมูลครั้งแรก
        });
    </script>

    <script>
        $(document).ready(function() {
            // ฟังก์ชันเพื่อโหลดข้อมูลด้วย AJAX
            function loadChartBookBorrowTopFive() {
                $.ajax({
                    url: 'ajax/book_borrow_top.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const labels = response.labels;
                        const data = response.data;

                        // สร้างกราฟ
                        const ctx2 = document.getElementById('chartBookBorrowTopFive');
                        new Chart(ctx2, {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'รายการ',
                                    data: data,
                                    borderWidth: 1,
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: false // ซ่อน legend
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                    }
                });
            }

            loadChartBookBorrowTopFive(); // เรียกฟังก์ชันเพื่อโหลดข้อมูลครั้งแรก
        });
    </script>
</body>

</html>