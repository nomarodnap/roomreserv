<?php
require './connect.php';
require './vendor/autoload.php';
$config = require './config.php'; // SMTP config

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

// รับอีเมลจาก form (หรือจะดึงจาก session ก็ได้)
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : trim($_GET['email']);


    // ตรวจสอบว่ามี user อยู่ในระบบ และยังไม่ verified
    $sql = "SELECT U_id, fname, lname, is_verified FROM user WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo '<script>alert("ไม่พบบัญชีผู้ใช้นี้"); window.history.back();</script>';
        exit();
    }

    if ($user['is_verified'] == 1) {
        echo '<script>alert("บัญชีนี้ยืนยันอีเมลแล้ว สามารถเข้าสู่ระบบได้เลย"); window.location="login.php";</script>';
        exit();
    }

    // สร้างรหัสใหม่
    $verificationCode = bin2hex(random_bytes(16));

    // อัปเดตรหัสใหม่ใน DB
    $updateSQL = "UPDATE user SET verification_code = ? WHERE email = ?";
    $updateStmt = $mysqli->prepare($updateSQL);
    $updateStmt->bind_param("ss", $verificationCode, $email);
    $updateStmt->execute();
    $updateStmt->close();

    // ส่งอีเมลยืนยันใหม่
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
        $mail->addAddress($email, $user['fname'] . ' ' . $user['lname']);

        $verifyLink = "https://roomreserv.fisheries.go.th/newweb/verify-email.php?code=$verificationCode";

        $mail->isHTML(true);
        $mail->Subject = 'Resend Email Verification';
        $mail->Body = "
            <h2>สวัสดีคุณ {$user['fname']}!</h2>
            <p>กรุณาคลิกที่ลิงก์ด้านล่างเพื่อยืนยันอีเมลของคุณ:</p>
            <a href='$verifyLink'>$verifyLink</a>
            <p>หากคุณไม่ได้สมัครสมาชิก กรุณาไม่สนใจอีเมลนี้</p>
        ";

        $mail->send();
        echo '<script>alert("ระบบได้ส่งอีเมลยืนยันใหม่แล้ว กรุณาตรวจสอบกล่องจดหมายของคุณ"); window.location="login.php";</script>';
    } catch (Exception $e) {
        echo '<script>alert("ไม่สามารถส่งอีเมลได้: ' . $mail->ErrorInfo . '"); window.history.back();</script>';
    }
} else {
    echo '<script>alert("วิธีเข้าถึงไม่ถูกต้อง"); window.history.back();</script>';
}
