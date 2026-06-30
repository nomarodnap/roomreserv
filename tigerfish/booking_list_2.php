<?php
session_start();
if (!isset($_SESSION['user_login'])) { // ถ้าไม่ได้เข้าระบบอยู่
    header("location: login.php"); // redirect ไปยังหน้า login.php
    exit;
}
$user = $_SESSION['user_login'];
$pagename = 'รายการจองห้องประชุมเสือตอ';
require './connect.php';
require './header.php';
require './Sidebar.php';

// ตรวจสอบว่ามี U_id ในตัวแปร $user หรือไม่
if (!isset($user['U_id'])) {
    echo "Error: User ID not found.";
    exit;
}

if ($user['status'] == 'admin') {
    $sql = "SELECT * FROM bookingRoom_2 INNER JOIN user ON bookingRoom_2.U_id=user.U_id ORDER BY start DESC";
    $stmt = $mysqli->prepare($sql); // เตรียมคำสั่ง SQL สำหรับผู้ดูแลระบบ
} else {
    $sql = "SELECT * FROM bookingRoom_2 WHERE U_id = ? ORDER BY id DESC";
    $stmt = $mysqli->prepare($sql); // เตรียมคำสั่ง SQL สำหรับผู้ใช้ทั่วไป
    $stmt->bind_param("i", $user['U_id']); // ผูกค่า U_id เพื่อป้องกัน SQL injection
}

// ดำเนินการคำสั่ง SQL
$stmt->execute();
$objQuery = $stmt->get_result();
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
            <?php if ($user['status'] == 'admin') { ?>
                <div class="mt-4">
                    <a href="booking_report_2.php" class="btn btn-primary">รายงานการใช้</a>
                </div>
            <?php } ?>
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
                        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
                        $strMonthThai = $strMonthCut[$strMonth];
                        return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
                    }

                    // แสดงข้อมูลในตาราง
                    while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                    ?>
                        <tr>
                            <td><?php echo $objResult['title']; ?></td>
                            <td><?php echo DateThai2($objResult['start']) . ' น.'; ?></td>
                            <td><?php echo DateThai2($objResult['end']) . ' น.'; ?></td>
                            <?php
                            if ($user['status'] == 'admin') { ?>
                                <td><?php echo $objResult['org']; ?></td>
                                <td><?php echo $objResult['fname'] . ' ' . $objResult['lname']; ?></td>
                                <td><?php echo $objResult['tel']; ?></td>
                            <?php }
                            ?>
                            <td>
                                <?php if ($objResult['B_status'] == "accept") {
                                    echo '<span class="badge bg-success">อนุมัติแล้ว</span>';
                                } elseif ($objResult['B_status'] == "Suspend") {
                                    echo '<span class="badge bg-warning text-dark">รออนุมัติ</span>';
                                } else {
                                    echo '<span class="badge bg-danger">ยกเลิก</span>';
                                } ?>
                            </td>
                            <td>
                                <a href="booking_update_2.php?ref=<?php echo $objResult['id']; ?>" class="btn btn-outline-info btn-sm">Update</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main><!-- End #main -->

<?php require 'footer.php'; ?>
</html>