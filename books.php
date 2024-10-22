<?php
$namePage = "หนังสือทั้งหมด";
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
                    <span class="breadcrumb-item text-dark"">หนังสือทั้งหมด</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Start -->
    <div class=" container-fluid">
                        <div class="row px-xl-5">
                            <!-- Shop Sidebar Start -->
                            <div class="col-lg-3 col-md-4">
                                <!-- Type Start -->
                                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by type</span></h5>
                                <div class="bg-light p-4 mb-30">
                                    <form id="bookTypesForm">
                                        <!-- ข้อมูล AJAX ของ checkbox จะแสดงจาก get_book_type -->
                                    </form>
                                </div>
                                <!-- Type End -->
                            </div>
                            <!-- Shop Sidebar End -->


                            <!-- Shop Product Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="row">
                                    <div class="col-12 pb-1">
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div>
                                            </div>
                                            <div class="ml-2">
                                                <div class="btn-group ml-2">
                                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">แสดง</button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">9</a>
                                                        <a class="dropdown-item" href="#">45</a>
                                                        <a class="dropdown-item" href="#">108</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="book-container" class="row pb-3">

                                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                        <div class="product-item bg-light mb-4">
                                            <div class="product-img position-relative overflow-hidden">
                                                <img class="img-fluid w-100" src="img/product-1.jpg" alt="">
                                                <div class="product-action">
                                                    <a class="btn btn-outline-dark btn-square" href="">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="text-center py-4">
                                                <p class="small">xdff</p>
                                                <a class="h6 text-decoration-none text-truncate" href="book_detail.php?id=">ชื่อหนังสือ</a>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="col-12">
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <!-- ข้อมูล AJAX ของ pagination จะแสดงจาก get_book_all -->
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <!-- Shop Product End -->
                        </div>
            </div>
            <!-- Shop End -->


            <!-- Footer Start -->
            <?php require_once('layouts/footer.php'); ?>


            <?php require_once('layouts/vendor.php'); ?>

            <!-- SELECT BOOK TYPE  -->
            <script>
                $(document).ready(function() {
                    // ดึงข้อมูลประเภทหนังสือด้วย AJAX
                    $.ajax({
                        url: 'ajax/fetch_book_type.php', // ชื่อไฟล์ PHP ที่ใช้ดึงข้อมูล
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data); // 
                            let bookTypeContent = '';

                            // สร้าง checkbox จากข้อมูลที่ได้รับ
                            data.forEach(function(item) {
                                bookTypeContent += `
                                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                        <input type="checkbox" class="custom-control-input" id="book-type-${item.bt_id}" name="bt_id[]" value="${item.bt_id}">
                                        <label class="custom-control-label" for="book-type-${item.bt_id}">${item.bt_name}</label>
                                        <span class="badge border font-weight-normal">${item.book_count.toLocaleString()}</span>
                                    </div>`;
                            });

                            // แสดงผลใน form
                            $('#bookTypesForm').html(bookTypeContent);
                        },
                        error: function(xhr, status, error) {
                            console.error("เกิดข้อผิดพลาดในการดึงข้อมูล: ", error);
                        }
                    });
                });
            </script>

            <!-- SELECT BOOK  -->
            <script>
                $(document).ready(function() {
                    function loadBookAll(page = 1, limit = 9) {
                        let btId = [];
                        $('input[name="bt_id[]"]:checked').each(function() {
                            btId.push($(this).val());
                        });

                        console.log(btId); // ตรวจสอบค่า btId ที่จะส่งไป
                        $.ajax({
                            url: 'ajax/fetch_book_all.php',
                            method: 'GET',
                            data: {
                                page: page,
                                limit: limit,
                                bt_id: btId
                            },
                            dataType: 'json',
                            success: function(response) {
                                let bookContainer = '';
                                $.each(response.books, function(index, book) {
                                    let bookImage = book.bk_img ? book.bk_img : 'default.png';
                                    let bookType = book.bt_name ? book.bt_name : 'ไม่พบประเภทหนังสือ';

                                    function truncateText(text, maxLength) {
                                        return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
                                    }

                                    let truncatedBookName = truncateText(book.bk_name, 30);
                                    let truncatedBookType = truncateText(bookType, 40);

                                    bookContainer += `
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" style="height: 400px" src="uploads/img_book/${bookImage}" alt="${book.bk_name}">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href="book_detail.php?id=${book.bk_id}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <p class="small">${truncatedBookType}</p>
                                        <a class="h6 text-decoration-none text-truncate" href="book_detail.php?id=${book.bk_id}">${truncatedBookName}</a>
                                    </div>
                                </div>
                            </div>
                        `;
                                });

                                $('#book-container').html(bookContainer);

                                let totalPages = Math.ceil(response.totalBooks / response.limit);
                                let paginationHTML = '';

                                paginationHTML += `<li class="page-item ${response.page === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${response.page - 1}">Previous</a>
                    </li>`;

                                for (let i = 1; i <= totalPages; i++) {
                                    paginationHTML += `<li class="page-item ${i === response.page ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>`;
                                }

                                paginationHTML += `<li class="page-item ${response.page === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${response.page + 1}">Next</a>
                    </li>`;

                                $('.pagination').html(paginationHTML);
                            }
                        });
                    }

                    loadBookAll();

                    $(document).on('click', '.pagination a', function(e) {
                        e.preventDefault();
                        let page = $(this).data('page');
                        if (page) {
                            loadBookAll(page);
                        }
                    });

                    $(document).on('click', '.dropdown-item', function(e) {
                        let limit = parseInt($(this).text());
                        loadBookAll(1, limit);
                    });

                    $(document).on('change', 'input[name="bt_id[]"]', function() {
                        loadBookAll(1);
                    });
                });
            </script>
</body>

</html>