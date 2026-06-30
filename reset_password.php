<?php 
require 'connect.php'; 

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = isset($_GET['token']) ? $_GET['token'] : '';
    
    if (empty($token)) {
        $message = "<div class='alert alert-danger'>⚠️ ไม่มีโทเค็นหรือโทเค็นไม่ถูกต้อง</div>";
    } else {
        $token = $mysqli->real_escape_string($token);
        $sql = "SELECT * FROM user WHERE reset_token = '$token' AND reset_token_expire > NOW()";
        $result = $mysqli->query($sql);
        
        if ($result->num_rows === 0) {
            $message = "<div class='alert alert-danger'>⚠️ โทเค็นไม่ถูกต้องหรือหมดอายุแล้ว</div>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "<div class='alert alert-danger'>❌ รหัสผ่านไม่ตรงกัน กรุณาลองใหม่</div>";
    } elseif (strlen($new_password) < 8) {
        $message = "<div class='alert alert-danger'>❌ รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร</div>";
    } else {
        $hashed_password = md5($new_password);
        
        $sql = "UPDATE user 
                SET password = '$hashed_password', 
                    reset_token = NULL, 
                    reset_token_expire = NULL 
                WHERE reset_token = '$token'";
        
        if ($mysqli->query($sql)) {
            $message = "<div class='alert alert-success'>✅ รีเซ็ตรหัสผ่านสำเร็จแล้ว คุณสามารถ <a href='login.php'>เข้าสู่ระบบ</a> ได้เลย</div>";
        } else {
            $message = "<div class='alert alert-danger'>❌ เกิดข้อผิดพลาดในการรีเซ็ตรหัสผ่าน: " . $mysqli->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>รีเซ็ตรหัสผ่าน | ระบบจองห้องอบรม</title>
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
            <section class="section reset-password min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <a href="./" class="d-flex align-items-center w-auto">
                                    <img src="assets/img/headlogo.png" alt="ระบบจองห้องอบรม">
                                </a>
                            </div>
                            
                            <div class="card mb-8">
                                <div class="card-body">
                                    <h5 class="card-title text-center pb-0 fs-4">รีเซ็ตรหัสผ่านใหม่</h5>

                                    <?php if (!empty($message)) : ?>
                                        <div><?php echo $message; ?></div>
                                    <?php endif; ?>

                                    <form class="row g-3 needs-validation" novalidate action="reset_password.php" method="post">
                                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                                        <!-- รหัสผ่านใหม่ -->
                                        <div class="col-12 password-toggle">
                                            <label for="password" class="form-label">รหัสผ่านใหม่</label>
                                            <input type="password" name="password" class="form-control" id="password" required minlength="8">
                                            <i class="bi bi-eye-slash password-toggle-icon" id="togglePassword" onclick="togglePasswordVisibility('password', this)"></i>
                                            <div class="invalid-feedback">กรุณากรอกรหัสผ่านใหม่ (อย่างน้อย 8 ตัวอักษร)</div>
                                        </div>

                                        <!-- ยืนยันรหัสผ่านใหม่ -->
                                        <div class="col-12 password-toggle">
                                            <label for="confirm_password" class="form-label">ยืนยันรหัสผ่านใหม่</label>
                                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" required minlength="8">
                                            <i class="bi bi-eye-slash password-toggle-icon" id="toggleConfirmPassword" onclick="togglePasswordVisibility('confirm_password', this)"></i>
                                            <div class="invalid-feedback">กรุณายืนยันรหัสผ่านใหม่</div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">รีเซ็ตรหัสผ่าน</button>
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

    <!-- Font Awesome (สำหรับใช้ไอคอน) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-Fo3rlrQkTy3Vw5GSOCHmZycpas6c/6xJ1jxeJ5VgmNZo58EHk6uqGO8dJgJOz1V6flmj5BCclhz3csc4Kj7hqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- ฟังก์ชันสลับการแสดงรหัสผ่าน -->
    <script>
        function togglePasswordVisibility(inputId, icon) {
            const passwordInput = document.getElementById(inputId);
            const isPasswordHidden = passwordInput.type === 'password';

            passwordInput.type = isPasswordHidden ? 'text' : 'password';
            
            // เปลี่ยนไอคอน
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        }
    </script>
</body>
</html>


