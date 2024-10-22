<?php
$namePage = "ผู้ใช้งาน";
$nameWebsite = "ยืม-คืนหนังสือห้องสมุด";

require_once '../db/connect.php';

$admId = 1;
$admSuperAdmin = 1
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
                                <h6 class="m-0 font-weight-bold text-primary mb-2">ข้อมูลผู้ใช้งาน</h6>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUserModal">
                                    <i class="fa-solid fa-plus"></i>
                                    เพิ่มผู้ใช้งาน
                                </button>
                            </div>

                            <!-- Modal INSERT -->
                            <div class="modal fade" id="addUserModal" data-backdrop="static" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                                <form id="formAddUser" novalidate>
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addUserModalLabel">เพิ่มผู้ใช้งาน</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="usr_fname" class="form-label">ชื่อ : </label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="usr_fname" name="usr_fname" placeholder="กรุณาระบุ ชื่อจริง" maxlength="50">
                                                </div>
                                                <div class="form-group">
                                                    <label for="usr_lname" class="form-label">นามสกุล :</label> <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="usr_lname" name="usr_lname" placeholder="กรุณาระบุ นามสกุล" maxlength="50">
                                                </div>
                                                <div class="form-group">
                                                    <label for="usr_username" class="form-label">ชื่อผู้ใช้งาน :</label> <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="usr_username" name="usr_username" placeholder="กรุณาระบุ ชื่อผู้ใช้งาน" maxlength="50">
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
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">ประเภทผู้ใช้งาน</label>
                                                    <select class="form-control" id="usr_type" name="usr_type">
                                                        <option value="Student">นักเรียน</option>
                                                        <option value="Teacher">ครู</option>
                                                    </select>
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
                            <div class="modal fade" id="editUserModal" data-backdrop="static" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
                                <form id="formUserEdit" novalidate>
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editAdminModalLabel">แก้ไขผู้ดูแลระบบ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <input type="hidden" id="edit_usr_id" name="edit_usr_id">

                                                <div class="form-group">
                                                    <label for="edit_usr_fname" class="form-label">ชื่อ : </label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="edit_usr_fname" name="edit_usr_fname" placeholder="กรุณาระบุ ชื่อจริง" maxlength="50">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_usr_lname" class="form-label">นามสกุล :</label> <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="edit_usr_lname" name="edit_usr_lname" placeholder="กรุณาระบุ นามสกุล" maxlength="50">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_usr_username" class="form-label">ชื่อผู้ใช้งาน :</label> <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="edit_usr_username" name="edit_usr_username" placeholder="กรุณาระบุ ชื่อผู้ใช้งาน" maxlength="50" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">ประเภทผู้ใช้งาน</label>
                                                    <select class="form-control" id="edit_usr_type" name="edit_usr_type">
                                                        <option value="Student">นักเรียน</option>
                                                        <option value="Teacher">ครู</option>
                                                    </select>
                                                </div>

                                                <div class="form-group text-left">
                                                    <label for="preview_usr_old_img">รูปผู้ใช้งาน</label>
                                                    <input type="hidden" id="usr_old_profile" name="usr_old_profile" readonly>
                                                    <div class="text-center mt-2">
                                                        <img id="preview_usr_old_img" class="rounded-circle" alt="รูปผู้ใช้งาน" style="width: 100px; height: 100px; object-fit: cover">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_usr_new_profile" class="form-label">รูปผู้ใช้งานใหม่ :</label> <span class="text-danger">*</span>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="edit_usr_new_profile" name="edit_usr_new_profile" accept="image/png,image/jpg,image/jpeg" onchange="updateFileName(this)">
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
                                <table id="tableUser" class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">รูป</th>
                                            <th class="text-center">ชื่อผู้ใช้งาน</th>
                                            <th class="text-center">ชื่อ</th>
                                            <th class="text-center">นามสกุล</th>
                                            <th class="text-center">ประเภท</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- แสดงข้อมูลด้วย AJAX จากไฟล์ user_show_list.php -->
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
            $('#tableUser').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'ajax/user_show_list.php',
                    type: 'POST',
                    error: function(xhr, error, thrown) {
                        console.error("Error loading data: " + error);
                    }
                },
                columns: [{
                        data: 'usr_profile',
                        render: function(data, type, row) {
                            // ตรวจสอบว่าถ้า data เป็น null หรือว่าง ให้ใช้รูป default.png
                            let imageSrc = data ? `../uploads/img_user/${data}` : '../uploads/img_user/default.png';
                            return `<img src="${imageSrc}" alt="Profile Image" class="rounded-circle" style="width: 50px; height: 50px;">`;
                        },
                        className: 'text-center',
                    },
                    {
                        data: 'usr_username',
                        className: 'text-left',
                    },
                    {
                        data: 'usr_fname',
                        className: 'text-left',
                    },
                    {
                        data: 'usr_lname',
                        className: 'text-left',
                    },
                    {
                        data: 'usr_type',
                        render: function(data, type, row) {
                            if (data === 'Student') {
                                return '<span class="badge badge-pill badge-primary">Student</span>';
                            } else if (data === 'Teacher') {
                                return '<span class="badge badge-pill badge-info">Teacher</span>';
                            } else {
                                return data; // แสดงค่าเดิมหากไม่ใช่ Student หรือ Teacher
                            }
                        },
                        className: 'text-center',
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let buttons = `
                                    <button class="btn btn-warning btn-edit" 
                                        data-usr-id="${row.usr_id}" 
                                        data-usr-fname="${row.usr_fname}"
                                        data-usr-lname="${row.usr_lname}"
                                        data-usr-username="${row.usr_username}"
                                        data-usr-type="${row.usr_type}"
                                        data-usr-profile="${row.usr_profile}"
                                    >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                        แก้ไข
                                    </button>
                                `;

                            buttons += `<button class="btn btn-danger btn-delete" data-usr-id="${row.usr_id}" data-usr-profile="${row.usr_profile}"><i class="fa-solid fa-trash"></i> ลบ</button>`;

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
            $('#formAddUser').validate({
                rules: {
                    usr_fname: {
                        required: true,
                        maxlength: 50
                    },
                    usr_lname: {
                        required: true,
                        maxlength: 50,
                    },
                    usr_username: {
                        required: true,
                        pattern: /^[a-zA-Z0-9_]+$/, // ภาษาอังกฤษ ตัวเลข และ _ เท่านั้น
                        minlength: 6,
                        maxlength: 50,
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
                    usr_fname: {
                        required: "กรุณากรอก ชื่อจริง",
                        maxlength: "ชื่อจริง ต้องไม่เกิน 50 ตัวอักษร"
                    },
                    usr_lname: {
                        required: "กรุณากรอก นามสกุล",
                        maxlength: "นามสกุล ต้องไม่เกิน 50 ตัวอักษร"
                    },
                    usr_username: {
                        required: "กรุณากรอก รหัสเจ้าหน้าที่",
                        pattern: "ชื่อผู้ใช้ต้องเป็นภาษาอังกฤษ ตัวเลข หรือ _ เท่านั้น และห้ามมีช่องว่าง",
                        minlength: "ชื่อผู้ใช้ ต้องมีความยาว 6 ตัวอักษร",
                        maxlength: "ชื่อผู้ใช้ ต้องมีความยาว 50 ตัวอักษร",
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
                        usr_fname: $('#usr_fname').val(),
                        usr_lname: $('#usr_lname').val(),
                        usr_username: $('#usr_username').val(),
                        password: $('#password').val(),
                        confirmPassword: $('#confirmPassword').val(),
                        usr_type: $('#usr_type').val(),
                    };

                    // ส่งข้อมูลด้วย AJAX
                    $.ajax({
                        url: 'ajax/user_add.php', // ไฟล์ PHP ที่จะใช้เพิ่มข้อมูล
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            console.log(response); // ตรวจสอบการตอบกลับของเซิร์ฟเวอร์
                            if (response.success) {
                                $('#tableUser').DataTable().ajax.reload(); // โหลดข้อมูลใหม่ใน DataTable
                                $('#addUserModal').modal('hide'); // ปิด modal
                                $('#formAddUser')[0].reset(); // รีเซ็ตฟอร์ม

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
        $('#tableUser').on('click', '.btn-edit', function() {

            // แสดง Modal
            $('#editUserModal').modal('show');

            const usrId = $(this).data('usr-id');
            const usrFname = $(this).data('usr-fname');
            const usrLname = $(this).data('usr-lname');
            const usrUsername = $(this).data('usr-username');
            const usrType = $(this).data('usr-type');
            const usrOldProfile = $(this).data('usr-profile');


            // กรอกข้อมูลเดิมลงในฟอร์ม
            $('#edit_usr_id').val(usrId);
            $('#edit_usr_fname').val(usrFname);
            $('#edit_usr_lname').val(usrLname);
            $('#edit_usr_username').val(usrUsername);
            $('#edit_usr_type').val(usrType);
            $('#usr_old_profile').val(usrOldProfile);

            // ตั้งค่ารูปภาพ หากไม่มี ให้แสดง default.png
            if (usrOldProfile) {
                $('#preview_usr_old_img').attr('src', '../uploads/img_user/' + usrOldProfile);
            } else {
                $('#preview_usr_old_img').attr('src', '../uploads/img_user/default.png');
            }
        });

        // ใช้ jQuery Validation
        $('#formUserEdit').validate({
            rules: {
                edit_usr_fname: {
                    required: true,
                    maxlength: 50
                },
                edit_usr_lname: {
                    required: true,
                    maxlength: 50,
                },
                edit_usr_new_profile: {
                    accept: "image/png,image/jpg,image/jpeg" // เพิ่มการตรวจสอบประเภทไฟล์
                },
            },
            messages: {
                edit_usr_fname: {
                    required: "กรุณากรอก ชื่อจริง",
                    maxlength: "ชื่อจริง ต้องไม่เกิน 50 ตัวอักษร"
                },
                edit_usr_lname: {
                    required: "กรุณากรอก นามสกุล",
                    maxlength: "นามสกุล ต้องไม่เกิน 50 ตัวอักษร"
                },
                edit_usr_new_profile: {
                    accept: "ต้องเป็นไฟล์ png, jpg, jpeg เท่านั้น" // เพิ่มการตรวจสอบประเภทไฟล์
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

                formData.append('usrId', $('#edit_usr_id').val());
                formData.append('usrFname', $('#edit_usr_fname').val());
                formData.append('usrLname', $('#edit_usr_lname').val());
                formData.append('usrUsername', $('#edit_usr_username').val());
                formData.append('usrType', $('#edit_usr_type').val());
                formData.append('usrOldProfile', $('#usr_old_profile').val());

                // เพิ่มไฟล์โปรไฟล์ใหม่ (ถ้ามี)
                let newProfileFile = $('#edit_usr_new_profile')[0].files[0];
                if (newProfileFile) {
                    formData.append('usrNewProfile', newProfileFile);
                }

                // ส่งข้อมูลด้วย AJAX
                $.ajax({
                    url: 'ajax/user_edit.php',
                    type: 'POST',
                    data: formData,
                    processData: false, // ปิด processData สำหรับการส่งไฟล์
                    contentType: false, // ปิด contentType สำหรับการส่งไฟล์
                    success: function(response) {
                        console.log(response);
                        // ตรวจสอบการตอบกลับ
                        if (response.success) {
                            $('#tableUser').DataTable().ajax.reload();
                            $('#editUserModal').modal('hide');

                            // รีเซ็ตค่า input file และ label
                            $('#edit_usr_new_profile').val(''); // รีเซ็ต input file
                            $('#edit_usr_new_profile').next('.custom-file-label').html('choose file'); // รีเซ็ต label


                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: 'แก้ไขผู้ใช้เรียบร้อยแล้ว!',
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
        $('#tableUser').on('click', '.btn-delete', function() {
            const usrId = $(this).data('usr-id');
            const usrProfile = $(this).data('usr-profile');

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
                        url: 'ajax/user_delete.php', // ไฟล์ PHP ที่จะใช้ลบข้อมูล
                        type: 'POST',
                        data: {
                            usr_id: usrId,
                            usr_profile: usrProfile,
                        },
                        success: function(response) {
                            console.log(response); // ตรวจสอบการตอบกลับของเซิร์ฟเวอร์
                            if (response.success) {
                                $('#tableUser').DataTable().ajax.reload(); // โหลดข้อมูลใหม่ใน DataTable
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