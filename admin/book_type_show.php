<?php
$namePage = "ประเภทหนังสือ";
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
                                <h6 class="m-0 font-weight-bold text-primary mb-2">ข้อมูลประเภทหนังสือ</h6>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addBookTypeModal">
                                    <i class="fa-solid fa-plus"></i>
                                    เพิ่มประเภทหนังสือ
                                </button>
                            </div>

                            <!-- Modal INSERT -->
                            <div class="modal fade" id="addBookTypeModal" data-backdrop="static" tabindex="-1" aria-labelledby="addBookTypeModalLabel" aria-hidden="true">
                                <form id="formAddBookType" novalidate>
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addBookTypeModalLabel">เพิ่มประเภทหนังสือ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="bt_name" class="form-label">ชื่อประเภท : </label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="bt_name" name="bt_name" placeholder="กรุณาระบุ ชื่อประเภทหนังสือ" maxlength="50">
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
                                    </div>
                                </form>
                            </div>


                            <!-- Modal EDIT -->
                            <div class="modal fade" id="editBookTypeModal" data-backdrop="static" tabindex="-1" aria-labelledby="editBookTypeModalLabel" aria-hidden="true">
                                <form id="formBookTypeEdit" novalidate>
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editBookTypeModalLabel">แก้ไขประเภทหนังสือ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <input type="hidden" id="edit_bt_id" name="edit_bt_id">
                                                <div class="form-group">
                                                    <label for="edit_bt_name" class="form-label">ชื่อประเภท : </label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="edit_bt_name" name="edit_bt_name" placeholder="กรุณาระบุ ชื่อประเภทหนังสือ" maxlength="50">
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
                                <table id="tableBookType" class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">รหัส</th>
                                            <th class="text-center">ชื่อประเภท</th>
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
            $('#tableBookType').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'ajax/book_type_show_list.php',
                    type: 'POST',
                    error: function(xhr, error, thrown) {
                        console.error("Error loading data: " + error);
                    }
                },
                columns: [{
                        data: 'bt_id',
                        className: 'text-center',
                    },
                    {
                        data: 'bt_name',
                        className: 'text-left',
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let buttons = `
                                    <button class="btn btn-warning btn-edit" 
                                        data-bt-id="${row.bt_id}" 
                                        data-bt-name="${row.bt_name}"
                                    >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                        แก้ไข
                                    </button>
                                `;

                            buttons += `<button class="btn btn-danger btn-delete" data-bt-id="${row.bt_id}"><i class="fa-solid fa-trash"></i> ลบ</button>`;

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
            $('#formAddBookType').validate({
                rules: {
                    bt_name: {
                        required: true,
                        maxlength: 50
                    },
                },
                messages: {
                    bt_name: {
                        required: "กรุณากรอก ชื่อประเภท",
                        maxlength: "ชื่อจริง ต้องไม่เกิน 50 ตัวอักษร"
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
                        bt_name: $('#bt_name').val(),
                    };

                    // ส่งข้อมูลด้วย AJAX
                    $.ajax({
                        url: 'ajax/book_type_add.php', // ไฟล์ PHP ที่จะใช้เพิ่มข้อมูล
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            console.log(response); // ตรวจสอบการตอบกลับของเซิร์ฟเวอร์
                            if (response.success) {
                                $('#tableBookType').DataTable().ajax.reload(); // โหลดข้อมูลใหม่ใน DataTable
                                $('#addBookTypeModal').modal('hide'); // ปิด modal
                                $('#formAddBookType')[0].reset(); // รีเซ็ตฟอร์ม

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
        $('#tableBookType').on('click', '.btn-edit', function() {

            const btId = $(this).data('bt-id');
            const btName = $(this).data('bt-name');

            // แสดง Modal
            $('#editBookTypeModal').modal('show');

            // กรอกข้อมูลเดิมลงในฟอร์ม
            $('#edit_bt_id').val(btId);
            $('#edit_bt_name').val(btName);

        });

        // ใช้ jQuery Validation
        $('#formBookTypeEdit').validate({
            rules: {
                edit_bt_name: {
                    required: true,
                    maxlength: 50
                },
            },
            messages: {
                edit_bt_name: {
                    required: "กรุณากรอก ชื่อจริง",
                    maxlength: "ชื่อจริง ต้องไม่เกิน 50 ตัวอักษร"
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

                // สร้าง FormData เพื่อส่งข้อมูล
                let formData = {
                    btId: $('#edit_bt_id').val(),
                    btName: $('#edit_bt_name').val()
                };

                // ส่งข้อมูลด้วย AJAX
                $.ajax({
                    url: 'ajax/book_type_edit.php',
                    type: 'POST',
                    data: formData,

                    success: function(response) {
                        console.log(response);
                        // ตรวจสอบการตอบกลับ
                        if (response.success) {
                            $('#tableBookType').DataTable().ajax.reload();
                            $('#editBookTypeModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: 'แก้ไขประเภทเรียบร้อยแล้ว!',
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
        $('#tableBookType').on('click', '.btn-delete', function() {
            const btId = $(this).data('bt-id');

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
                        url: 'ajax/book_type_delete.php', // ไฟล์ PHP ที่จะใช้ลบข้อมูล
                        type: 'POST',
                        data: {
                            bt_id: btId,
                        },
                        success: function(response) {
                            console.log(response); // ตรวจสอบการตอบกลับของเซิร์ฟเวอร์
                            if (response.success) {
                                $('#tableBookType').DataTable().ajax.reload(); // โหลดข้อมูลใหม่ใน DataTable
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