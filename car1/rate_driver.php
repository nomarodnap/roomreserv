<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once('./function.php');
$objCon = connectDB();
date_default_timezone_set("Asia/Bangkok");

if (!$objCon) {
    die('ไม่สามารถเชื่อมต่อฐานข้อมูล');
}


// ตรวจสอบการ login
if (!isset($_SESSION['user_login'])) {
    echo '<script>alert("กรุณาเข้าสู่ระบบก่อน"); window.location="./";</script>';
    exit;
}

$user = $_SESSION['user_login'];
$uid = $user['U_id'];

// รับค่าจาก POST
$booking_id = $_POST['booking_id'] ?? null;
$driver = $_POST['driver'] ?? null;
$rating = (int) ($_POST['rating'] ?? 0);

// ตรวจสอบข้อมูลที่จำเป็น
if (!$booking_id || !$driver || $rating < 1 || $rating > 5) {
    echo '<script>alert("ข้อมูลไม่ครบถ้วน หรือไม่ถูกต้อง"); window.history.back();</script>';
    exit;
}

// ตรวจสอบว่า user นี้เป็นเจ้าของการจองหรือไม่
$checkBooking = mysqli_query($objCon, "SELECT * FROM car1 WHERE id = '$booking_id' AND U_id = '$uid'");
if (mysqli_num_rows($checkBooking) === 0) {
    echo '<script>alert("คุณไม่มีสิทธิ์ให้คะแนนการจองนี้"); window.location="booking_list.php";</script>';
    exit;
}

// ตรวจสอบว่ามีการให้คะแนนไปแล้วหรือยัง
$checkRated = mysqli_query($objCon, "SELECT * FROM driver_rating WHERE booking_id = '$booking_id'");
if (mysqli_num_rows($checkRated) > 0) {
    echo '<script>alert("คุณได้ให้คะแนนไปแล้ว"); window.location="booking_list.php";</script>';
    exit;
}

// บันทึกลงตาราง driver_rating
$now = date("Y-m-d H:i:s");
$driver = mysqli_real_escape_string($objCon, $driver);
$insertSQL = "
    INSERT INTO driver_rating (booking_id, driver_name, user_id, rating, date_rated)
    VALUES ('$booking_id', '$driver', '$uid', '$rating', '$now')
";

if (mysqli_query($objCon, $insertSQL)) {
    echo '<script>alert("ขอบคุณสำหรับการให้คะแนน"); window.location="booking_list.php";</script>';
} else {
    echo '<script>alert("เกิดข้อผิดพลาดในการบันทึกคะแนน"); window.history.back();</script>';
}
?>
