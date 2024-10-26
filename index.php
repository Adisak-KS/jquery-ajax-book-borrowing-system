<?php
$namePage = "หน้าหลัก";
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


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">หนังสือมาใหม่</span></h2>
        <div id="book-container" class="row px-xl-5">
            <!-- ผลลัพธ์หนังสือใหม่จะถูกแสดงที่นี่ -->
        </div>
    </div>
    </div>
    <!-- Products End -->


    <!-- Footer Start -->
    <?php require_once('layouts/footer.php'); ?>


    <?php require_once('layouts/vendor.php'); ?>

    <script>
        $(document).ready(function() {
            function loadNewProduct() {
                $.ajax({
                    url: 'ajax/fetch_new_book.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        let newBookContainer = '';
                        $.each(response, function(index, book) {

                            let bookImage = book.bk_img ? book.bk_img : 'default.png';
                            let bookType = book.bt_name ? book.bt_name : 'ไม่พบประเภทหนังสือ';

                            // ฟังก์ชันสำหรับการตัดข้อความที่รองรับภาษาไทย
                            function truncateText(text, maxLength) {
                                if (text.length > maxLength) {
                                    return text.substring(0, maxLength) + '...';
                                } else {
                                    return text;
                                }
                            }

                            // ตัดข้อความให้ไม่เกิน 40 ตัวอักษร
                            let truncatedBookName = truncateText(book.bk_name, 30);
                            let truncatedBookType = truncateText(bookType, 40);

                            newBookContainer += `
                                <div  class="col-lg-3 col-md-4 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" style="height: 400px"  src="uploads/img_book/${bookImage}" alt="${book.bk_name}">
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

                        $('#book-container').html(newBookContainer);
                    }
                })
            }

            loadNewProduct();
        })
    </script>
</body>

</html>