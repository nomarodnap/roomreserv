<?php require 'connect.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // เปิดใช้งาน session เฉพาะเมื่อยังไม่มี session
}
if (isset($_SESSION['user_login'])) { // ถ้าเข้าระบบอยู่
    header("location: index.php"); // redirect ไปยังหน้า index.php
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>ลงทะเบียนเข้าใช้งาน | <?php echo $webname; ?></title>
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
                                <a href="./" class="d-flex align-items-center w-auto">
                                    <img src="assets/img/headlogo.png" alt="">
                                </a>
                            </div><!-- End Logo -->
                            <div class="card mb-8">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">ลงทะเบียนเข้าใช้งาน</h5>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate action="./check_regis.php" method="post">
                                        <div class="col-6">
                                            <label for="yourfName" class="form-label">ชื่อ</label>
                                            <input type="text" name="fname" class="form-control" id="fname" required>
                                            <div class="invalid-feedback">กรุณากรอกชื่อ</div>
                                        </div>
                                        <div class="col-6">
                                            <label for="yourlName" class="form-label">นามสกุล</label>
                                            <input type="text" name="lname" class="form-control" id="lname" required>
                                            <div class="invalid-feedback">กรุณากรอกนามสกุล</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Email</label>
                                            <div id="error_msg"></div>
                                            <input type="email" name="email" class="form-control" id="email" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required>
                                            <div class="invalid-feedback">กรุณากรอก Email</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourOrg" class="form-label">หน่วยงาน</label>
                                            <input type="text" name="yourOrg" class="form-control" id="yourOrg" required>
                                            <div class="invalid-feedback">กรุณากรอกหน่วยงานที่สังกัด</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourTel" class="form-label">เบอร์โทรติดต่อ</label>
                                            <input type="text" name="yourTel" class="form-control" id="yourTel" required pattern="[0-9]+">
                                            <div class="invalid-feedback">กรุณากรอกเบอร์โทรติดต่อ/เฉพาะตัวเลขเท่านั้น</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="yourPassword" required>
                                            <div class="invalid-feedback">กรุณากรอก Password</div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <input class="form-check-input" type="checkbox" required> ยอมรับ<a href="./team-of-use.php">เงื่อนไขการใช้งานเว็บไซต์</a>
                                            <div class="invalid-feedback">กรุณายอมรับเงื่อนไขการใช้งานเว็บไซต์</div>
                                        </div>
                                        
                                        <?php 
                                        // ตรวจสอบการมีอยู่ของ session ก่อนที่จะเข้าถึงข้อมูลใน session
                                        if (isset($_SESSION['user_login']) && $_SESSION['user_login']['status'] == 'admin') {
                                            echo '<div class="col-12">
                                                <label for="userStatus" class="form-label">ประเภทผู้ใช้งาน</label>
                                                <select class="form-select" aria-label="Default select example" id="u_level" name="u_level" required>
                                                    <option value="user">ผู้ใช้งานทั่วไป</option>
                                                    <option value="admin">ผู้ดูแลระบบ</option>
                                                </select>
                                            </div>';
                                        } else {
                                            echo '<input type="hidden" id="u_level" name="u_level" value="user">
                                                  <input type="hidden" id="u_status" name="u_status" value="1">';
                                        }
                                        ?>
                                        
                                        <div class="cf-turnstile text-center" data-sitekey="0x4AAAAAAANfgLBByVerszl3" data-callback="javascriptCallback"></div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" name="register_btn" id="register_btn" type="submit" data-callback='onSubmit' data-action='submit'>Create Account</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Already have an account? <a href="login.php">Log in</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="credits" style="color:navy;text-align:center;">
                                กลุ่มพัฒนาระบบงานสารสนเทศ<br> โทร.<a href="tel:025795591">025795591 </a> เบอร์ภายใน: 5129<br>ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร​ กรมประมง
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