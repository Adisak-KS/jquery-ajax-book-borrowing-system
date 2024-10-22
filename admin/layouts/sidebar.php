<?php
if (!isset($_SESSION['adm_id'])) {
    $_SESSION['login'] = "กรุณาเข้าสู่ระบบ ก่อนใช้งาน";
    header("Location: login.php");
    exit();
}
?>


<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <i class="fa-solid fa-school"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ยืม-คืน หนังสือ</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
    <li class="nav-item">
        <a class="nav-link" href="admin_show.php">
            <i class="fa-solid fa-user-shield"></i>
            <span>ผู้ดูแลระบบ</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="user_show.php">
            <i class="fa-solid fa-user"></i>
            <span>ผู้ใช้งาน</span>
        </a>
    </li>

    <div class="sidebar-heading">
        หนังสือ
    </div>
    <li class="nav-item">
        <a class="nav-link" href="book_type_show.php">
            <i class="fa-solid fa-swatchbook"></i>
            <span>ประเภทหนังสือ</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="book_show.php">
            <i class="fa-solid fa-book"></i>
            <span>หนังสือ</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>