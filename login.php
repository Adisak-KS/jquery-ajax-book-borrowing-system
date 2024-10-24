<?php
$namePage = "เข้าสู่ระบบ";
$nameWebsite = "ยืม-คืนหนังสือห้องสมุด";



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('layouts/head.php'); ?>
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
                    <span class="breadcrumb-item active">เข้าสู่ระบบ</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">

            <div class="col-lg-12 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12 mb-3">
                            <h3 class="text-center">เข้าสู่ระบบ</h3>
                        </div>
                        <div class="col-4">
                            <form >
                                <div class="form-group">
                                    <label class="control-label" for="">ชื่อผู้ใช้งาน</label>
                                    <input type="text" class="form-control" placeholder="ชื่อผู้ใช้งาน">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="">รหัสผ่าน</label>
                                    <input type="password" class="form-control" placeholder="รหัสผ่าน">
                                </div>
                                <hr>
                                <div class="form-group"></div>
                                <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Shop Detail End -->

    <!-- Footer Start -->
    <?php require_once('layouts/footer.php'); ?>

    <?php require_once('layouts/vendor.php'); ?>

</body>

</html>