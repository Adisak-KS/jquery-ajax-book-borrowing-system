<?php
$namePage = "รายงาน";
$nameWebsite = "ยืม-คืนหนังสือห้องสมุด";

require_once '../db/connect.php';
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
                    <h1 class="h3 mb-4 text-gray-800"><?php echo $namePage ?></h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between">
                                <p class="m-0 font-weight-bold text-primary mb-2">รายงานการยืมหนังสือ</p>
                            </div>
                            <div class="col-12">
                                <form >
                                    <div class="row align-items-end">
                                        <div class="col-12 col-md-3">
                                            <div class="form-group">
                                                <label for="time_start">วันเริ่มต้น</label>
                                                <input type="datetime-local" id="time_start" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="form-group">
                                                <label for="time_end">วันสิ้นสุด</label>
                                                <input type="datetime-local" id="time_end" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">ค้นหา</button>
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
                                            <th class="text-center">ชื่อหนังสือ</th> 
                                            <th class="text-center">จำนวน</th> 
                                            <th class="text-center">ชื่อ</th>
                                            <th class="text-center">นามสกุล</th>
                                            <th class="text-center">วัน เวลายืม</th>
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
        $(document).ready(function() {
            $('#tableBookReport').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'ajax/book_report_list.php',
                    type: 'POST',
                    error: function(xhr, error, thrown) {
                        console.error("Error loading data: " + error);
                    }
                },
                order: [
                    [0, 'desc']
                ],
            });
        });
    </script>


</body>

</html>