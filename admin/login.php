<?php
$namePage = "เข้าสู่ระบบ";
$nameWebsite = "ยืม-คืนหนังสือห้องสมุด";

require_once '../db/connect.php';
require_once '../controller/AdminController.php';

$AdminController = new AdminController($conn);
$AdminController->insertSuperAdminDefault();

if (isset($_SESSION['adm_id'])) {
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('layouts/head.php'); ?>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <div class="p-5 d-flex justify-content-center">
                                    <img src="../uploads/img_setting/favicon.png" style="width: 80%;" alt="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">เข้าสู่ระบบสำหรับผู้ดูแล!</h1>
                                    </div>
                                    <form id="formLogin" class="user">
                                        <div class="form-group">
                                            <input type="number" id="adm_staff_id" name="adm_staff_id" class="form-control form-control-user" placeholder="รหัสเจ้าหน้าที่">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" id="password" name="password" class="form-control form-control-user" placeholder="รหัสผ่าน">
                                        </div>
                                        <hr>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            เข้าสู่ระบบ
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <?php require_once('layouts/vendor.php'); ?>

    <script>
        $(document).ready(function() {
            // กำหนดการตรวจสอบฟอร์ม
            $('#formLogin').validate({
                rules: {
                    adm_staff_id: {
                        required: true,
                        digits: true,
                        minlength: 13,
                        maxlength: 13,
                    },
                    password: {
                        required: true,
                        pattern: /^[^\u0E00-\u0E7F]+$/, // สำหรับการตรวจสอบรหัสผ่านห้ามมีภาษาไทย
                        minlength: 8,
                        maxlength: 255
                    },
                },
                messages: {
                    adm_staff_id: {
                        required: "กรุณากรอก รหัสเจ้าหน้าที่",
                        digits: "รหัสเจ้าหน้าที่ ต้องเป็นตัวเลขจำนวนเต็ม",
                        minlength: "รหัสเจ้าหน้าที่ ต้องมีความยาว 13 ตัวอักษร",
                        maxlength: "รหัสเจ้าหน้าที่ ต้องมีความยาว 13 ตัวอักษร",
                    },
                    password: {
                        required: "กรุณากรอก รหัสผ่าน",
                        pattern: "รหัสผ่าน ห้ามมีภาษาไทย",
                        minlength: "รหัสผ่าน ต้องมี 8 ตัวอักษรขึ้นไป",
                        maxlength: "รหัสผ่าน ต้องไม่เกิน 255 ตัวอักษร",
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
                        adm_staff_id: $('#adm_staff_id').val(),
                        password: $('#password').val()
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


    <script>
        // ตรวจสอบว่ามี message ใน session หรือไม่
        <?php if (isset($_SESSION['login'])) { ?>
            Swal.fire({
                icon: 'warning',
                title: 'แจ้งเตือน',
                text: "<?php echo $_SESSION['login']; ?>",
                confirmButtonText: 'ตกลง'
            });
            <?php unset($_SESSION['login']); // ลบ session หลังจากแสดงแล้ว 
            ?>
        <?php } ?>
    </script>

</body>

</html>