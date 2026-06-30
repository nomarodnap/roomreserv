<?php
session_start();
if (!isset($_SESSION['user_login'])) {
    header("location: login.php");
    exit;
}

include_once('./function.php');
$objCon = connectDB();

if (!$objCon) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
} else {
}


// รับและ escape ค่าที่ได้จากฟอร์ม
$uid = isset($_POST['uid']) ? mysqli_real_escape_string($objCon, $_POST['uid']) : '';
$fname = mysqli_real_escape_string($objCon, $_POST['fname']);
$lname = mysqli_real_escape_string($objCon, $_POST['lname']);
$email = mysqli_real_escape_string($objCon, $_POST['email']);
$org = mysqli_real_escape_string($objCon, $_POST['org']);
$tel = mysqli_real_escape_string($objCon, $_POST['tel']);

if (empty($uid)) {
    die("❌ ไม่พบค่า uid");
}


// สร้างคำสั่ง UPDATE
$strQ = "UPDATE user SET 
        fname = '$fname',
        lname = '$lname',
        email = '$email',
        org = '$org',
        tel = '$tel'
        WHERE U_id = '$uid'";


// ทำการอัปเดต
$objQuery = mysqli_query($objCon, $strQ);
if (!$objQuery) {
    die("❌ คำสั่ง SQL ผิดพลาด: " . mysqli_error($objCon) . "<br>SQL: " . $strQ);
} else {
echo '<script>alert("✅ แก้ไขข้อมูลเรียบร้อย"); window.location.href = "index.php";</script>';
exit;

}


// ดึงข้อมูลใหม่มาอัปเดต session
$strSQL = "SELECT * FROM user WHERE U_id = $uid";
$objQuery2 = mysqli_query($objCon, $strSQL);

if ($objQuery2 && mysqli_num_rows($objQuery2) > 0) {
    $res = mysqli_fetch_assoc($objQuery2);
    $_SESSION['user_login'] = array(
        'U_id' => $res['U_id'],
        'fname' => $res['fname'],
        'lname' => $res['lname'],
        'email' => $res['email'],
        'tel' => $res['tel'],
        'org' => $res['org'],
        'status' => $res['status']
    );

    // ✅ redirect ไปยังหน้าหลัก
    header("Location: index.php");
    exit;
} else {
    echo '<script>alert("ไม่พบข้อมูลผู้ใช้งาน");window.location="./";</script>';
}

?>
