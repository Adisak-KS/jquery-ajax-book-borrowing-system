<?php
$namePage = "หนังสือ";
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
                                <h6 class="m-0 font-weight-bold text-primary mb-2">ข้อมูลผู้ใช้งาน</h6>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addBookModal">
                                    <i class="fa-solid fa-plus"></i>
                                    เพิ่มหนังสือ
                                </button>
                            </div>

                            <!-- Modal INSERT -->
                            <div class="modal fade" id="addBookModal" data-backdrop="static" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
                                <form id="formAddBook" novalidate>
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addBookModalLabel">เพิ่มหนังสือ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="bk_name" class="form-label">ชื่อหนังสือ : </label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="bk_name" name="bk_name" placeholder="กรุณาระบุ ชื่อหนังสือ" maxlength="100">
                                                </div>
                                                <div class="form-group">
                                                    <label for="bk_quantity" class="form-label">จำนวน :</label> <span class="text-danger">*</span>
                                                    <input type="number" class="form-control" id="bk_quantity" name="bk_quantity" placeholder="กรุณาระบุ จำนวน">
                                                </div>
                                                <div class="form-group">
                                                    <label for="bk_student_loan_period" class="form-label">จำนวนวันให้ยืม ของนักเรียน :</label> <span class="text-danger">*</span>
                                                    <input type="number" class="form-control" id="bk_student_loan_period" name="bk_student_loan_period" placeholder="กรุณาระบุ จำนวนวันให้ยืมสูงสุดของนักเรียน" value="7">
                                                </div>
                                                <div class="form-group">
                                                    <label for="bk_teacher_loan_period" class="form-label">จำนวนวันให้ยืม ของครู :</label> <span class="text-danger">*</span>
                                                    <input type="number" class="form-control" id="bk_teacher_loan_period" name="bk_teacher_loan_period" placeholder="กรุณาระบุ จำนวนวันให้ยืมสูงสุดของครู" value="14">
                                                </div>
                                                <div class="form-group">
                                                    <label for="bk_detail" class="form-label">รายละเอียด :</label> <span class="text-danger">*</span>
                                                    <textarea class="form-control" id="bk_detail" name="bk_detail" placeholder="กรุณาระบุ รายละเอียด"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bk_publisher" class="form-label">สำนักพิมพ์ :</label> <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="bk_publisher" name="bk_publisher" placeholder="กรุณาระบุ สำนักพิมพ์" maxlength="100">
                                                </div>
                                                <div class="form-group">
                                                    <label for="bk_author" class="form-label">ผู้แต่ง :</label> <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="bk_author" name="bk_author" placeholder="กรุณาระบุ ผู้แต่ง" maxlength="100">
                                                </div>
                                                <div class="form-group">
                                                    <label for="bk_author" class="form-label">ประเภทหนังสือ :</label> <span class="text-danger">*</span>
                                                    <select class="form-control" id="bt_id" name="bt_id">
                                                        <option value="">กรุณาเลือก ประเภทหนังสือ</option>
                                                        <!-- <option value="">แสดงข้อมูลด้วย AJAX จากไฟล์  get_book_types.php</option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bk_show" class="form-label">สถานะ :</label> <span class="text-danger">*</span>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="bk_show" id="bk_show1" value="1" checked>
                                                        <label class="form-check-label" for=bk_show1">
                                                            แสดง
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="bk_show" id="bk_show2" value="0">
                                                        <label class="form-check-label" for=bk_show2">
                                                            ไม่แสดง
                                                        </label>
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
                            <div class="modal fade" id="editBookModal" data-backdrop="static" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
                                <form id="formBookEdit" novalidate>
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editAdminModalLabel">แก้ไขหนังสือ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <input type="hidden" id="edit_bk_id" name="edit_bk_id">

                                                <div class="form-group">
                                                    <label for="edit_bk_name" class="form-label">ชื่อหนังสือ : </label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="edit_bk_name" name="edit_bk_name" placeholder="กรุณาระบุ ชื่อหนังสือ" maxlength="100">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_bk_quantity" class="form-label">จำนวน :</label> <span class="text-danger">*</span>
                                                    <input type="number" class="form-control" id="edit_bk_quantity" name="edit_bk_quantity" placeholder="กรุณาระบุ จำนวน">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_bk_student_loan_period" class="form-label">จำนวนวันให้ยืม ของนักเรียน :</label> <span class="text-danger">*</span>
                                                    <input type="number" class="form-control" id="edit_bk_student_loan_period" name="edit_bk_student_loan_period" placeholder="กรุณาระบุ จำนวนวันให้ยืมสูงสุดของนักเรียน">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_bk_teacher_loan_period" class="form-label">จำนวนวันให้ยืม ของครู :</label> <span class="text-danger">*</span>
                                                    <input type="number" class="form-control" id="edit_bk_teacher_loan_period" name="edit_bk_teacher_loan_period" placeholder="กรุณาระบุ จำนวนวันให้ยืมสูงสุดของครู">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_bk_detail" class="form-label">รายละเอียด :</label> <span class="text-danger">*</span>
                                                    <textarea class="form-control" id="edit_bk_detail" name="edit_bk_detail" placeholder="กรุณาระบุ รายละเอียด"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_bk_publisher" class="form-label">สำนักพิมพ์ :</label> <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="edit_bk_publisher" name="edit_bk_publisher" placeholder="กรุณาระบุ สำนักพิมพ์" maxlength="100">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_bk_author" class="form-label">ผู้แต่ง :</label> <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="edit_bk_author" name="edit_bk_author" placeholder="กรุณาระบุ ผู้แต่ง" maxlength="100">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_bt_id" class="form-label">ประเภทหนังสือ :</label> <span class="text-danger">*</span>
                                                    <select class="form-control" id="edit_bt_id" name="edit_bt_id">
                                                        <option value="">กรุณาเลือก ประเภทหนังสือ</option>
                                                        <!-- <option value="">แสดงข้อมูลด้วย AJAX จากไฟล์  get_book_types.php</option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group text-left">
                                                    <label for="preview_bk_old_img">รูปหนังสือ</label>
                                                    <input type="hidden" id="bk_old_img" name="bk_old_img" readonly>
                                                    <div class="text-center mt-2">
                                                        <img id="preview_bk_old_img" alt="รูปหนังสือ" style="width: 100px; height: 150px; object-fit: cover">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_bk_new_img" class="form-label">รูปหนังสือใหม่ :</label><span class="text-danger">ขนาดไม่เกิน 2 MB</span>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="edit_bk_new_img" name="edit_bk_new_img" accept="image/png,image/jpg,image/jpeg">
                                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_bk_show" class="form-label">สถานะ :</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="edit_bk_show" id="edit_bk_show1" value="1">
                                                        <label class="form-check-label" for=edit_bk_show1">
                                                            แสดง
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="edit_bk_show" id="edit_bk_show2" value="0">
                                                        <label class="form-check-label" for=edit_bk_show2">
                                                            ไม่แสดง
                                                        </label>
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
                                <table id="tableBook" class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">รูป</th>
                                            <th class="text-center">ชื่อหนังสือ</th>
                                            <th class="text-center">จำนวน</th>
                                            <th class="text-center">ประเภท</th>
                                            <th class="text-center">สถานะ</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- แสดงข้อมูลด้วย AJAX จากไฟล์  book_show_list.php -->
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
            $('#tableBook').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'ajax/book_show_list.php',
                    type: 'POST',
                    error: function(xhr, error, thrown) {
                        console.error("Error loading data: " + error);
                    }
                },
                columns: [{
                        data: 'bk_img',
                        render: function(data, type, row) {
                            // ตรวจสอบว่าถ้า data เป็น null หรือว่าง ให้ใช้รูป default.png
                            let imageSrc = data ? `../uploads/img_book/${data}` : '../uploads/img_book/default.png';
                            return `<img src="${imageSrc}" alt="Product Image" class="rounded" style="width: 50px; height: 50px;">`;
                        },
                        className: 'text-center',
                    },
                    {
                        data: 'bk_name',
                        className: 'text-left',
                    },
                    {
                        data: 'bk_quantity',
                        render: function(data, type, row) {
                            // Format ตัวเลขให้มี comma separator
                            return new Intl.NumberFormat().format(data);
                        },
                        className: 'text-center',
                    },
                    {
                        data: 'bt_name',
                        render: function(data, type, row) {
                            return data === null ? 'ไม่พบข้อมูล' : data;
                        },
                        className: 'text-center',
                    },
                    {
                        data: 'bk_show',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return '<span class="badge badge-pill badge-success">แสดง</span>';
                            } else if (data == 0) {
                                return '<span class="badge badge-pill badge-danger">ไม่แสดง</span>';
                            } else {
                                return data; // แสดงค่าเดิมหากไม่ใช่
                            }
                        },
                        className: 'text-center',
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let buttons = `
                                    <button class="btn btn-warning btn-edit" 
                                        data-bk-id="${row.bk_id}" 
                                        data-bk-name="${row.bk_name}"
                                        data-bk-quantity="${row.bk_quantity}"
                                        data-bk-student-loan-period="${row.bk_student_loan_period}"
                                        data-bk-teacher-loan-period="${row.bk_teacher_loan_period}"
                                        data-bk-detail="${row.bk_detail}"
                                        data-bk-publisher="${row.bk_publisher}"
                                        data-bk-author="${row.bk_author}"
                                        data-bt-id="${row.bt_id}"
                                        data-bk-show="${row.bk_show}"
                                        data-bk-img="${row.bk_img}"
                                    >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                        แก้ไข
                                    </button>
                                `;

                            buttons += `<button class="btn btn-danger btn-delete" data-bk-id="${row.bk_id}" data-bk-img="${row.bk_img}"><i class="fa-solid fa-trash"></i> ลบ</button>`;

                            return buttons;
                        },
                        className: 'text-center'
                    }
                ]
            })
        });
    </script>

    <!-- SELECT BOOK TYPE  -->
    <script>
        $(document).ready(function() {
            // ดึงข้อมูลประเภทหนังสือด้วย AJAX
            $.ajax({
                url: 'ajax/get_book_types.php', // ไฟล์ PHP ที่จะใช้ดึงข้อมูล
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // วนลูปข้อมูลที่ได้จากเซิร์ฟเวอร์
                    $.each(response, function(index, bookType) {
                        // เพิ่มตัวเลือกใน select
                        $('#bt_id').append('<option value="' + bookType.bt_id + '">' + bookType.bt_name + '</option>');
                        $('#edit_bt_id').append('<option value="' + bookType.bt_id + '">' + bookType.bt_name + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Error: " + textStatus + " - " + errorThrown);
                }
            });
        });
    </script>

    <!-- INSERT -->
    <script>
        $(document).ready(function() {
            // กำหนดการตรวจสอบฟอร์ม
            $('#formAddBook').validate({
                rules: {
                    bk_name: {
                        required: true,
                        maxlength: 100
                    },
                    bk_quantity: {
                        required: true,
                        digits: true,
                        min: 0,
                    },
                    bk_student_loan_period: {
                        required: true,
                        digits: true,
                        min: 1,
                        max: 7,
                    },
                    bk_teacher_loan_period: {
                        required: true,
                        digits: true,
                        min: 1,
                        max: 14,
                    },
                    bk_detail: {
                        required: true,
                    },
                    bk_publisher: {
                        required: true,
                        maxlength: 100
                    },
                    bk_author: {
                        required: true,
                        maxlength: 100
                    },
                    bt_id: {
                        required: true
                    },
                },
                messages: {
                    bk_name: {
                        required: "กรุณากรอก ชื่อหนังสือ",
                        maxlength: "ชื่อหนังสือ ต้องไม่เกิน 100 ตัวอักษร"
                    },
                    bk_quantity: {
                        required: "กรุณากรอก จํานวนหนังสือ",
                        digits: "จํานวนหนังสือ ต้องเป็นตัวเลขจำนวนเต็มบวก",
                        min: "จํานวนหนังสือต้องมากกว่า 0",
                        max: "จํานวนหนังสือต้องน้อยกว่า 7",
                    },
                    bk_student_loan_period: {
                        required: "กรุณากรอก ระยะเวลายืมหนังสือ",
                        digits: "ระยะเวลายืมหนังสือ ต้องเป็นตัวเลขจำนวนเต็มบวก",
                        min: "ระยะเวลายืมหนังสือ ต้องมากกว่า 0",
                        max: "จํานวนหนังสือต้อง ไม่เกิน 7 วัน",
                    },
                    bk_teacher_loan_period: {
                        required: "กรุณากรอก ระยะเวลายืมหนังสือ",
                        min: "ระยะเวลายืมหนังสือ ต้องมากกว่า 0",
                        max: "จํานวนหนังสือต้อง ไม่เกิน 14 วัน",
                    },
                    bk_detail: {
                        required: "กรุณากรอก รายละเอียดหนังสือ",
                    },
                    bk_publisher: {
                        required: "กรุณากรอก สํานักพิมพ์",
                        maxlength: "สํานักพิมพ์ ต้องไม่เกิน 100 ตัวอักษร"
                    },
                    bk_author: {
                        required: "กรุณากรอก ผู้แต่ง",
                        maxlength: "ผู้แต่ง ต้องไม่เกิน 100 ตัวอักษร"
                    },
                    bt_id: {
                        required: "กรุณาเลือก ประเภทหนังสือ",
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
                        bk_name: $('#bk_name').val(),
                        bk_quantity: $('#bk_quantity').val(),
                        bk_student_loan_period: $('#bk_student_loan_period').val(),
                        bk_teacher_loan_period: $('#bk_teacher_loan_period').val(),
                        bk_detail: $('#bk_detail').val(),
                        bk_publisher: $('#bk_publisher').val(),
                        bk_author: $('#bk_author').val(),
                        bt_id: $('#bt_id').val(),
                        bk_show: $('input[name="bk_show"]:checked').val(), // แก้ไขตรงนี้
                    };

                    // ส่งข้อมูลด้วย AJAX
                    $.ajax({
                        url: 'ajax/book_add.php', // ไฟล์ PHP ที่จะใช้เพิ่มข้อมูล
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            console.log(response); // ตรวจสอบการตอบกลับของเซิร์ฟเวอร์
                            if (response.success) {
                                $('#tableBook').DataTable().ajax.reload(); // โหลดข้อมูลใหม่ใน DataTable
                                $('#addBookModal').modal('hide'); // ปิด modal
                                $('#formAddBook')[0].reset(); // รีเซ็ตฟอร์ม

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
        $('#tableBook').on('click', '.btn-edit', function() {

            // แสดง Modal
            $('#editBookModal').modal('show');

            const bkId = $(this).data('bk-id');
            const bkName = $(this).data('bk-name');
            const bkQuantity = $(this).data('bk-quantity');
            const bkStudentLoanPeriod = $(this).data('bk-student-loan-period');
            const bkTeacherLoanPeriod = $(this).data('bk-teacher-loan-period');
            const bkDetail = $(this).data('bk-detail');
            const bkPublisher = $(this).data('bk-publisher');
            const bkAuthor = $(this).data('bk-author');
            const btId = $(this).data('bt-id');
            const bkShow = $(this).data('bk-show');
            const bkOldImg = $(this).data('bk-img');


            // กรอกข้อมูลเดิมลงในฟอร์ม
            $('#edit_bk_id').val(bkId);
            $('#edit_bk_name').val(bkName);
            $('#edit_bk_quantity').val(bkQuantity);
            $('#edit_bk_student_loan_period').val(bkStudentLoanPeriod);
            $('#edit_bk_teacher_loan_period').val(bkTeacherLoanPeriod);
            $('#edit_bk_detail').val(bkDetail);
            $('#edit_bk_publisher').val(bkPublisher);
            $('#edit_bk_author').val(bkAuthor);
            $('#edit_bt_id').val(btId);
            $('#edit_bk_show').val(bkShow);

            $('#bk_old_img').val(bkOldImg);

            // ตั้งค่ารูปภาพ หากไม่มี ให้แสดง default.png
            if (bkOldImg) {
                $('#preview_bk_old_img').attr('src', '../uploads/img_book/' + bkOldImg);
            } else {
                $('#preview_bk_old_img').attr('src', '../uploads/img_book/default.png');
            }



            // ตั้งค่าสถานะการแสดง (radio buttons)
            if (bkShow == 1) {
                $('#edit_bk_show1').prop('checked', true);
            } else {
                $('#edit_bk_show2').prop('checked', true);
            }
        });

        // ใช้ jQuery Validation
        $('#formBookEdit').validate({
            rules: {
                edit_bk_name: {
                    required: true,
                    maxlength: 100
                },
                edit_bk_quantity: {
                    required: true,
                    digits: true,
                    min: 0,
                },
                edit_bk_student_loan_period: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 7,
                },
                edit_bk_teacher_loan_period: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 14,
                },
                edit_bk_detail: {
                    required: true,
                },
                edit_bk_publisher: {
                    required: true,
                    maxlength: 100
                },
                edit_bk_author: {
                    required: true,
                    maxlength: 100
                },
                edit_bt_id: {
                    required: true
                },
                edit_bk_new_img: {
                    accept: "image/png,image/jpg,image/jpeg" // เพิ่มการตรวจสอบประเภทไฟล์
                }
            },
            messages: {
                edit_bk_name: {
                    required: "กรุณากรอก ชื่อหนังสือ",
                    maxlength: "ชื่อหนังสือ ต้องไม่เกิน 100 ตัวอักษร"
                },
                edit_bk_quantity: {
                    required: "กรุณากรอก จํานวนหนังสือ",
                    digits: "จํานวนหนังสือ ต้องเป็นตัวเลขจำนวนเต็มบวก",
                    min: "จํานวนหนังสือต้องมากกว่า 0",
                    max: "จํานวนหนังสือต้องน้อยกว่า 7",
                },
                edit_bk_student_loan_period: {
                    required: "กรุณากรอก ระยะเวลายืมหนังสือ",
                    digits: "ระยะเวลายืมหนังสือ ต้องเป็นตัวเลขจำนวนเต็มบวก",
                    min: "ระยะเวลายืมหนังสือ ต้องมากกว่า 0",
                    max: "จํานวนหนังสือต้อง ไม่เกิน 7 วัน",
                },
                edit_bk_teacher_loan_period: {
                    required: "กรุณากรอก ระยะเวลายืมหนังสือ",
                    min: "ระยะเวลายืมหนังสือ ต้องมากกว่า 0",
                    max: "จํานวนหนังสือต้อง ไม่เกิน 14 วัน",
                },
                edit_bk_detail: {
                    required: "กรุณากรอก รายละเอียดหนังสือ",
                },
                edit_bk_publisher: {
                    required: "กรุณากรอก สํานักพิมพ์",
                    maxlength: "สํานักพิมพ์ ต้องไม่เกิน 100 ตัวอักษร"
                },
                edit_bk_author: {
                    required: "กรุณากรอก ผู้แต่ง",
                    maxlength: "ผู้แต่ง ต้องไม่เกิน 100 ตัวอักษร"
                },
                edit_bt_id: {
                    required: "กรุณาเลือก ประเภทหนังสือ",
                },
                edit_bk_new_img: {
                    accept: "ต้องเป็นไฟล์ png, jpg, jpeg เท่านั้น" // เพิ่มการตรวจสอบประเภทไฟล์
                }
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

                formData.append('bkId', $('#edit_bk_id').val());
                formData.append('bkName', $('#edit_bk_name').val());
                formData.append('bkQuantity', $('#edit_bk_quantity').val());
                formData.append('bkStudentLoanPeriod', $('#edit_bk_student_loan_period').val());
                formData.append('bkTeacherLoanPeriod', $('#edit_bk_teacher_loan_period').val());
                formData.append('bkDetail', $('#edit_bk_detail').val());
                formData.append('bkPublisher', $('#edit_bk_publisher').val());
                formData.append('bkAuthor', $('#edit_bk_author').val());
                formData.append('btId', $('#edit_bt_id').val());
                formData.append('bkShow', $('input[name="edit_bk_show"]:checked').val());
                formData.append('bkOldImg', $('#bk_old_img').val());

                // เพิ่มไฟล์์รูปสินค้า (ถ้ามี)
                let newImgFile = $('#edit_bk_new_img')[0].files[0];
                if (newImgFile) {
                    formData.append('bkNewImg', newImgFile);
                }

                // ส่งข้อมูลด้วย AJAX
                $.ajax({
                    url: 'ajax/book_edit.php',
                    type: 'POST',
                    data: formData,
                    processData: false, // ปิด processData สำหรับการส่งไฟล์
                    contentType: false, // ปิด contentType สำหรับการส่งไฟล์
                    success: function(response) {
                        console.log(response);
                        // ตรวจสอบการตอบกลับ
                        if (response.success) {
                            $('#tableBook').DataTable().ajax.reload();
                            $('#editBookModal').modal('hide');

                            // รีเซ็ตค่า input file และ label
                            $('#edit_bk_new_img').val(''); // รีเซ็ต input file
                            $('#edit_bk_new_img').next('.custom-file-label').html('choose file'); // รีเซ็ต label


                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: 'แก้ไขหนังสือเรียบร้อยแล้ว!',
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
        $('#tableBook').on('click', '.btn-delete', function() {
            const bkId = $(this).data('bk-id');
            const bkImg = $(this).data('bk-img');

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
                        url: 'ajax/book_delete.php', // ไฟล์ PHP ที่จะใช้ลบข้อมูล
                        type: 'POST',
                        data: {
                            bk_id: bkId,
                            bk_img: bkImg,
                        },
                        success: function(response) {
                            console.log(response); // ตรวจสอบการตอบกลับของเซิร์ฟเวอร์
                            if (response.success) {
                                $('#tableBook').DataTable().ajax.reload(); // โหลดข้อมูลใหม่ใน DataTable
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