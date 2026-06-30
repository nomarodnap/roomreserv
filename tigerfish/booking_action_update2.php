<html>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

</html>
<?php
        include_once('./function.php');
        $objCon = connectDB();

        $data = $_POST;
        // print_r($data);
        $id = $data['id'];
        $title = $data['title'];
        $start = $data['start'];
        $end = $data['end'];
        $persion = (int)$data['persion'];
        $B_status = $data['B_status'];
        $uid = (int)$data['uid'];
        if (!$B_status) {
            $strSQL = "UPDATE bookingRoom SET 
        start = '$start',
        end = '$end',
        title = '$title',
        persion = $persion,
        U_id = $uid
    WHERE id = $id";
        } else
            $strSQL = "UPDATE bookingRoom SET 
        start = '$start',
        end = '$end',
        title = '$title',
        persion = $persion,
        U_id = $uid,
        B_status = '$B_status'
    WHERE id = $id";
        $objQuery = mysqli_query($objCon, $strSQL);
        if ($objQuery) {
            echo '<script>alert("บันทึกรายการแล้ว");window.location="./newbooking.php?id=' . $id . '";</script>';
        } else {
            echo '<script>alert("พบข้อผิดพลาด!!");window.location="./newbooking.php?id=' . $id . '";</script>';
        }
