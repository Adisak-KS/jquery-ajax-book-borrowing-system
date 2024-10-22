<?php
$namePage = "ผู้ดูแลระบบ";
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
                                <h6 class="m-0 font-weight-bold text-primary mb-2">ข้อมูลผู้ดูแลระบบ</h6>
                                
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAdminModal">
                                    <i class="fa-solid fa-plus"></i>
                                    เพิ่มผู้ดูแลระบบ
                                </button>
                            </div>

                            <!-- Modal INSERT -->
                            <div class="modal fade" id="addAdminModal" data-backdrop="static" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
                                <form id="formAddAdmin" novalidate>
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addAdminModalLabel">เพิ่มผู้ดูแลระบบ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="adm_fname" class="form-label">ชื่อ : </label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="adm_fname" name="adm_fname" placeholder="กรุณาระบุ ชื่อจริง" maxlength="50">
                                                </div>
                                                <div class="form-group">
                                                    <label for="adm_lname" class="form-label">นามสกุล :</label> <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="adm_lname" name="adm_lname" placeholder="กรุณาระบุ นามสกุล" maxlength="50">
                                                </div>
                                                <div class="form-group">
                                                    <label for="adm_staff_id" class="form-label">รหัสเจ้าหน้าที่ :</label> <span class="text-danger">*</span>
                                                    <input type="number" class="form-control" id="adm_staff_id" name="adm_staff_id" placeholder="กรุณาระบุ รหัสเจ้าหน้าที่ 13 หลัก">
                                                </div>
                                                <div class="form-group">
                                                    <label for="password" class="form-label">รหัสผ่าน :</label> <span class="text-danger">*</span>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="password" name="password" placeholder="ระบุ รหัสผ่าน" maxlength="255">
                                                        <button class="btn btn-outline-secondary rounded-0 password-toggle" type="button">
                                                            <i class="fas fa-eye-slash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password" class="form-label">ยืนยันรหัสผ่าน :</label> <span class="text-danger">*</span>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="ระบุ รหัสผ่าน อีกครั้ง" maxlength="255">
                                                        <button class="btn btn-outline-secondary rounded-0 password-toggle" type="button">
                                                            <i class="fas fa-eye-slash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="fa-solid fa-xmark"></i>
                                                    ปิด
                                                </button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa-solid fa-plus"></i>
                                                    บันทึก
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <!-- Modal EDIT -->
                            <div class="modal fade" id="editAdminModal" data-backdrop="static" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
                                <form id="formAdminEdit" novalidate>
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editAdminModalLabel">แก้ไขผู้ดูแลระบบ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <input type="hidden" id="edit_adm_id" name="edit_adm_id">

                                                <div class="form-group">
                                                    <label for="edit_adm_fname" class="form-label">ชื่อ : </label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="edit_adm_fname" name="edit_adm_fname" placeholder="กรุณาระบุ ชื่อจริง" maxlength="50">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_adm_lname" class="form-label">นามสกุล :</label> <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="edit_adm_lname" name="edit_adm_lname" placeholder="กรุณาระบุ นามสกุล" maxlength="50">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_adm_staff_id" class="form-label">รหัสเจ้าหน้าที่ :</label> <span class="text-danger">*</span>
                                                    <input type="number" class="form-control" id="edit_adm_staff_id" name="edit_adm_staff_id" placeholder="กรุณาระบุ รหัสเจ้าหน้าที่ 13 หลัก" <?php if ($_SESSION['adm_super_admin'] != 1) {
                                                                                                                                                                                                    echo 'readonly';
                                                                                                                                                                                                } ?>>
                                                </div>
                                                <div class="form-group text-left">
                                                    <label for="preview_adm_old_img">รูปผู้ใช้งาน</label>
                                                    <input type="hidden" id="adm_old_profile" name="adm_old_profile" readonly>
                                                    <div class="text-center mt-2">
                                                        <img id="preview_adm_old_img" class="rounded-circle" alt="รูปผู้ใช้งาน" style="width: 100px; height: 100px; object-fit: cover">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_adm_new_profile" class="form-label">รูปผู้ใช้งาน :</label> <span class="text-danger">*</span>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="edit_adm_new_profile" name="edit_adm_new_profile" accept="image/png,image/jpg,image/jpeg" onchange="updateFileName(this)">
                                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        <i class="fa-solid fa-xmark"></i>
                                                        ปิด
                                                    </button>
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                        แก้ไข
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>


                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tableAdmin" class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">รูป</th>
                                            <th class="text-center">รหัสเจ้าหน้าที่</th>
                                            <th class="text-center">ชื่อ</th>
                                            <th class="text-center">นามสกุล</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- แสดงข้อมูลด้วย AJAX จากไฟล์ admin_show_list.php -->
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
            const admSuperAdmin = <?php echo $_SESSION['adm_super_admin']; ?>;

            $('#tableAdmin').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'ajax/admin_show_list.php',
                    type: 'POST',
                    error: function(xhr, error, thrown) {
                        console.error("Error loading data: " + error);
                    }
                },
                columns: [{
                        data: 'adm_profile',
                        render: function(data, type, row) {
                            // ตรวจสอบว่าถ้า data เป็น null หรือว่าง ให้ใช้รูป default.png
                            let imageSrc = data ? `../uploads/img_admin/${data}` : '../uploads/img_admin/default.png';
                            return `<img src="${imageSrc}" alt="Profile Image" class="rounded-circle" style="width: 50px; height: 50px;">`;
                        },
                        className: 'text-center',
                    },
                    {
                        data: 'adm_staff_id',
                        className: 'text-left',
                    },
                    {
                        data: 'adm_fname',
                        className: 'text-left',
                    },
                    {
                        data: 'adm_lname',
                        className: 'text-left',
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let buttons = `
                                    <button class="btn btn-warning btn-edit" 
                                        data-adm-id="${row.adm_id}" 
                                        data-adm-fname="${row.adm_fname}"
                                        data-adm-lname="${row.adm_lname}"
                                        data-adm-staff-id="${row.adm_staff_id}"
                                        data-adm-profile="${row.adm_profile}"
                                    >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                        แก้ไข
                                    </button>
                                `;

                            // แสดงปุ่มลบเฉพาะเมื่อ admSuperAdmin เท่ากับ 1
                            if (admSuperAdmin === 1) {
                                buttons += `<button class="btn btn-danger btn-delete" data-adm-id="${row.adm_id}" data-adm-profile="${row.adm_profile}"><i class="fa-solid fa-trash"></i> ลบ</button>`;
                            }

                            return buttons;
                        },
                        className: 'text-center'
                    }
                ]
            })
        });
    </script>

    <!-- INSERT -->
    <script>
        $(document).ready(function() {
            // กำหนดการตรวจสอบฟอร์ม
            $('#formAddAdmin').validate({
                rules: {
                    adm_fname: {
                        required: true,
                        maxlength: 50
                    },
                    adm_lname: {
                        required: true,
                        maxlength: 50,
                    },
                    adm_staff_id: {
                        required: true,
                        digits: true,
                        minlength: 13,
                        maxlength: 13,
                    },
                    password: {
                        required: true,
                        pattern: /^[^\u0E00-\u0E7F]+$/,
                        minlength: 8,
                        maxlength: 255
                    },
                    confirmPassword: {
                        required: true,
                        minlength: 8,
                        maxlength: 255,
                        equalTo: "#password"
                    }
                },
                messages: {
                    adm_fname: {
                        required: "กรุณากรอก ชื่อจริง",
                        maxlength: "ชื่อจริง ต้องไม่เกิน 50 ตัวอักษร"
                    },
                    adm_lname: {
                        required: "กรุณากรอก นามสกุล",
                        maxlength: "นามสกุล ต้องไม่เกิน 50 ตัวอักษร"
                    },
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
                    confirmPassword: {
                        required: "กรุณากรอก รหัสผ่านอีกครั้ง",
                        minlength: "รหัสผ่าน ต้องมี 8 ตัวอักษรขึ้นไป",
                        maxlength: "รหัสผ่าน ต้องไม่เกิน 255 ตัวอักษร",
                        equalTo: "รหัสผ่านไม่ตรงกัน"
                    },
                },
                errorElement: 'p',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                // ปรับแต่งสีของข้อความ error
                errorClass: 'text-danger',

                submitHandler: function(form) {
                    // ถ้าผ่านการตรวจสอบให้ส่งฟอร์ม
                    let formData = {
                        adm_fname: $('#adm_fname').val(),
                        adm_lname: $('#adm_lname').val(),
                        adm_staff_id: $('#adm_staff_id').val(),
                        password: $('#password').val(),
                        confirmPassword: $('#confirmPassword').val(),
                    };

                    // ส่งข้อมูลด้วย AJAX
                    $.ajax({
                        url: 'ajax/admin_add.php', // ไฟล์ PHP ที่จะใช้เพิ่มข้อมูล
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            console.log(response); // ตรวจสอบการตอบกลับของเซิร์ฟเวอร์
                            if (response.success) {
                                $('#tableAdmin').DataTable().ajax.reload(); // โหลดข้อมูลใหม่ใน DataTable
                                $('#addAdminModal').modal('hide'); // ปิด modal
                                $('#formAddAdmin')[0].reset(); // รีเซ็ตฟอร์ม

                                Swal.fire({
                                    icon: 'success',
                                    title: 'เพิ่มข้อมูลเรียบร้อย!',
                                    text: response.message,
                                    confirmButtonText: 'ตกลง'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด!',
                                    text: response.message,
                                    confirmButtonText: 'ตกลง'
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR.responseText); // แสดงข้อผิดพลาดของการส่งข้อมูล
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    });
                }
            });
        });
    </script>

    <!-- Edit -->
    <script>
        // จับเหตุการณ์การคลิกปุ่ม "แก้ไข"
        $('#tableAdmin').on('click', '.btn-edit', function() {

            // แสดง Modal
            $('#editAdminModal').modal('show');

            const admId = $(this).data('adm-id');
            const admFname = $(this).data('adm-fname');
            const admLname = $(this).data('adm-lname');
            const admStaffId = $(this).data('adm-staff-id');
            const admOldProfile = $(this).data('adm-profile');


            // กรอกข้อมูลเดิมลงในฟอร์ม
            $('#edit_adm_id').val(admId);
            $('#edit_adm_fname').val(admFname);
            $('#edit_adm_lname').val(admLname);
            $('#edit_adm_staff_id').val(admStaffId);
            $('#adm_old_profile').val(admOldProfile);
            
            // ตั้งค่ารูปภาพ หากไม่มี ให้แสดง default.png
            if (admOldProfile) {
                $('#preview_adm_old_img').attr('src', '../uploads/img_admin/' + admOldProfile);
            } else {
                $('#preview_adm_old_img').attr('src', '../uploads/img_admin/default.png');
            }

        });

        // ใช้ jQuery Validation
        $('#formAdminEdit').validate({
            rules: {
                edit_adm_fname: {
                    required: true,
                    maxlength: 50
                },
                edit_adm_lname: {
                    required: true,
                    maxlength: 50,
                },
                edit_adm_staff_id: {
                    required: true,
                    digits: true,
                    minlength: 13,
                    maxlength: 13,
                },
                edit_adm_new_profile: {
                    accept: "image/png,image/jpg,image/jpeg" // เพิ่มการตรวจสอบประเภทไฟล์
                },
            },
            messages: {
                edit_adm_fname: {
                    required: "กรุณากรอก ชื่อจริง",
                    maxlength: "ชื่อจริง ต้องไม่เกิน 50 ตัวอักษร"
                },
                edit_adm_lname: {
                    required: "กรุณากรอก นามสกุล",
                    maxlength: "นามสกุล ต้องไม่เกิน 50 ตัวอักษร"
                },
                edit_adm_staff_id: {
                    required: "กรุณากรอก รหัสเจ้าหน้าที่",
                    digits: "รหัสเจ้าหน้าที่ ต้องเป็นตัวเลขจำนวนเต็ม",
                    minlength: "รหัสเจ้าหน้าที่ ต้องมีความยาว 13 ตัวอักษร",
                    maxlength: "รหัสเจ้าหน้าที่ ต้องมีความยาว 13 ตัวอักษร",
                },
                edit_adm_new_profile: {
                    accept: "ต้องเป็นไฟล์นามสกุล .png, .jpg, .jpeg" // เพิ่มการตรวจสอบประเภทไฟล์
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            // ปรับแต่งสีของข้อความ error
            errorClass: 'text-danger',

            submitHandler: function(form) {

                // สร้าง FormData เพื่อส่งข้อมูลพร้อมไฟล์
                let formData = new FormData();

                formData.append('admId', $('#edit_adm_id').val());
                formData.append('admFname', $('#edit_adm_fname').val());
                formData.append('admLname', $('#edit_adm_lname').val());
                formData.append('admStaffId', $('#edit_adm_staff_id').val());
                formData.append('admOldProfile', $('#adm_old_profile').val());

                // เพิ่มไฟล์โปรไฟล์ใหม่ (ถ้ามี)
                let newProfileFile = $('#edit_adm_new_profile')[0].files[0];
                if (newProfileFile) {
                    formData.append('admNewProfile', newProfileFile);
                }

                // ส่งข้อมูลด้วย AJAX
                $.ajax({
                    url: 'ajax/admin_edit.php',
                    type: 'POST',
                    data: formData,
                    processData: false, // ปิด processData สำหรับการส่งไฟล์
                    contentType: false, // ปิด contentType สำหรับการส่งไฟล์
                    success: function(response) {
                        console.log(response);
                        // ตรวจสอบการตอบกลับ
                        if (response.success) {
                            $('#tableAdmin').DataTable().ajax.reload();
                            $('#editAdminModal').modal('hide');

                            // รีเซ็ตค่า input file และ label
                            $('#edit_adm_new_profile').val(''); // รีเซ็ต input file
                            $('#edit_adm_new_profile').next('.custom-file-label').html('choose file'); // รีเซ็ต label


                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: 'แก้ไขผู้ดูแลระบบเรียบร้อยแล้ว!',
                                confirmButtonText: 'ตกลง'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: response.message,
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            text: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
                            confirmButtonText: 'ตกลง'
                        });
                    }
                });
            }

        });
    </script>

    <!-- Delete  -->
    <script>
        // จับเหตุการณ์การคลิกปุ่ม "ลบ"
        $('#tableAdmin').on('click', '.btn-delete', function() {
            const admId = $(this).data('adm-id');
            const admProfile = $(this).data('adm-profile');

            // แสดง SweetAlert2 เพื่อยืนยันการลบ
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณจะไม่สามารถกู้คืนข้อมูลนี้ได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ส่งข้อมูลด้วย AJAX เพื่อลบข้อมูล
                    $.ajax({
                        url: 'ajax/admin_delete.php', // ไฟล์ PHP ที่จะใช้ลบข้อมูล
                        type: 'POST',
                        data: {
                            adm_id: admId,
                            adm_profile: admProfile,
                        },
                        success: function(response) {
                            console.log(response); // ตรวจสอบการตอบกลับของเซิร์ฟเวอร์
                            if (response.success) {
                                $('#tableAdmin').DataTable().ajax.reload(); // โหลดข้อมูลใหม่ใน DataTable
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ลบสำเร็จ!',
                                    text: 'ข้อมูลได้ถูกลบเรียบร้อยแล้ว.',
                                    confirmButtonText: 'ตกลง'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด!',
                                    text: response.message,
                                    confirmButtonText: 'ตกลง'
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR.responseText); // แสดงข้อผิดพลาดของการส่งข้อมูล
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    });
                }
            });
        });
    </script>


    <script>
        // ใช้ jQuery ในการเปลี่ยนข้อความของ label เมื่อเลือกไฟล์
        $('.custom-file-input').on('change', function() {
            // ดึงชื่อไฟล์ที่ถูกเลือก
            let fileName = $(this).val().split('\\').pop();
            // อัปเดต label ด้วยชื่อไฟล์
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
</body>

</html>