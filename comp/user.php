<?php
session_start();
if (!isset($_SESSION['user_login'])) { // ถ้าไม่ได้เข้าระบบอยู่
    header("location: login.php"); // redirect ไปยังหน้า login.php
    exit;
}

$user = $_SESSION['user_login'];
if ($user['status'] != 'admin') {
    echo '<script>alert("สำหรับผู้ดูแลระบบเท่านั้น");window.location="index.php";</script>';
    exit;
}
$pagename = 'จัดการสมาชิก';
require './connect.php';
require './header.php';
require './Sidebar.php';

$condition = '';

$sql = "SELECT * FROM user WHERE u_status = 1$condition ORDER BY U_id DESC";
$objQuery = mysqli_query($mysqli, $sql);
// while($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
//     print_r($objResult);
// }
?>
<script>
    var myModal = document.getElementById('myModal')
    var myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', function() {
        myInput.focus()
    })
</script>
<main id="main" class="main">
    <div class="pagetitle">
        <h1><?php echo $pagename; ?></h1>
        
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="mt-4">
                <a href="user_create.php" class="btn btn-success">เพิ่มผู้ใช้</a>
                <a href="user_report.php" class="btn btn-primary">รายงานผู้ใช้</a>
            </div>
            <!-- ตารางข้อมูล -->
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>ชื่อ - สกุล</th>
                        <th>Email </th>
                        <th>เบอร์โทร</th>
                        <th>หน่วยงาน</th>
                        <th>สถานะ</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                    ?>
                        <tr>
                            <td><?php echo $objResult['fname'], ' ', $objResult['lname']; ?></td>
                            <td><?php echo $objResult['email']; ?></td>
                            <td><?php echo $objResult['tel']; ?></td>
                            <td><?php echo $objResult['org']; ?></td>
                            <td><?php echo $objResult['status']; ?></td>
                            <td>
                                <a href="user_update.php?U_id=<?php echo $objResult['U_id']; ?>" class="btn btn-warning btn-sm">Update</a>
                                <a href="user_action_delete.php?u_id=<?php echo $objResult['U_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยัน');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
    </section>
</main><!-- End #main -->

<?php require 'footer.php' ?>

</html>