<html>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

</html>
<?php
        include('./connect.php');

        $data = $_POST;
        $uuid = uniqid('user');
        $fname = $data['fname'];
        $lname = $data['lname'];
        $email = $data['email'];
        $org = $data['org'];
        $tel = $data['tel'];
        $password = md5($data['password']);
        $u_level = $data['u_level'];
        $strSQL = "INSERT INTO user(
    `U_id`,
    `fname`,
    `lname`,
    `email`,
    `tel`,
    `org`, 
    `password`,
    `status`
) VALUES (
    '$uuid',
    '$fname', 
    '$lname', 
    '$email', 
    '$tel',
    '$org', 
    '$password',  
    '$u_level'
)";
        $objQuery = mysqli_query($mysqli, $strSQL) or die(mysqli_error($mysqli));
        if ($objQuery) {
            echo '<script>alert("ลงทะเบียนเรียบร้อยแล้ว");window.location="user.php";</script>';
        } else {
            echo '<script>alert("พบข้อผิดพลาด");window.location="user.php";</script>';
        }
