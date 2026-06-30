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
$admud = $user['U_id'];;
$data = $_POST;
// print_r($data);
$id = $data['id'];
$title = $data['title'];
$start = str_replace("T", " ", $data['start'] . ":00");
$end = str_replace("T", " ", $data['end'] . ":00");
$persion = (int)$data['persion'];
$B_status = $data['B_status'];
$uid = $data['uid'];
$date_update = date("Y-m-d H:i:s");
$remark = $data['remark'];
if ($remark == " ") {
    $remark = "อัพเดทสถานะ";
    $strSQL = "UPDATE bookingRoom_2 SET 
        start = '$start',
        end = '$end',
        title = '$title',
        persion = $persion,
        B_status = '$B_status',
        date_update = '$date_update',
        admin_update = '$admud',
        remark = '$remark'
    WHERE id = '$id'";
} else
    $strSQL = "UPDATE bookingRoom_2 SET 
        start = '$start',
        end = '$end',
        title = '$title',
        persion = $persion,
        B_status = '$B_status',
        date_update = '$date_update',
        admin_update = '$admud',
        remark = '$remark'
    WHERE id = '$id'";
echo $strSQL;
$objQuery = mysqli_query($objCon, $strSQL);
if ($objQuery) {
    $uidlog = uniqid('', true);
    $sqlupdate =
        "INSERT INTO `log_remark` (`remark_id`,`book_id`,`u_id`,`remark`) VALUES('$uidlog','$id','$uid','$remark') ";
    $objQuery2 = mysqli_query($objCon, $sqlupdate);
    echo '<script>alert("บันทึกรายการแล้ว");window.location="booking_list_2.php";</script>';
} else {
    echo '<script>alert("พบข้อผิดพลาด!!");window.location="booking_list_2.php";</script>';
}
