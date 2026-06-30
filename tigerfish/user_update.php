<?php
session_start();
include_once('./function.php');
$objCon = connectDB();

$uid = (int) $_GET['U_id'];
$strSQL = "SELECT * FROM user WHERE U_id = $uid";

//if (!mysqli_query($objCon, "SELECT * FROM user WHERE U_id = $uid")) {
//    echo ("Error description: " . mysqli_error($objCon));
//}
//$objResult = $objCon->query($strSQL) or die($objCon->error);
$objQuery = mysqli_query($objCon, $strSQL);
$objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);
if ($objResult == null) {
    echo '<script>alert("ไม่พบข้อมูล!!");window.location="user.php";</script>';
}
$pagename = 'อัพเดทข้อมูลสมาชิก';
require 'header.php';
require 'Sidebar.php';
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
            <div class="card">
                <div class="card-body">
                    <form action="user_action_update.php" id="form_update" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row mt-4">
                                    <!-- แถวที่ 1 -->
                                    <div class="col-md-4 mt-3">
                                        <label for="c_firstname" class="form-label">ชื่อ</label>
                                        <input type="text" id="fname" name="fname" class="form-control" value="<?php echo $objResult['fname']; ?>">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="lname" class="form-label">สกุล</label>
                                        <input type="text" id="lname" name="lname" class="form-control" value="<?php echo $objResult['lname']; ?>">
                                    </div>
                                    <!-- แถวที่ 2 -->
                                    <div class="col-md-4 mt-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control " value="<?php echo $objResult['email']; ?>">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="org" class="form-label">สังกัด</label>
                                        <input id="org" name="org" class="form-control" value="<?php echo $objResult['org']; ?>" placeholder="<?php echo $objResult['org']; ?>"></input>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="tel" class="form-label">โทรศัพท์</label>
                                        <input type="text" id="tel" name="tel" class="form-control" value="<?php echo $objResult['tel']; ?>">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" id="password" name="password" class="form-control">
                                        <input type="text" id="uid" name="uid" class="form-control" hidden value="<?php echo $objResult['U_id']; ?>">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="ststus" class="form-label">สถานะผู้ใช้งาน</label>
                                        <input type="text" id="tel" name="uststus" class="form-control" value="<?php echo $objResult['status']; ?>"><label for="ststus" class="form-label" style="color:navy;">user หรือ admin</label>
                                    </div>
                                    <!-- ปุ่มบันทึก -->
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-primary btn-sm">บันทึกการแก้ไข</button>
                                        <a href="user.php"><button type="button" class="btn btn-outline-primary btn-sm">กลับ</button></a>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div><!-- End Default Card -->
        </div>
    </section>
</main><!-- End #main -->

<?php require 'footer.php' ?>

</html>