<?php
$namePage = "รายการยืม หนังสือ";
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
                                <psi class="m-0 font-weight-bold text-primary mb-2">รายการยืม หนังสือ</psi>
                            </div>

                            <!-- Modal EDIT -->
                            <div class="modal fade" id="editBookBorrowModal" data-backdrop="static" tabindex="-1" aria-labelledby="editBookBorrowModalLabel" aria-hidden="true">
                                <form id="formBookBorrowEdit" novalidate>
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editAdminModalLabel">ยืนยันการคืนหนังสือ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-group">
                                                    <label for="edit_br_id" class="form-label">รหัสรายการ : </label>
                                                    <input type="text" class="form-control" id="edit_br_id" name="edit_br_id" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_br_borrow_date" class="form-label">วัน เวลายืม : </label>
                                                    <input type="datetime-local" class="form-control" id="edit_br_borrow_date" name="edit_br_borrow_date" readonly>
                                                </div>

                                                <input type="text" class="form-control" id="edit_bk_id" name="edit_bk_id" readonly>

                                                <div class="form-group">
                                                    <label for="edit_bk_name" class="form-label">ชื่อหนังสือ : </label><span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="edit_bk_name" name="edit_bk_name" placeholder="กรุณาระบุ ชื่อหนังสือ" maxlength="100" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_br_amount" class="form-label">จำนวน :</label> <span class="text-danger">*</span>
                                                    <input type="number" class="form-control" id="edit_br_amount" name="edit_br_amount" placeholder="กรุณาระบุ จำนวน" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_usr_fname" class="form-label">ชื่อ :</label> <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="edit_usr_fname" name="edit_usr_fname" placeholder="กรุณาระบุ จำนวน" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_usr_lname" class="form-label">นามสกุล :</label> <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" id="edit_usr_lname" name="edit_usr_lname" placeholder="กรุณาระบุ จำนวน" readonly>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        <i class="fa-solid fa-xmark"></i>
                                                        ปิด
                                                    </button>
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                        ยืนยันการคืนหนังสือ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>


                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tableBookBorrow" class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">รูป</th>
                                            <th class="text-center">ชื่อหนังสือ</th>
                                            <th class="text-center">ชื่อ</th>
                                            <th class="text-center">นามสกุล</th>
                                            <th class="text-center">วัน เวลายืม</th>
                                            <th class="text-center">จัดการ</th>
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
            $('#tableBookBorrow').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'ajax/book_borrow_list.php',
                    type: 'POST',
                    error: function(xhr, error, thrown) {
                        console.error("Error loading data: " + error);
                    }
                },
                order: [
                    [0, 'desc']
                ],
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
                        data: 'usr_fname',
                        className: 'text-left',
                    },
                    {
                        data: 'usr_lname',
                        className: 'text-left',
                    },
                    {
                        data: 'br_borrow_date',
                        className: 'text-center',
                    },
                    {
                        data: 'br_id',
                        render: function(data, type, row) {
                            let buttons = `
                                    <button class="btn btn-warning btn-edit" 
                                        data-br-id="${row.br_id}" 
                                        data-bk-id="${row.bk_id}"
                                        data-bk-name="${row.bk_name}"
                                        data-br-amount="${row.br_amount}"
                                        data-usr-fname="${row.usr_fname}" 
                                        data-usr-lname="${row.usr_lname}" 
                                        data-br-borrow-date="${row.br_borrow_date}" 
                                    >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                        แก้ไข
                                    </button>
                                `;

                            buttons += `<button class="btn btn-danger btn-delete" data-br-id="${row.br_id}" data-bk-id="${row.bk_id}"><i class="fa-solid fa-trash"></i> ลบ</button>`;

                            return buttons;
                        },
                        className: 'text-center',
                    }
                ],
            });
        });
    </script>

    <!-- EDIT  -->
    <script>
        // จับเหตุการณ์การคลิกปุ่ม "แก้ไข"
        $('#tableBookBorrow').on('click', '.btn-edit', function() {
            // แสดง Modal
            $('#editBookBorrowModal').modal('show');

            const brId = $(this).data('br-id');
            const brBorrowDate = $(this).data('br-borrow-date');
            const bkId = $(this).data('bk-id');
            const bkName = $(this).data('bk-name');
            const brAmount = $(this).data('br-amount');
            const usrFname = $(this).data('usr-fname');
            const usrLname = $(this).data('usr-lname');

            // กรอกข้อมูลเดิมลงในฟอร์ม
            $('#edit_br_id').val(brId);
            $('#edit_br_borrow_date').val(brBorrowDate);
            $('#edit_bk_id').val(bkId);
            $('#edit_bk_name').val(bkName);
            $('#edit_br_amount').val(brAmount);
            $('#edit_usr_fname').val(usrFname);
            $('#edit_usr_lname').val(usrLname);
        });

        // ฟังก์ชันสำหรับจัดการการส่งข้อมูลแบบฟอร์ม
        $('#formBookBorrowEdit').submit(function(event) {
            event.preventDefault(); // ป้องกันการรีเฟรชหน้าเมื่อส่งแบบฟอร์ม

            // แสดงกล่องยืนยันก่อนส่งข้อมูล
            Swal.fire({
                title: 'ยืนยันการคืนหนังสือ?',
                text: "คุณต้องการยืนยันการคืนหนังสือนี้หรือไม่?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // สร้าง FormData เพื่อส่งข้อมูลพร้อมไฟล์
                    let formData = new FormData(this);
                    formData.append('brId', $('#edit_br_id').val());
                    formData.append('bkId', $('#edit_bk_id').val());

                    // ส่งข้อมูลด้วย AJAX
                    $.ajax({
                        url: 'ajax/book_borrow_edit.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
                            // ตรวจสอบการตอบกลับ
                            if (response.success) {
                                $('#tableBookBorrow').DataTable().ajax.reload();
                                $('#editBookBorrowModal').modal('hide');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'สำเร็จ!',
                                    text: 'ยืนยันการคืนหนังสือสําเร็จ!',
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
    </script>

    <!-- Delete  -->
    <script>
        // จับเหตุการณ์การคลิกปุ่ม "ลบ"
        $('#tableBookBorrow').on('click', '.btn-delete', function() {
            const brId = $(this).data('br-id');
            const bkId = $(this).data('bk-id');

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
                        url: 'ajax/book_borrow_delete.php', // ไฟล์ PHP ที่จะใช้ลบข้อมูล
                        type: 'POST',
                        data: {
                            br_id: brId,
                            bk_id: bkId,
                        },
                        success: function(response) {
                            console.log(response); // ตรวจสอบการตอบกลับของเซิร์ฟเวอร์
                            if (response.success) {
                                $('#tableBookBorrow').DataTable().ajax.reload(); // โหลดข้อมูลใหม่ใน DataTable
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

</body>

</html>