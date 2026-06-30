<html>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

</html>
<?php
include_once('./function.php');
$objCon = connectDB();
date_default_timezone_set("Asia/Bangkok");
$date_update = date("Y-m-d H:i:s");
$data = $_POST;
// print_r($data);
$uid = $data['uid'];
$uuid = uniqid();
$testdate1 = date('Y-m-d', strtotime($data['startdate']));
$testdate2 = date('Y-m-d', strtotime($data['enddate']));
$start = $testdate1 . ' ' . $data['starttime'];
$end = $testdate2 . ' ' . $data['endtime'];
$title = $data['title'];
$persion = (int)$data['persion'];
$strSQL = "INSERT INTO bookingRoom(
    `id`,
    `start`,
    `end`,
    `title`,
    `persion`,
    `U_id`, 
    `B_status`,
    `date_update`,
    `admin_update`
) VALUES (
    '$uuid',
    '$start', 
    '$end', 
    '$title', 
    $persion,
    '$uid',  
    'Suspend',
    '$date_update',
    '$uid'
)";
$objQuery = mysqli_query($objCon, $strSQL);
if ($objQuery) {
    $strline = "SELECT * FROM bookingRoom INNER JOIN user ON bookingRoom.U_id=user.U_id ORDER BY id DESC LIMIT 1";
    $objQuery2 = mysqli_query($objCon, $strline);
    $objResult2 = mysqli_fetch_array($objQuery2);
    $id2 = $objResult2['id'];
    $titel2 = $objResult2['title'];
    $start2 = DateThai($objResult2['start']);
    $end2 = DateThai($objResult2['end']);
    $org2 = $objResult2['org'];
    $user2 = $objResult2['fname'] . ' ' . $objResult2['lname'];
    $tel2 = $objResult2['tel'];

    $uidlog = uniqid('', true);
    $sqlupdate =
        "INSERT INTO `log_remark` (`remark_id`,`book_id`,`u_id`,`remark`) VALUES('$uidlog','$id2','$uid','สร้างการจอง') ";
    $objQuery2 = mysqli_query($objCon, $sqlupdate);
    require './line_notify2.php';
    echo '<script>alert("บันทึกการจองแล้ว กรุณารอฝ่ายบริหารตอบรับ");window.location="./";</script>';
} else {
    echo '<script>alert("พบข้อผิดพลาด!!");window.location="booking.php";</script>';
}
