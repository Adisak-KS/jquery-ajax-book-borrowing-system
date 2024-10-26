<?php
require_once '../db/connect.php';
require_once '../controller/AdminController.php';

?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="acc-fullName">Loading...</span>
                <img class="img-profile rounded-circle" src="../uploads/img_admin/default.png" id="acc-profileImage">
            </a>


            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editAccountProfileModal">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    ข้อมูลส่วนตัว
                </a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editAccountPasswordModal">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    รหัสผ่าน
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    ออกจากระบบ
                </a>

            </div>

        </li>
    </ul>

</nav>


<!-- Account Profile Modal-->
<div class="modal fade" id="editAccountProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <form id="formEditAccountProfile">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ข้อมูลส่วนตัว</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_acc_adm_fname" class="form-label">ชื่อของคุณ : </label><span class="text-danger">*</span>
                        <input type="text" class="form-control" id="edit_acc_adm_fname" name="edit_acc_adm_fname" placeholder="กรุณาระบุ ชื่อของคุณ" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label for="edit_acc_adm_lname" class="form-label">นามสกุลของคุณ : </label><span class="text-danger">*</span>
                        <input type="text" class="form-control" id="edit_acc_adm_lname" name="edit_acc_adm_lname" placeholder="กรุณาระบุ นามสกุลของคุณ" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label for="edit_acc_adm_staff_id" class="form-label">รหัสเจ้าหน้าที่ :</label> <span class="text-danger">*</span>
                        <input type="number" class="form-control" id="edit_acc_adm_staff_id" name="edit_acc_adm_staff_id" placeholder="กรุณาระบุ รหัสเจ้าหน้าที่ 13 หลัก">
                    </div>
                    <div class="form-group text-left">
                        <label for="preview_acc_adm_old_profile">รูปผู้ใช้งาน</label>
                        <input type="hidden" id="acc_adm_old_profile" name="acc_adm_old_profile" readonly>
                        <div class="text-center mt-2">
                            <img id="preview_acc_adm_old_profile" class="rounded-circle" alt="รูปผู้ใช้งาน" style="width: 100px; height: 100px; object-fit: cover">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_acc_adm_new_profile" class="form-label">รูปผู้ใช้งานใหม่ : </label><span class="text-danger">*</span>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="edit_acc_adm_new_profile" name="edit_acc_adm_new_profile" accept="image/png,image/jpg,image/jpeg" onchange="updateFileName(this)">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                    <button class="btn btn-primary" type="submit">บันทึกการเปลี่ยนแปลง</button>
                </div>

            </div>
        </div>
    </form>
</div>


<!-- Account Password Modal-->
<div class="modal fade" id="editAccountPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <form id="formEditAccountPassword">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รหัสผ่าน</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_acc_adm_old_password" class="form-label">รหัสผ่านเดิม :</label> <span class="text-danger">*</span>
                        <div class="input-group">
                            <input type="edit_acc_adm_old_password" class="form-control" id="edit_acc_adm_old_password" name="edit_acc_adm_old_password" placeholder="ระบุ รหัสผ่านเดิม" maxlength="255">
                            <button class="btn btn-outline-secondary rounded-0 password-toggle" type="button">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_acc_adm_new_password" class="form-label">รหัสผ่านใหม่ :</label> <span class="text-danger">*</span>
                        <div class="input-group">
                            <input type="password" class="form-control" id="edit_acc_adm_new_password" name="edit_acc_adm_new_password" placeholder="ระบุ รหัสผ่านใหม่" maxlength="255">
                            <button class="btn btn-outline-secondary rounded-0 password-toggle" type="button">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_acc_adm_confirm_password" class="form-label">ยืนยันรหัสผ่านใหม่ :</label> <span class="text-danger">*</span>
                        <div class="input-group">
                            <input type="password" class="form-control" id="edit_acc_adm_confirm_password" name="edit_acc_adm_confirm_password" placeholder="ระบุ รหัสผ่านใหม่ อีกครั้ง" maxlength="255">
                            <button class="btn btn-outline-secondary rounded-0 password-toggle" type="button">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                    <button class="btn btn-primary" type="submit">บันทึกการเปลี่ยนแปลง</button>
                </div>

            </div>
        </div>
    </form>
</div>


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">คุณต้องการออกจากระบบ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                คลิก <span class="text-danger">"ออกจากระบบ"</span> เพื่อยืนยัน การออกจากระบบ
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                <a class="btn btn-danger" href="logout.php">ออกจากระบบ</a>
            </div>
        </div>
    </div>
</div>


<script>
    // ฟังก์ชันสำหรับโหลดข้อมูลบัญชีผู้ใช้งาน
    function loadMyAccount() {
        $.ajax({
            url: 'ajax/login_account_data.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#acc-fullName').text(response.first_name + ' ' + response.last_name);

                    // ตรวจสอบว่า profileImage มีค่าไหม หากไม่มีใช้ default.png
                    if (response.profileImage) {
                        $('#acc-profileImage').attr('src', '../uploads/img_admin/' + response.profileImage);
                    } else {
                        $('#acc-profileImage').attr('src', '../uploads/img_admin/default.png');
                    }
                }
            },
        });
    }

    // เรียกใช้งานฟังก์ชันเมื่อเอกสารพร้อมใช้งาน
    $(document).ready(function() {
        loadMyAccount(); // เรียกใช้ฟังก์ชันนี้เมื่อเข้าใช้งานหน้า
    });
</script>

<!-- Edit Account Profile  -->
<script>
    // เมื่อเอกสารพร้อมใช้งาน
    $(document).ready(function() {
        // เมื่อเปิด Modal
        $('#editAccountProfileModal').on('show.bs.modal', function() {
            // เรียกข้อมูลบัญชีผู้ใช้งานผ่าน AJAX
            $.ajax({
                url: 'ajax/login_account_data.php', // ไฟล์ที่ดึงข้อมูล
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        // ตั้งค่าข้อมูลส่วนตัวที่ดึงมาใส่ในฟอร์ม
                        $('#edit_acc_adm_fname').val(response.first_name);
                        $('#edit_acc_adm_lname').val(response.last_name);
                        $('#edit_acc_adm_staff_id').val(response.staff_id);

                        // ตรวจสอบว่ามีรูปภาพหรือไม่ ถ้าไม่มีใช้ default.png
                        if (response.profileImage) {
                            $('#preview_acc_adm_old_profile').attr('src', '../uploads/img_admin/' + response.profileImage);
                        } else {
                            $('#preview_acc_adm_old_profile').attr('src', '../uploads/img_admin/default.png');
                        }

                        // เก็บชื่อรูปเก่าใน hidden input เพื่อใช้ในกระบวนการอัปเดตรูป
                        $('#acc_adm_old_profile').val(response.profileImage);
                    }
                }
            });

            // เรียกใช้งาน validate สำหรับฟอร์ม
            $('#formEditAccountProfile').validate({
                rules: {
                    edit_acc_adm_fname: {
                        required: true,
                        maxlength: 50
                    },
                    edit_acc_adm_lname: {
                        required: true,
                        maxlength: 50
                    },
                    edit_acc_adm_staff_id: {
                        required: true,
                        digits: true,
                        minlength: 13,
                        maxlength: 13
                    },
                    edit_acc_adm_new_profile: {
                        accept: "image/png,image/jpg,image/jpeg" // เพิ่มการตรวจสอบประเภทไฟล์
                    }
                },
                messages: {
                    edit_acc_adm_fname: {
                        required: "กรุณากรอก ชื่อจริง",
                        maxlength: "ชื่อจริง ต้องไม่เกิน 50 ตัวอักษร"
                    },
                    edit_acc_adm_lname: {
                        required: "กรุณากรอก นามสกุล",
                        maxlength: "นามสกุล ต้องไม่เกิน 50 ตัวอักษร"
                    },
                    edit_acc_adm_staff_id: {
                        required: "กรุณากรอก รหัสเจ้าหน้าที่",
                        digits: "รหัสเจ้าหน้าที่ ต้องเป็นตัวเลขจำนวนเต็ม",
                        minlength: "รหัสเจ้าหน้าที่ ต้องมีความยาว 13 ตัวอักษร",
                        maxlength: "รหัสเจ้าหน้าที่ ต้องมีความยาว 13 ตัวอักษร"
                    },
                    edit_acc_adm_new_profile: {
                        accept: "ต้องเป็นไฟล์นามสกุล .png, .jpg, .jpeg" // เพิ่มการตรวจสอบประเภทไฟล์
                    }
                },
                errorElement: 'p', // ใช้ <p> แสดงข้อความ error
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback'); // เพิ่มคลาสสำหรับจัดรูปแบบ
                    element.closest('.form-group').append(error); // แนบข้อความ error ไปที่ .form-group
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

                    formData.append('admFname', $('#edit_acc_adm_fname').val());
                    formData.append('admLname', $('#edit_acc_adm_lname').val());
                    formData.append('admStaffId', $('#edit_acc_adm_staff_id').val());
                    formData.append('admOldProfile', $('#acc_adm_old_profile').val());

                    // เพิ่มไฟล์โปรไฟล์ใหม่ (ถ้ามี)
                    let newProfileFile = $('#edit_acc_adm_new_profile')[0].files[0];

                    if (newProfileFile) {
                        formData.append('admNewProfile', newProfileFile);
                    }

                    // ส่งข้อมูลด้วย AJAX
                    $.ajax({
                        url: 'ajax/account_profile_edit.php',
                        type: 'POST',
                        data: formData,
                        processData: false, // ปิด processData สำหรับการส่งไฟล์
                        contentType: false, // ปิด contentType สำหรับการส่งไฟล์
                        success: function(response) {
                            console.log(response);
                            // ตรวจสอบการตอบกลับ
                            if (response.success) {
                                $('#editAccountProfileModal').modal('hide');

                                // รีเซ็ตค่า input file และ label
                                $('#edit_acc_adm_new_profile').val(''); // รีเซ็ต input file
                                $('#edit_acc_adm_new_profile').next('.custom-file-label').html('choose file'); // รีเซ็ต label

                                // เรียกใช้ฟังก์ชัน loadMyAccount เพื่อโหลดข้อมูลใหม่
                                loadMyAccount();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'สำเร็จ!',
                                    text: 'แก้ไขข้อมูลส่วนตัวเรียบร้อยแล้ว!',
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
        });
    });
</script>


<!-- Edit Account Password  -->
<script>
    $(document).ready(function() {
        $('#formEditAccountPassword').validate({
            rules: {
                edit_acc_adm_old_password: {
                    required: true,
                    pattern: /^[^\u0E00-\u0E7F]+$/,
                    minlength: 8,
                    maxlength: 255
                },
                edit_acc_adm_new_password: {
                    required: true,
                    pattern: /^[^\u0E00-\u0E7F]+$/,
                    minlength: 8,
                    maxlength: 255,
                    notEqualTo: "#edit_acc_adm_old_password"
                },
                edit_acc_adm_confirm_password: {
                    required: true,
                    pattern: /^[^\u0E00-\u0E7F]+$/,
                    minlength: 8,
                    maxlength: 255,
                    equalTo: "#edit_acc_adm_new_password"
                }
            },
            messages: {
                edit_acc_adm_old_password: {
                    required: "กรุณากรอก รหัสผ่านเก่า",
                    minlength: "รหัสผ่านเก่า ต้องไม่เกิน 8 ตัวอักษร",
                    maxlength: "รหัสผ่านเก่า ต้องไม่เกิน 255 ตัวอักษร"
                },
                edit_acc_adm_new_password: {
                    required: "กรุณากรอก รหัสผ่านใหม่",
                    minlength: "รหัสผ่านใหม่ ต้องไม่เกิน 8 ตัวอักษร",
                    maxlength: "รหัสผ่านใหม่ ต้องไม่เกิน 255 ตัวอักษร",
                    notEqualTo: "รหัสผ่านใหม่ ต้องไม่เหมือนกับ รหัสผ่านเก่า"
                },
                edit_acc_adm_confirm_password: {
                    required: "กรุณากรอก ยืนยันรหัสผ่านใหม่",
                    minlength: "รหัสผ่านใหม่ ต้องไม่เกิน 8 ตัวอักษร",
                    maxlength: "รหัสผ่านใหม่ ต้องไม่เกิน 255 ตัวอักษร",
                    equalTo: "ยืนยันรหัสผ่าน ต้องตรงกับ รหัสผ่านใหม่"
                },
            },
            errorElement: 'p', // ใช้ <p> แสดงข้อความ error
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback'); // เพิ่มคลาสสำหรับจัดรูปแบบ
                element.closest('.form-group').append(error); // แนบข้อความ error ไปที่ .form-group
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            errorClass: 'text-danger',

            submitHandler: function(form) {

                let formData = {
                    edit_acc_adm_old_password: $('#edit_acc_adm_old_password').val(),
                    edit_acc_adm_new_password: $('#edit_acc_adm_new_password').val(),
                    edit_acc_adm_confirm_password: $('#edit_acc_adm_confirm_password').val()
                };

                $.ajax({
                    url: 'ajax/account_password_edit.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        // ตรวจสอบการตอบกลับ
                        if (response.success) {
                            $('#formEditAccountPassword')[0].reset(); // รีเซ็ตฟอร์ม
                            $('#editAccountPasswordModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: 'แก้ไขรหัสผ่านเรียบร้อยแล้ว!',
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
                }); // ปิด $.ajax

            } // ปิด submitHandler
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