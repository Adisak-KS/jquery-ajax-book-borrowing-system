<?php
$namePage = "หน้าหลัก";
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


    <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#header-carousel" data-slide-to="1"></li>
                        <li data-target="#header-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/carousel-1.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Men Fashion</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/carousel-2.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Women Fashion</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/carousel-3.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Kids Fashion</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="img/offer-1.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="img/offer-2.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">หนังสือมาใหม่</span></h2>
        <div id="product-container" class="row px-xl-5">

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
                        let productContainer = '';
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

                            productContainer += `
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

                        $('#product-container').html(productContainer);
                    }
                })
            }

            loadNewProduct();
        })
    </script>
</body>

</html>