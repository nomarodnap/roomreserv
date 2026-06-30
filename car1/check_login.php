<html>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

</html><?php
        session_start(); // เปิดใช้งาน session
        if (isset($_SESSION['user_login'])) { // ถ้าเข้าระบบอยู่
            header("location: index.php"); // redirect ไปยังหน้า index.php
            exit;
        }

        include_once("./connect.php");
        $email = mysqli_real_escape_string($mysqli, $_POST['email']); // รับค่า email
        $password = mysqli_real_escape_string($mysqli, $_POST['password']); // รับค่า password

        $strSQL = "SELECT * FROM user WHERE email = '$email' AND password = md5('$password')";
        $objQuery = mysqli_query($mysqli, $strSQL);
        $row = mysqli_num_rows($objQuery);
        if ($row) {
            $res = mysqli_fetch_assoc($objQuery);
            $_SESSION['user_login'] = array(
                'U_id' => $res['U_id'],
                'fname' => $res['fname'],
                'lname' => $res['lname'],
                'email' => $res['email'],
                'tel' => $res['tel'],
                'org' => $res['org'],
                'status' => $res['status']
            );
            $user = $_SESSION['user_login'];
            $userlog = $user['U_id'];
            $uidlog = uniqid('', true);
            $sqllog = "INSERT INTO `log_login` (`log_id`,`log_user`) VALUES('$uidlog','$userlog') ";
            $objQuery2 = mysqli_query($mysqli, $sqllog);
            if ($user['status'] == 'admin') {
                echo '<script>window.location="./";</script>';
                exit;
            } else {
                echo '<script>alert("ยินดีต้อนรับคุณ ', $res['fname'] . ' ' . $res['lname'], '");window.location="index.php";</script>';
            }
        } else {
            echo '<script>alert("email หรือ password ไม่ถูกต้อง!!");window.location="login.php";</script>';
        }
