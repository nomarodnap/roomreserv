<?php
require './connect.php';

if (!isset($_GET['code'])) {
    echo '<script>alert("ลิงก์ยืนยันไม่ถูกต้อง"); window.location="login.php";</script>';
    exit;
}

$code = $_GET['code'];

// ตรวจสอบว่า verification code มีอยู่หรือไม่
$sql = "SELECT * FROM user WHERE verification_code = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // ถ้าผู้ใช้ยังไม่ถูกยืนยัน
    if ($user['is_verified'] == 0) {
        $update_sql = "UPDATE user SET is_verified = 1, verification_code = NULL WHERE U_id = ?";
        $update_stmt = $mysqli->prepare($update_sql);
        $update_stmt->bind_param("s", $user['U_id']);
        $update_stmt->execute();

        echo '<script>alert("ยืนยันอีเมลเรียบร้อยแล้ว คุณสามารถเข้าสู่ระบบได้ทันที"); window.location="login.php";</script>';
    } else {
        echo '<script>alert("อีเมลนี้ได้รับการยืนยันไปแล้ว"); window.location="login.php";</script>';
    }
} else {
    echo '<script>alert("ลิงก์ยืนยันไม่ถูกต้อง หรือหมดอายุ"); window.location="login.php";</script>';
}

$stmt->close();
$mysqli->close();
?>
