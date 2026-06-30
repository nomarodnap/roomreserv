<html>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

</html>
<?php
        session_start();
        include_once('./function.php');
        $objCon = connectDB();
        $id = (int) $_GET['id'];
        $user = $_SESSION['user_login'];
        if ($user['status'] == '') {
            echo '<script>alert("ลงชื่อเข้าใช้งานก่อน");window.location="./";</script>';
            exit;
        }
        // $strSQL = "DELETE FROM contact WHERE c_id = $c_id";
        $strSQL = "UPDATE bookingRoom SET B_status = 'reject' WHERE id = $id";
        $objQuery = mysqli_query($objCon, $strSQL);
        if ($objQuery) {
            echo '<script>alert("ยกเลิกการจองห้องแล้ว");window.location="booking_list.php";</script>';
        } else {
            echo '<script>alert("พบข้อผิดพลาด");window.location="booking_list.php";</script>';
        }
