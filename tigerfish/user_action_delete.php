<html>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

</html>
<?php
        include_once('./function.php');
        $objCon = connectDB();
        $u_id = (int) $_GET['u_id'];

        // $strSQL = "DELETE FROM contact WHERE c_id = $c_id";
        $strSQL = "UPDATE user SET u_status = 0 WHERE U_id = $u_id";
        $objQuery = mysqli_query($objCon, $strSQL);
        if ($objQuery) {
            echo '<script>alert("ลบข้อมูลแล้ว");window.location="user.php";</script>';
        } else {
            echo '<script>alert("พบข้อผิดพลาด");window.location="user.php";</script>';
        }
        ?>