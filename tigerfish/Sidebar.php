<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link " href="./">
        <i class="bi bi-grid"></i>
        <span>ปฏิทิน</span>
      </a>
      </li><!-- End Dashboard Nav -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="manual.php">
        <i class="bi bi-book-half"></i>
        <span>คู่มือการใช้งาน</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="booking.php">
        <i class="bi bi-calendar3-range"></i>
        <span>จองห้องประชุม</span>
      </a>
    </li>
	  <?php if (isset($_SESSION['user_login'])) { ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="booking_list.php">
          <i class="bi bi-calendar-check-fill"></i>
          <span>รายการจองห้อง</span>
        </a>
      </li>
      <?php $user = $_SESSION['user_login'];
      if ($user['status'] == 'admin') {
        echo '
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="./user">
          <i class="bi bi-person"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="user-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="./user.php">
              <i class="bi bi-circle"></i><span>จัดการผู้ใช้</span>
            </a>
          </li>
          <li>
            <a href="./userlog.php">
              <i class="bi bi-circle"></i><span>ประวัติใช้งาน</span>
            </a>
          </li>
          <li>
            <a href="./user_create.php">
              <i class="bi bi-circle"></i><span>เพิ่มผู้ใช้</span>
            </a>
          </li>
          <li>
            <a href="./user_report.php">
              <i class="bi bi-circle"></i><span>รายงาน</span>
            </a>
          </li>
        </ul>
      </li>';
      } ?>
    <?php
    } else { ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="../signup.php">
          <i class="bi bi-card-list"></i>
          <span>Register</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../login.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li><!-- End Login Page Nav -->
  </ul>
<?php } ?>

</aside><!-- End Sidebar-->