<?php $webname = 'ระบบจองห้อง'; ?>
<!DOCTYPE html>
<html lang="th">

<head>
  <title><?php echo $pagename . ' | ' . $webname; ?></title>
  <?php require 'header2.php';
  $user = $_SESSION['user_login'];
  ?>
</head>

<body id="html_element">

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="../" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">ระบบจองห้องประชุม</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <a href="./manual.php">
  <button type="button" class="btn btn-outline-dark btn-sm" style="margin-right: 10px;">
    <i class="bi bi-book-half"></i> คู่มือการใช้งาน
  </button>
</a>

        <?php
        if (isset($_SESSION['user_login'])) { ?>
          <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
              <i class="bx bxs-user"></i>
              <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $user['fname']; ?></span>
            </a><!-- End Profile Iamge Icon -->
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
              <li class="dropdown-header">
                <h6><?php echo $user['fname'] . ' ' . $user['lname']; ?></h6>
                <span><?php echo $user['org']; ?></span>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center" href="./user_profile.php">
                  <i class="bi bi-gear"></i>
                  <span>Account Settings</span>
                </a>
              </li>
              <hr class="dropdown-divider">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="./logout.php">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
                </a>
              </li>

            </ul><!-- End Profile Dropdown Items -->
          </li>
        <?php } else {
          echo '<div class="btn-group" role="group"><ul class="d-flex align-items-center">
        <a href="../signup.php"><button type="button" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil-square"></i>
            ลงทะเบียน</button></a>
        <a href="./login.php"><button type="button" class="btn btn-outline-success btn-sm"><i class="bi bi-box-arrow-in-right me-1"></i>เข้าใช้งาน</button></a>
      </ul></div>';
        } ?>
    </nav><!-- End Icons Navigation -->
  </header><!-- End Header -->