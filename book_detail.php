<?php
$namePage = "รายละเอียด";
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
                    <span class="breadcrumb-item active">รายละเอียด</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-3 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img id="book-img" class="w-100" style="height: 435px;" alt="Image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3 id="book-name"></h3>
                    <hr>
                    <div class="d-flex mb-3">
                        <div class="mr-2">
                            <strong class="text-dark">รหัสหนังสือ :</strong>
                            <span id="book-id"></span>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="mr-2">
                            <strong class="text-dark">ประเภท :</strong>
                            <span id="book-type-name"></span>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="mr-2">
                            <strong class="text-dark">สำนักพิมพิ์ :</strong>
                            <span id="book-publisher"></span>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="mr-2">
                            <strong class="text-dark">ผู้แต่ง:</strong>
                            <span id="book-author"></span>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="mr-2">
                            <strong class="text-dark">จำนวนวันยืมสูงสุด ของนักเรียน :</strong>
                            <span id="book-student-loan-period"></span>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="mr-2">
                            <strong class="text-dark">จำนวนวันยืมสูงสุด ของครู :</strong>
                            <span id="book-teacher-loan-period"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <button type="submit" id="btn-borrow" class="btn btn-primary px-3">
                            ยืมหนังสือ
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">รายละเอียด</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">รายละเอียดหนังสือ</h4>
                            <p id="book-detail"></p>

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
            let urlParams = new URLSearchParams(window.location.search);
            let bkId = urlParams.get('id');

            // Function to fetch book details
            function fetchBookDetails() {
                $.ajax({
                    url: 'ajax/fetch_book_detail.php',
                    method: 'GET',
                    data: {
                        bk_id: bkId
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            $('#book-name').text(response.bk_name);
                            $('#book-id').text(response.bk_id);
                            if (response.bt_name == null) {
                                response.bt_name = 'ไม่พบประเภทหนังสือ';
                            }
                            $('#book-type-name').text(response.bt_name);
                            $('#book-publisher').text(response.bk_publisher);
                            $('#book-author').text(response.bk_author);
                            $('#book-student-loan-period').text(response.bk_student_loan_period + ' วัน');
                            $('#book-teacher-loan-period').text(response.bk_teacher_loan_period + ' วัน');
                            $('#book-detail').text(response.bk_detail);

                            if (response.bk_img === null) {
                                response.bk_img = 'default.png';
                            }

                            $('#book-img').attr('src', 'uploads/img_book/' + response.bk_img);

                            // ตรวจสอบจำนวนหนังสือ
                            if (response.bk_quantity < 1) {
                                // ถ้าจำนวนหนังสือน้อยกว่า 1 ให้ปิดปุ่มยืมหนังสือ
                                $('#btn-borrow').prop('disabled', true).text('ไม่สามารถยืมได้');
                            } else {
                                $('#btn-borrow').prop('disabled', false).text(' ยืมหนังสือ');
                            }
                        } else {
                            // ถ้าไม่พบข้อมูลให้เปลี่ยนเส้นทางไปหน้า index.php
                            window.location.href = 'index.php';
                        }
                    },
                    error: function() {
                        // ถ้าเกิดข้อผิดพลาด ให้เปลี่ยนเส้นทางไปหน้า index.php
                        window.location.href = 'index.php';
                    }
                });
            }

            // Initial fetch of book details
            fetchBookDetails();

            // BORROW BOOK
            $('#btn-borrow').click(function(event) {
                event.preventDefault(); // ป้องกันการส่งฟอร์ม

                // แสดงกล่องยืนยัน
                Swal.fire({
                    title: 'ยืมหนังสือ?',
                    text: "คุณต้องการยืมหนังสือเล่มนี้ หรือไม่?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ใช่, ยืมเลย!',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ถ้าผู้ใช้ยืนยัน ให้ส่ง bk_id ไปยังเซิร์ฟเวอร์
                        console.log("ส่ง bk_id:", bkId);
                        $.ajax({
                            url: 'ajax/book_borrow.php',
                            method: 'POST',
                            data: {
                                bk_id: bkId
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ยืมหนังสือสำเร็จ',
                                        text: response.message,
                                    }).then(() => {
                                        // Reload book details after successful borrow
                                        fetchBookDetails();
                                    });
                                } else {

                                    if (response.message === 'กรุณาเข้าสู่ระบบ') {
                                        window.location.href = 'login.php';
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'ผิดพลาด',
                                            text: response.message,
                                        });
                                    }
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(jqXHR.responseText); // แสดงข้อผิดพลาดของการส่งข้อมูล
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด!',
                                    text: response.message,
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>




</body>

</html>