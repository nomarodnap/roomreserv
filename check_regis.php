<html>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
</html>

<?php
require './connect.php';
require './vendor/autoload.php';
$config = require './config.php'; // ไฟล์ config SMTP

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $data = $_POST;
    $uuid = uniqid('user');
    $fname = trim($data['fname']);
    $lname = trim($data['lname']);
    $email = trim($data['email']);
    $org = trim($data['yourOrg']);
    $tel = trim($data['yourTel']);
    $password = trim($data['password']);
    $confirm_password = trim($data['confirm_password']);
    $u_level = isset($data['u_level']) ? trim($data['u_level']) : 'user'; // ระดับผู้ใช้เริ่มต้นเป็น 'user'

    // 1️⃣ ตรวจสอบความยาวของรหัสผ่าน
    if (strlen($password) < 8) {
        echo '<script>alert("รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร"); window.history.back();</script>';
        exit();
    }

    // 2️⃣ ตรวจสอบความตรงกันระหว่างรหัสผ่านและยืนยันรหัสผ่าน
    if ($password !== $confirm_password) {
        echo '<script>alert("รหัสผ่านไม่ตรงกัน กรุณาลองอีกครั้ง"); window.history.back();</script>';
        exit();
    }

    // 3️⃣ ตรวจสอบอีเมลซ้ำ
    $checkEmailSQL = "SELECT COUNT(*) FROM user WHERE email = ?";
    $stmt = $mysqli->prepare($checkEmailSQL);
    if (!$stmt) {
        echo '<script>alert("เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL"); window.history.back();</script>';
        exit();
    }

    $stmt->bind_param("s", $email); // ผูกค่าอีเมลกับ SQL
    $stmt->execute();
    $stmt->bind_result($emailCount); // รับผลลัพธ์ของ COUNT(*)
    $stmt->fetch();
    $stmt->close();

    if ($emailCount > 0) {
        echo '<script>alert("อีเมลนี้ถูกใช้งานไปแล้ว กรุณาใช้อีเมลอื่น"); window.history.back();</script>';
        exit();
    }

    // 4️⃣ เข้ารหัสรหัสผ่าน
    $hashed_password = md5($password);
	
	$verificationCode = bin2hex(random_bytes(16)); // สุ่มรหัส 32 ตัว


    // 5️⃣ ใช้ prepared statement เพื่อป้องกัน SQL Injection
    $strSQL = "INSERT INTO user (U_id, fname, lname, email, tel, org, password, status, verification_code, is_verified) 
           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";

    
    $stmt = $mysqli->prepare($strSQL);

    if (!$stmt) {
        echo '<script>alert("เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL"); window.history.back();</script>';
        exit();
    }

    // 6️⃣ ผูกค่าตัวแปรลงใน SQL เพื่อป้องกัน SQL Injection
    $stmt->bind_param("sssssssss", $uuid, $fname, $lname, $email, $tel, $org, $hashed_password, $u_level, $verificationCode);


    // 7️⃣ ดำเนินการคำสั่ง SQL
if ($stmt->execute()) {
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
        $mail->addAddress($email, $fname . ' ' . $lname);

        $verifyLink = "https://roomreserv.fisheries.go.th/newweb/verify-email.php?code=$verificationCode";

        $mail->isHTML(true);
        $mail->Subject = 'Confirm your email';
        $mail->Body = "
            <h2>ยินดีต้อนรับ $fname!</h2>
            <p>กรุณาคลิกที่ลิงก์ด้านล่างเพื่อยืนยันอีเมลของคุณ:</p>
            <a href='$verifyLink'>$verifyLink</a>
            <p>หากคุณไม่ได้สมัครสมาชิก กรุณาไม่สนใจอีเมลนี้</p>
        ";

        $mail->send();
        echo '<script>alert("ลงทะเบียนสำเร็จ กรุณายืนยันอีเมลของคุณ"); window.location="login.php";</script>';
    } catch (Exception $e) {
        echo '<script>alert("ลงทะเบียนสำเร็จ แต่ไม่สามารถส่งอีเมลยืนยันได้: ' . $mail->ErrorInfo . '"); window.location="login.php";</script>';
    }
} else {
    echo '<script>alert("พบข้อผิดพลาด: ' . $stmt->error . '"); window.history.back();</script>';
}
    // ปิด statement และ connection
    $stmt->close();
    $mysqli->close();
}
?>