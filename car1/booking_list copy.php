<?php
session_start();
if (!isset($_SESSION['user_login'])) { // ถ้าไม่ได้เข้าระบบอยู่
    header("location: login.php"); // redirect ไปยังหน้า login.php
    exit;
}
$user = $_SESSION['user_login'];
$pagename = 'รายการจองห้องอบรม ศทส.';
require './con.php';
require './header.php';
require './Sidebar.php';

if ($user['status'] == 'admin') {
    $sql = "SELECT * FROM bookingRoom INNER JOIN user ON bookingRoom.U_id=user.U_id ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM bookingRoom WHERE U_id =" . $user['U_id'] . " ORDER BY id DESC";
}
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
            <?php if ($user['status'] == 'admin') {?><div class="mt-4">
                <a href="booking_report.php" class="btn btn-primary">รายงานการใช้</a>
            </div><?php }?>
            <!-- ตารางข้อมูล -->
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>หัวข้ออบรม</th>
                        <th>วันเวลาเริ่มต้น </th>
                        <th>วันเวลาสิ้นสุด</th>
                        <?php
                        if ($user['status'] == 'admin') {
                            echo '<th>หน่วยงาน</th>
                        <th>ผู้จอง</th>
                        <th>เบอร์ติดต่อ</th>';
                        }
                        ?>
                        <th>สถานะจอง</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    function DateThai2($dates)
                    {
                        $strYear = date("Y", strtotime($dates)) + 543;
                        $strMonth = date("n", strtotime($dates));
                        $strDay = date("j", strtotime($dates));
                        $strHour = date("H", strtotime($dates));
                        $strMinute = date("i", strtotime($dates));
                        $strSeconds = date("s", strtotime($dates));
                        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
                        $strMonthThai = $strMonthCut[$strMonth];
                        return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
                    }
                    while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                    ?>
                        <tr>
                            <td><?php echo $objResult['title']; ?></td>
                            <td><?php echo DateThai2($objResult['start']) . ' ' . 'น.'; ?></td>
                            <td><?php echo DateThai2($objResult['end']) . ' ' . 'น.'; ?></td>
                            <?php
                            if ($user['status'] == 'admin') {?>
                                <td><?php echo $objResult['org']; ?></td>
                            <td><?php echo $objResult['fname'], ' ', $objResult['lname']; ?></td>
                            <td><?php echo $objResult['tel']; ?></td>
                            <?php }
                            ?>
                            <td><?php if ($objResult['B_status'] == "accept") {
                                    echo '<span class="badge bg-success">อนุมัติแล้ว</span>';
                                } elseif ($objResult['B_status'] == "Suspend") {
                                    echo ' <span class="badge bg-warning text-dark">รออนุมัติ</span>';
                                } else echo '<span class="badge bg-danger">ยกเลิก</span>';
                                ?></td>
                            <td>
                                <a href="booking_update.php?id=<?php echo $objResult['id']; ?>" class="btn btn-outline-warning btn-sm">Update</a>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal">ยกเลิก</button>
                                <div class="modal fade" id="rejectModal" tabindex="-1">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">โปรดยืนยันการยกเลิก</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <div class="icon">
                                                        <i class="ri-alarm-warning-line" style="font-size: 2rem; color: red;"></i>

                                                        <h6 style="color:red;font-weight:bold;">คุณต้องการยกเลิกการจองใช่หรือไม่?</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                <a href="booking_reject.php?id=<?php echo $objResult['id']; ?>"><button type=" button" class="btn btn-danger btn-sm">ยืนยัน</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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