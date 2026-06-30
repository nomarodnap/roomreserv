<?php 
require 'connect.php'; 
require 'vendor/autoload.php'; // เรียกใช้งาน PHPMailer 
$config = require 'config.php'; // นำข้อมูล SMTP มาจาก config.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    
    if (!empty($email)) {
        $email = $mysqli->real_escape_string($email);
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = $mysqli->query($sql);
        
        if ($result->num_rows > 0) {
            $token = bin2hex(random_bytes(50)); 
            $expire = date('Y-m-d H:i:s', strtotime('+1 hour')); 
            
            $update_sql = "UPDATE user 
                           SET reset_token = '$token', reset_token_expire = '$expire' 
                           WHERE email = '$email'";
            
            if ($mysqli->query($update_sql)) {
                $sendMail = sendResetEmail($email, $token);
                
                if ($sendMail === true) {
                    $message = "<div class='alert alert-success'>✅ ลิงก์รีเซ็ตรหัสผ่านได้ถูกส่งไปยังอีเมลของคุณแล้ว</div>";
                } else {
                    $message = "<div class='alert alert-danger'>❌ ไม่สามารถส่งอีเมลได้: $sendMail</div>";
                }
            } else {
                $message = "<div class='alert alert-danger'>❌ เกิดข้อผิดพลาดในการอัปเดตโทเค็น: " . $mysqli->error . "</div>";
            }
        } else {
            $message = "<div class='alert alert-warning'>⚠️ ไม่พบบัญชีที่ใช้อีเมลนี้ในระบบ</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>❌ กรุณากรอกอีเมล</div>";
    }
}


function sendResetEmail($email, $token) {
    global $config;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $config['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_user'];
        $mail->Password = $config['smtp_pass'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $config['smtp_port'];

        $mail->setFrom($config['smtp_from_email'], $config['smtp_from_name']);
        $mail->addAddress($email);

        $reset_link = "https://roomreserv.fisheries.go.th/newweb/reset_password.php?token=$token";
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        $mail->Body = "
            <h1>รีเซ็ตรหัสผ่าน</h1>
            <p>คลิกที่ลิงก์ด้านล่างเพื่อรีเซ็ตรหัสผ่านของคุณ:</p>
            <a href='$reset_link'>$reset_link</a>
            <p>ลิงก์นี้จะหมดอายุใน 1 ชั่วโมง</p>
        ";
        $mail->AltBody = "คัดลอกลิงก์นี้ไปวางในเบราว์เซอร์เพื่อรีเซ็ตรหัสผ่าน: $reset_link";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "ไม่สามารถส่งอีเมลได้: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>ลืมรหัสผ่าน | ระบบจองห้องอบรม</title>
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
                            </div>

                            <div class="card mb-8">
                                <div class="card-body">
                                    <h5 class="card-title text-center pb-0 fs-4">ลืมรหัสผ่าน</h5>

                                    <?php if (!empty($message)) : ?>
                                        <?php echo $message; ?>
                                    <?php endif; ?>

                                    <form method="post" class="row g-3">
                                        <div class="col-12">
                                            <label for="email" class="form-label">กรอกอีเมลของคุณ</label>
                                            <input type="email" name="email" class="form-control" id="email" required>
                                            <div class="invalid-feedback">กรุณากรอกอีเมลที่ถูกต้อง</div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">ส่งลิงก์รีเซ็ตรหัสผ่าน</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="credits" style="color:navy;text-align:center;">
                                กลุ่มพัฒนาระบบงานสารสนเทศ<br> โทร.<a href="tel:025795591">025795591</a> เบอร์ภายใน: 5129<br>ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร กรมประมง
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
