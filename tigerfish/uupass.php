<?php
session_start();
if (!isset($_SESSION['user_login'])) { // ถ้าไม่ได้เข้าระบบอยู่
    header("location: login.php"); // redirect ไปยังหน้า login.php
    exit;
}
require 'header.php';
require 'Sidebar.php';
$user = $_SESSION['user_login'];
include_once('./function.php');

$objCon = connectDB();
$uid = (int)$_POST['uid'];
$ppass = $_POST['newpassword']; echo $ppass.'<br>';
$mdpassword = md5($ppass);echo $mdpassword;
$strQ = "UPDATE user SET 
password = '$mdpassword'
WHERE U_id = $uid";
$objQuery = mysqli_query($objCon, $strQ);
if ($objQuery) {
    echo '<script>alert("บันทึกการแก้ไขแล้ว");window.location="user_profile.php";</script>';
} else {
    echo '<script>alert("พบข้อผิดพลาด!!");window.location="user_profile.php";</script>';
}
