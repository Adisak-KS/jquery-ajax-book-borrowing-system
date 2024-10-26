<?php
$namePage = "เข้าสู่ระบบ";
$nameWebsite = "ยืม-คืนหนังสือห้องสมุด";


if (isset($_SESSION['usr_id'])) {
    header("Location: index.php");
    exit;
}


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
                            <form id="formLoginUser">
                                <div class="form-group">
                                    <label class="control-label" for="">ชื่อผู้ใช้งาน</label>
                                    <input type="text" name="usr_username" id="usr_username" class="form-control" placeholder="ชื่อผู้ใช้งาน">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="">รหัสผ่าน</label>
                                    <input type="password" name="usr_password" id="usr_password" class="form-control" placeholder="รหัสผ่าน">
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

    <script>
        $(document).ready(function() {
            // กำหนดการตรวจสอบฟอร์ม
            $('#formLoginUser').validate({
                rules: {
                    usr_username: {
                        required: true,
                    },
                    usr_password: {
                        required: true,
                    },
                },
                messages: {
                    usr_username: {
                        required: "กรุณากรอก ชื่อผู้ใช้งาน",
                    },
                    usr_password: {
                        required: "กรุณากรอก รหัสผ่าน",
                    },
                },
                errorElement: 'p',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                // ปรับแต่งสีของข้อความ error
                errorClass: 'text-danger',

                submitHandler: function(form) {
                    // หยุดการส่งฟอร์มแบบปกติ
                    event.preventDefault();

                    // ดึงข้อมูลจากฟอร์ม
                    let formData = {
                        usr_username: $('#usr_username').val(),
                        usr_password: $('#usr_password').val()
                    };

                    console.log(formData);

                    $.ajax({
                        type: 'POST',
                        url: 'ajax/login_check.php', // URL ที่จะส่งข้อมูลไปยังเซิร์ฟเวอร์
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // ถ้าสำเร็จให้ไปยังหน้า index
                                window.location.href = 'index.php';
                            } else {
                                // ถ้าไม่สำเร็จ แสดง SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เข้าสู่ระบบไม่สำเร็จ',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            // แสดงข้อความผิดพลาดทั่วไป
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: 'โปรดตรวจสอบการเชื่อมต่อและลองอีกครั้ง'
                            });
                        }
                    });
                }
            });
        });
    </script>


</body>

</html>