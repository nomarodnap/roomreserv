<?php
require 'connect.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // เปิดใช้งาน session
}

if (isset($_SESSION['user_login'])) { // ถ้าเข้าระบบอยู่
    header("location: index.php"); // redirect ไปยังหน้า index.php
    exit;
} else {
$showlogin = "";
if (isset($_SESSION['login_error'])) {
    $showlogin = $_SESSION['login_error'];
    unset($_SESSION['login_error']); // เคลียร์ข้อความหลังแสดงแล้ว
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <title>Login | <?php echo $webname ?></title>
  <?php require 'header2.php'; ?>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="./" class=" d-flex align-items-center w-auto">
                  <img src="assets/img/headlogo.png" alt="">
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">ลงชื่อเข้าใช้งาน</h5>
<?php if (!empty($showlogin)) : ?>
  <div class="alert alert-danger d-flex align-items-center" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.3rem;"></i>
    <div><?php echo $showlogin; ?></div>
  </div>
<?php endif; ?>

                  </div>

                  <form class=" row g-3 needs-validation" novalidate action="check_login.php" method="post">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <input type="email" name="email" class="form-control" id="email" required>
                        <div class="invalid-feedback">Please enter your Email.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" id="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="cf-turnstile text-center" data-sitekey="0x4AAAAAAANfgLBByVerszl3" data-callback="javascriptCallback"></div>
                    <div class="col-12 g-recaptcha">
                      <button class="btn btn-primary w-100" type="submit" name="login_btn" data-callback='onSubmit' data-action='submit'>Login</button>
                    </div>
                    <div class="col-6">
                      <p class="small mb-0"><a href="signup.php">สมัครใช้งาน</a></p>
                    </div>
                    <div class="col-6">
                      <p class="small mb-0" style="text-align: end;"><a href="forgot_password.php">ลืมรหัสผ่าน</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits" style="color:navy;text-align:center;">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                กลุ่มพัฒนาระบบงานสารสนเทศ<br> โทร.<a href="tel:025795591">025795591 </a> เบอร์ภายใน: 5129<br>ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร​ กรมประมง
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>