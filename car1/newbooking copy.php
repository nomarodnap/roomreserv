<?php
session_start();
include_once('./function.php');
$objCon = connectDB();

$id = (int) $_GET['id'];
$strSQL = "SELECT * FROM bookingRoom LEFT JOIN user ON bookingRoom.U_id=user.U_id WHERE id = $id";
$strSQL2 = "SELECT * FROM bookingRoom LEFT JOIN user ON bookingRoom.admin_update=user.U_id WHERE id = $id";

//if (!mysqli_query($objCon, "SELECT * FROM user WHERE U_id = $uid")) {
//    echo ("Error description: " . mysqli_error($objCon));
//}
//$objResult = $objCon->query($strSQL) or die($objCon->error);
$objQuery = mysqli_query($objCon, $strSQL);
$objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);
$objQuery2 = mysqli_query($objCon, $strSQL2);
$objResult2 = mysqli_fetch_array($objQuery2, MYSQLI_ASSOC);
if ($objResult == null) {
    echo '<script>alert("ไม่พบข้อมูล!!");window.location="./";</script>';
}
$pagename = 'อัพเดทข้อมูลการจอง';
require 'header.php';
require 'Sidebar.php';
if ($objResult['B_status'] == 'accept') {
    $status1 =
        "<button class='btn btn-success btn-lg'>" .
        "<i class='fa fa-check pr-2'></i> อนุมัติแล้ว </button>";
} elseif ($objResult['B_status'] == 'reject') {
    $status1 =
        "<button class='btn btn-danger btn-lg'>" .
        "<i class='fa fa-remove pr-2'></i> ยกเลิก</button>";
} elseif ($objResult['B_status'] == 'Suspend') {
    $status1 =
        "<button class='btn btn-warning btn-lg'>" .
        "<i class='fa fa-remove pr-2'></i> รออนุมัติ</button>";
} else {
    $status1 =
        "<button class='btn btn-primary btn-lg'>" .
        "<i class='fa fa-refresh pr-2'></i>  อนุมัติ / รอใช้</button>";
}
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $pagename; ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body" style='text-align: center;'>
                        <h5 class="card-title">สถานะการจองปัจจุบัน</h5>
                        <?php echo $status1; ?>
                        <p style='font-size:15px'><?php echo 'Update: ' . $objResult['date_update'];
                                                    echo '<br>by: ' . $objResult2['fname'] . ' ' . $objResult2['lname'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 mb-3 mb-sm-0">
                <div class="card ">
                    <div class="card-body">
                        <form action="booking_action_update2.php" id="form_update" method="post" enctype="multipart/form-data">
                            <div class="col-md-9">
                                <div class="row mt-3">
                                    <!-- แถวที่ 1 -->
                                    <div class="row-md-3">
                                        <label for="title" class="form-label">วัตถุประสงค์การใช้</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon3">เรื่อง</span>
                                            <input type="text" id="title" name="title" class="form-control" value="<?php echo $objResult['title']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-5 mt-3">
                                        <label for="start" class="form-label">วันเวลาเริ่มต้น</label>
                                        <input type="datetime-local" id="lname" name="start" class="form-control" value="<?php echo $objResult['start']; ?>">
                                    </div>
                                    <!-- แถวที่ 2 -->
                                    <div class="col-md-5 mt-3">
                                        <label for="end" class="form-label">วันเวลาสิ้นสุด</label>
                                        <input type="datetime-local" id="end" name="end" class="form-control " value="<?php echo $objResult['end']; ?>">
                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <label for="persion" class="form-label">จำนวนผู้ใช้งาน</label>
                                        <div class="input-group col-sm-2">
                                            <input type="number" id="persion" name="persion" class="form-control" value="<?php echo $objResult['persion']; ?>"><span class="input-group-text" id="basic-addon2">คน</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="org" class="form-label">หน่วยงาน</label>
                                        <input type="text" id="org" name="org" class="form-control" value="<?php echo $objResult['org']; ?>" disabled>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="user" class="form-label">ผู้จอง</label>
                                        <input type="text" id="uid" name="fame" class="form-control" value="<?php echo $objResult['fname'] . ' ' . $objResult['lname'] . ' โทร.' . $objResult['tel']; ?>" disabled>
                                    </div>
                                    <input hidden type="text" name="uid" value="<?php echo $objResult['U_id']; ?>">
                                    <input hidden type="text" name="id" value="<?php echo $objResult['id']; ?>">
                                    <div class="col-md-4 mt-3">
                                        <label for="ststus" class="form-label">สถานะการจอง</label>
                                        <select class="form-select" aria-label="Default select example" d="B_status" name="B_status">
                                            <option selected value="accept">อนุมัติการจอง</option>
                                            <option value="reject">ยกเลิกการจอง</option>
                                        </select>
                                    </div>
                                    <!-- ปุ่มบันทึก -->
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-primary btn-sm">บันทึกการแก้ไข</button>
                                        <a href="./"><button type="button" class="btn btn-outline-primary btn-sm">กลับ</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div><!-- End Default Card -->
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php require 'footer.php' ?>

</html>