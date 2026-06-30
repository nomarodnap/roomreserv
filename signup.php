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
    <style>
        .password-toggle {
            position: relative;
        }
        .password-toggle-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
        .password-toggle-icon:hover {
            color: #000;
        }
    </style>
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
                            </div>
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
                                            <label for="yourEmail" class="form-label">อีเมล</label>
                                            <input type="email" name="email" class="form-control" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
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

                                        <div class="col-12 password-toggle">
                                            <label for="yourPassword" class="form-label">รหัสผ่าน</label>
                                            <input type="password" name="password" class="form-control" id="yourPassword" required minlength="8">
                                            <i class="bi bi-eye-slash password-toggle-icon" id="togglePassword" onclick="togglePasswordVisibility('yourPassword', this)"></i>
                                            <div class="invalid-feedback">กรุณากรอกรหัสผ่านที่มีความยาวอย่างน้อย 8 ตัวอักษร</div>
                                        </div>

                                        <div class="col-12 password-toggle">
                                            <label for="confirmPassword" class="form-label">ยืนยันรหัสผ่าน</label>
                                            <input type="password" name="confirm_password" class="form-control" id="confirmPassword" required minlength="8">
                                            <i class="bi bi-eye-slash password-toggle-icon" id="toggleConfirmPassword" onclick="togglePasswordVisibility('confirmPassword', this)"></i>
                                            <div class="invalid-feedback">กรุณายืนยันรหัสผ่าน</div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" name="register_btn" id="register_btn" type="submit">สมัครสมาชิก</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">ถ้าคุณเป็นสมาชิกอยู่แล้วให้ <a href="login.php">เข้าสู่ระบบ</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="credits" style="color:navy;text-align:center;">
                                กลุ่มพัฒนาระบบงานสารสนเทศ<br> โทร.<a href="tel:025795591">025795591</a> เบอร์ภายใน: 5129<br>ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร​ กรมประมง
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePasswordVisibility(inputId, icon) {
            const passwordInput = document.getElementById(inputId);
            const isPasswordHidden = passwordInput.type === 'password';
            passwordInput.type = isPasswordHidden ? 'text' : 'password';
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        }

        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            const password = document.getElementById('yourPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            if (password !== confirmPassword) {
                event.preventDefault();
                alert('รหัสผ่านไม่ตรงกัน กรุณาลองอีกครั้ง');
            }
        });
    </script>
</body>

</html>