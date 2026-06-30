<?php
session_start();
if (!isset($_SESSION['user_login'])) { // ถ้าไม่ได้เข้าระบบอยู่
    header("location: login.php"); // redirect ไปยังหน้า login.php
    exit;
}

$user = $_SESSION['user_login'];
if ($user['status'] != 'admin') {
    echo '<script>alert("สำหรับผู้ดูแลระบบเท่านั้น");window.location="index.php";</script>';
    exit;
}
require 'header.php';
require 'Sidebar.php';
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard ADMIN</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div id='calendar'></div>
            <div style="margin:10px 0 50px 0;" align="center">
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php require 'footer.php' ?>

</html>