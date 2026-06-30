
<?php
include_once('./function.php');
$objCon = connectDB();

$data = $_POST;
// print_r($data);
$uid = $data['uid'];
$fname = $data['fname'];
$lname = $data['lname'];
$email = $data['email'];
$org = $data['org'];
$tel = $data['tel'];
$datapass = $data['password'];echo $datapass;
$password1 = md5($datapass);echo '<br>'.$password1;
$status = $data['uststus'];
if ($password == 'd41d8cd98f00b204e9800998ecf8427e') {
    $strSQL = "UPDATE user SET 
        fname = '$fname',
        lname = '$lname',
        email = '$email',
        org = '$org',
        tel = '$tel',
        status = '$status'
    WHERE U_id = $uid";
} else {
    $strSQL = "UPDATE user SET 
        fname = '$fname',
        lname = '$lname',
        email = '$email',
        org = '$org',
        tel = '$tel',
        password = '$password1',
        status = '$status'
    WHERE U_id=$uid";
}echo '<br>'.$strSQL;
$objQuery = mysqli_query($objCon, $strSQL);
if ($objQuery) {
    echo '<script>alert("บันทึกการแก้ไขแล้ว");window.location="user.php";</script>';
} else {
    echo '<script>alert("พบข้อผิดพลาด!!");window.location="user.php";</script>';
}
