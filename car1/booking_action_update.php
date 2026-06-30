<html>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

</html>
<?php
session_start();
$user = $_SESSION['user_login'];
include_once('./function.php');
$objCon = connectDB();
date_default_timezone_set("Asia/Bangkok");

$admud = $user['U_id'];
$data = $_POST;

$id = $data['id'];
$title = $data['title'];
$start = str_replace("T", " ", $data['start'] . ":00");
$end = str_replace("T", " ", $data['end'] . ":00");
$persion = (int)$data['persion'];
$B_status = $data['B_status'];
$uid = $data['uid'];
$purpose = mysqli_real_escape_string($objCon, $data['purpose']);
$driver = mysqli_real_escape_string($objCon, $data['driver']);
$remark = trim($data['remark']);
if ($remark == "") {
    $remark = "อัพเดทสถานะ";
}

$date_update = date("Y-m-d H:i:s");

$strSQL = "UPDATE car1 SET 
    start = '$start',
    end = '$end',
    title = '$title',
    purpose = '$purpose',
    driver = '$driver',
    persion = $persion,
    B_status = '$B_status',
    date_update = '$date_update',
    admin_update = '$admud',
    remark = '$remark'
WHERE id = '$id'";

$objQuery = mysqli_query($objCon, $strSQL);

if ($objQuery) {
    $uidlog = uniqid('', true);
    $sqlupdate = "INSERT INTO `log_remark` (`remark_id`,`book_id`,`u_id`,`remark`) 
        VALUES('$uidlog','$id','$uid','$remark')";
    $objQuery2 = mysqli_query($objCon, $sqlupdate);
    echo '<script>alert("บันทึกรายการแล้ว");window.location="booking_list.php";</script>';
} else {
    echo '<script>alert("พบข้อผิดพลาด!!");window.location="booking_list.php";</script>';
}
?>
