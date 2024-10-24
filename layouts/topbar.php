    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="">About</a>
                    <a class="text-body mr-3" href="">Contact</a>
                    <a class="text-body mr-3" href="">Help</a>
                    <a class="text-body mr-3" href="">FAQs</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <?php if (isset($_SESSION['usr_id'])) { ?>
                            <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">My Account</button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button">Sign in</button>
                                <button class="dropdown-item" type="button">Sign up</button>
                            </div>
                        <?php }else{ ?>
                            <a href="login.php" class="btn btn-sm btn-light">เข้าสู่ระบบ</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">ยืม - คืน</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">หนังสือ</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form id="searchForm" action="books.php" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="ค้นหาหนังสือ" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">ติดต่อเรา</p>
                <h5 class="m-0">098-765-4321</h5>
            </div>
        </div>
    </div>
    <!-- Topbar End -->