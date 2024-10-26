<?php
$namePage = "หนังสือทั้งหมด";
$nameWebsite = "ยืม-คืนหนังสือห้องสมุด";
session_start();

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
                                                        <a class="dropdown-item" href="#" data-limit="9">9</a>
                                                        <a class="dropdown-item" href="#" data-limit="45">45</a>
                                                        <a class="dropdown-item" href="#" data-limit="108">108</a>
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
                    // ฟังก์ชันโหลดหนังสือทั้งหมด
                    function loadBookAll(page = 1, limit = 9, search = '') {
                        // สร้างอาร์เรย์เก็บ ID ของประเภทหนังสือที่ถูกเลือก
                        let btId = [];
                        $('input[name="bt_id[]"]:checked').each(function() {
                            btId.push($(this).val());
                        });

                        // เรียกใช้งาน AJAX เพื่อดึงข้อมูลหนังสือ
                        $.ajax({
                            url: 'ajax/fetch_book_all.php',
                            method: 'GET',
                            data: {
                                page: page,
                                limit: limit,
                                bt_id: btId,
                                search: search
                            },
                            dataType: 'json',
                            success: function(response) {
                                let bookContainer = '';

                                // ตรวจสอบว่ามีหนังสือหรือไม่
                                if (response.books.length < 1) {
                                    bookContainer = `
                                        <div class="col-12 pb-1">
                                            <div class="product-item bg-light mb-4">
                                                <h3 class="text-center text-danger py-4">ไม่พบหนังสือ</h3>
                                            </div>
                                        </div>
                                    `;
                                } else {
                                    // สร้าง HTML สำหรับหนังสือแต่ละเล่ม
                                    $.each(response.books, function(index, book) {
                                        let bookImage = book.bk_img ? book.bk_img : 'default.png';
                                        let bookType = book.bt_name ? book.bt_name : 'ไม่พบประเภทหนังสือ';

                                        // ฟังก์ชันตัดข้อความเกินความยาวที่กำหนด
                                        function truncateText(text, maxLength) {
                                            return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
                                        }

                                        let truncatedBookName = truncateText(book.bk_name, 30);
                                        let truncatedBookType = truncateText(bookType, 40);

                                        // เพิ่ม HTML ของหนังสือเข้าไปใน bookContainer
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
                                }

                                // แสดงผลหนังสือ
                                $('#book-container').html(bookContainer);

                                // คำนวณจำนวนหน้าทั้งหมด
                                let totalPages = Math.ceil(response.totalBooks / response.limit);

                                // สร้าง pagination ถ้ามีหลายหน้า
                                if (totalPages > 1) {
                                    let paginationHTML = `
                                            <li class="page-item ${response.page === 1 ? 'disabled' : ''}">
                                                <a class="page-link" href="#" data-page="${response.page - 1}">Previous</a>
                                            </li>
                                        `;

                                    for (let i = 1; i <= totalPages; i++) {
                                        paginationHTML += `
                                            <li class="page-item ${i === response.page ? 'active' : ''}">
                                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                                            </li>
                                         `;
                                    }

                                    paginationHTML += `
                                        <li class="page-item ${response.page === totalPages ? 'disabled' : ''}">
                                            <a class="page-link" href="#" data-page="${response.page + 1}">Next</a>
                                        </li>
                                    `;

                                    $('.pagination').html(paginationHTML);
                                } else {
                                    $('.pagination').html(''); // หากมีหน้าหนึ่งหน้าไม่แสดง pagination
                                }
                            }
                        });
                    }

                    // ดึงค่าจาก URL
                    const urlParams = new URLSearchParams(window.location.search);
                    const searchQuery = urlParams.get('search') || '';
                    loadBookAll(1, 9, searchQuery); // เรียกใช้ฟังก์ชันพร้อมกับค่า search

                    // คลิกที่ pagination
                    $(document).on('click', '.pagination a', function(e) {
                        e.preventDefault();
                        let page = $(this).data('page');
                        if (page) {
                            let search = $('input[name="search"]').val(); // ดึงค่าจาก input ของฟอร์มค้นหา
                            loadBookAll(page, 9, search); // โหลดข้อมูลหนังสือตามหน้าที่เลือก
                        }
                    });

                    // ค้นหาหนังสือ
                    $(document).on('submit', '#searchForm', function(e) {
                        e.preventDefault();
                        let search = $('input[name="search"]').val(); // ดึงค่าจาก input ค้นหา
                        loadBookAll(1, 9, search); // ส่งค่าค้นหาไปในฟังก์ชัน
                    });

                    // เปลี่ยนประเภทหนังสือ
                    $(document).on('change', 'input[name="bt_id[]"]', function() {
                        let search = $('input[name="search"]').val(); // ดึงค่าจาก input ค้นหา
                        loadBookAll(1, 9, search); // โหลดข้อมูลหนังสือตามประเภทที่เลือก
                    });

                    // จับการคลิก dropdown สำหรับจำนวน limit
                    $(document).on('click', '.dropdown-item', function(e) {
                        e.preventDefault();
                        let limit = $(this).data('limit');
                        let search = $('input[name="search"]').val();
                        loadBookAll(1, limit, search); // ส่งค่า limit ที่เลือกเข้าไปในฟังก์ชัน
                    });
                });
            </script>

</body>

</html>