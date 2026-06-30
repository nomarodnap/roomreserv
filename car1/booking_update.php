<?php
session_start();
include_once('./function.php');
$objCon = connectDB();
if (!isset($_SESSION['user_login']) || empty($_SESSION['user_login']['status'])) {
    echo '<script>alert("ลงชื่อเข้าใช้งานก่อน");window.location="./";</script>';
    exit;
}
$user = $_SESSION['user_login'];
if ($user['status'] == '') {
    echo '<script>alert("ลงชื่อเข้าใช้งานก่อน");window.location="./";</script>';
    exit;
}

if (empty($_GET['ref'])) {
    echo '<script>alert("ข้อมูลการจองไม่ถูกต้อง");window.location="./";</script>';
    exit;
}
$id = $_GET['ref'];
$strSQL = "SELECT * FROM car1 LEFT JOIN user ON car1.U_id=user.U_id WHERE id = '$id'";
$strSQL2 = "SELECT * FROM car1 LEFT JOIN user ON car1.admin_update=user.U_id WHERE id = '$id'";

$objQuery = mysqli_query($objCon, $strSQL);
$objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);
$objQuery2 = mysqli_query($objCon, $strSQL2);
$objResult2 = mysqli_fetch_array($objQuery2, MYSQLI_ASSOC);

if ($objResult == null) {
    echo '<script>alert("ไม่พบข้อมูล!!");window.location="./";</script>';
    exit;
}


$pagename = 'อัพเดทข้อมูลการจอง';
require 'header.php';
require 'Sidebar.php';
if ($objResult['B_status'] == 'Suspend') {
    $status1 =
        "<div class='btn btn-warning btn-lg'>" .
        "<i class='fa fa-remove pr-2'></i> รออนุมัติ</div>";
} elseif ($objResult['B_status'] == 'reject') {
    $status1 =
        "<button class='btn btn-danger btn-lg'>" .
        "<i class='fa fa-remove pr-2'></i> ยกเลิก</button>";
    $st = "<br><button type='button' class='btn btn-danger btn-sm'>ยกเลิกแล้ว</button>";
} elseif ($objResult['B_status'] == 'accept') {
    $status1 =
        "<button class='btn btn-success btn-lg'>" .
        "<i class='fa fa-check pr-2'></i> อนุมัติแล้ว </button>";
} else {
    $status1 =
        "<button class='btn btn-primary btn-lg'>" .
        "<i class='fa fa-refresh pr-2'></i>  อนุมัติ / รอใช้</button>";
}
// Default value for $disabled and $hidden
$disabled = '';
$hidden = '';

// Conditionally set the values
if ($objResult['B_status'] != 'Suspend' && $user['status'] != 'admin_1') {
    $disabled = 'disabled';
    $hidden = 'hidden';
}


// ตรวจสอบสิทธิ์ผู้ใช้
$canEdit = ($user['status'] == 'admin_1' || $user['U_id'] == $objResult['U_id']);
$canApprove = ($user['status'] == 'admin_1');
$disabled = $canEdit ? '' : 'disabled';

// ฟังก์ชันแปลงวันเวลา
function formatDate($datetime) {
    return date('d/m/Y H:i', strtotime($datetime));
}

// แปลงวันเวลา
$startFormatted = formatDate($objResult['start']);
$endFormatted = formatDate($objResult['end']);
?>

<main id="main" class="main">
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>อัพเดทข้อมูลการจอง</h1>
        <nav>
            <ol class="breadcrumb">
            </ol>
        </nav>
    </div>

    <!-- Section -->
<section class="section dashboard">
    <div class="row">
        <div class="col-sm-9 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-body">
                    <form action="booking_action_update.php" id="form_update" method="post" enctype="multipart/form-data">
                        <div class="col-md-9">
                            <div class="row mt-3">
                                <!-- แถวที่ 1 -->
                                <div class="row-md-3">
                                    <label for="title" class="form-label">ขออนุญาติใช้รถไป</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon3">ไป</span>
                                        <input type="text" id="title" name="title" class="form-control" <?php echo $canEdit ? '' : 'disabled'; ?> value="<?php echo $objResult['title']; ?>">
                                    </div>
                                </div>
								<div class="row-md-3 mt-3">
    <label for="purpose" class="form-label">จุดประสงค์ในการใช้รถ</label>
    <textarea id="purpose" name="purpose" class="form-control" rows="3" <?php echo $canEdit ? '' : 'disabled'; ?>><?php echo htmlspecialchars($objResult['purpose']); ?></textarea>
</div>

                                <div class="col-md-6 mt-3">
                                    <label for="start" class="form-label">วันเวลาออกเดินทาง</label>
                                    <input type="datetime-local" id="lname" name="start" class="form-control" value="<?php echo $objResult['start']; ?>" <?php echo $disabled; ?>>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="end" class="form-label">วันเวลากลับเดินทาง</label>
                                    <input type="datetime-local" id="end" name="end" class="form-control" value="<?php echo $objResult['end']; ?>" <?php echo $disabled; ?>>
                                </div>
<div class="col-md-4 mt-3">
    <label for="persion" class="form-label">จำนวนผู้โดยสาร</label>
    <div class="input-group col-sm-2">
        <select class="form-select" id="persion" name="persion" <?php echo $canEdit ? '' : 'disabled'; ?> required>
            <?php 
            for ($x = 1; $x <= 13; $x++) {
                // ตรวจสอบเพื่อให้ค่าเริ่มต้นตรงกับค่าจากฐานข้อมูล
                $selected = ($objResult['persion'] == $x) ? 'selected' : '';
                echo "<option value=\"$x\" $selected>$x</option>";
            } 
            ?>
        </select>
        <span class="input-group-text" id="basic-addon2">คน</span>
    </div>
</div>

                                <div class="col-md-8 mt-3">
                                    <label for="org" class="form-label">หน่วยงาน</label>
                                    <input type="text" id="org" name="org" class="form-control" value="<?php echo $objResult['org']; ?>" disabled>
                                </div>
<div class="col-md-6 mt-3">
    <label for="user" class="form-label">ผู้จอง</label>
    <input type="text" id="uid" name="fame" class="form-control" value="<?php echo $objResult['fname'] . ' ' . $objResult['lname']; ?>" disabled>
</div>

<?php
// เปลี่ยนค่าในเงื่อนไขการตรวจสอบ
$isAdmin = $user['status'] === 'admin_1';
$isBookingOwner = $_SESSION['user_login']['U_id'] === $objResult['U_id']; // ใช้ U_id แทนชื่อเต็ม
?>

<div class="col-md-6 mt-3">
    <label for="status" class="form-label">สถานะการจอง</label>
    <select class="form-select" id="B_status" name="B_status">
        <?php if ($isAdmin): ?>
            <option value="Suspend" <?php echo $objResult['B_status'] == 'Suspend' ? 'selected' : ''; ?>>รออนุมัติ</option>
            <option value="accept" <?php echo $objResult['B_status'] == 'accept' ? 'selected' : ''; ?>>อนุมัติ</option>
            <option value="reject" <?php echo $objResult['B_status'] == 'reject' ? 'selected' : ''; ?>>ยกเลิก</option>
        <?php elseif ($isBookingOwner): ?>
            <option value="Suspend" <?php echo $objResult['B_status'] == 'Suspend' ? 'selected' : ''; ?>>รออนุมัติ</option>
            <option value="reject" <?php echo $objResult['B_status'] == 'reject' ? 'selected' : ''; ?>>ยกเลิก</option>
        <?php endif; ?>
    </select>
</div>

<?php if ($isAdmin): ?>
<div class="col-md-6 mt-3" id="driver-section" style="display: <?php echo ($objResult['B_status'] == 'accept') ? 'block' : 'none'; ?>;">
    <label for="driver" class="form-label">คนขับรถ</label>
    <select class="form-select" id="driver" name="driver" <?php echo $canEdit ? '' : 'disabled'; ?>>
        <option value="">-- เลือกคนขับ --</option>
        <option value="นายกิตติศักดิ์ พรมวิเศษ (ต้น) โทร. 097-053-9462" <?php echo $objResult['driver'] == 'นายกิตติศักดิ์ พรมวิเศษ (ต้น) โทร. 097-053-9462' ? 'selected' : ''; ?>>นายกิตติศักดิ์ พรมวิเศษ (ต้น) โทร. 097-053-9462</option>
        <option value="นายครรชิต จันทร์เพ็ญ (หนึ่ง) โทร. 087-025-3354" <?php echo $objResult['driver'] == 'นายครรชิต จันทร์เพ็ญ (หนึ่ง) โทร. 087-025-3354' ? 'selected' : ''; ?>>นายครรชิต จันทร์เพ็ญ (หนึ่ง) โทร. 087-025-3354</option>
    </select>
</div>

<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const statusSelect = document.getElementById("B_status");
    const driverSection = document.getElementById("driver-section");

    function toggleDriverSection() {
        if (statusSelect.value === "accept") {
            driverSection.style.display = "block";
        } else {
            driverSection.style.display = "none";
        }
    }

    // เรียกตอนโหลดหน้า
    toggleDriverSection();

    // เรียกเมื่อมีการเปลี่ยนสถานะ
    statusSelect.addEventListener("change", toggleDriverSection);
});
</script>




<!-- ทำให้ "หมายเหตุ" ขึ้นบรรทัดใหม่ -->
<div class="col-12 mt-3">
    <label for="remark" class="form-label">หมายเหตุ:</label>
    <input type="text" class="form-control" name="remark" value="<?php echo $objResult['remark']; ?>">
</div>

                                <!-- Hidden Inputs -->
                                <input hidden type="text" name="uid" value="<?php echo $objResult['U_id']; ?>">
                                <input hidden type="text" name="id" value="<?php echo $objResult['id']; ?>">
                                <!-- ปุ่มบันทึก -->
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary btn-sm" <?php echo $canEdit ? '' : 'disabled'; ?>>บันทึกการแก้ไข</button>
                                    <a href="booking_list.php" class="btn btn-outline-primary btn-sm">กลับ</a>
                                </div>
                            </div>
                        </div>
                    </form>
					<script>
document.getElementById("form_update").addEventListener("submit", function (e) {
    const status = document.getElementById("B_status").value;
    const driver = document.getElementById("driver").value;

    if (status === "accept" && driver === "") {
        alert("กรุณาเลือกคนขับรถก่อนอนุมัติการจอง");
        document.getElementById("driver").focus();
        e.preventDefault(); // หยุดการส่งฟอร์ม
    }
});
</script>

                </div>
            </div>
        </div>
        <!-- Status Card -->
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">สถานะการจองปัจจุบัน</h5>
                    <?php echo $status1; ?>
                    <p style="font-size: 15px;">
                        <?php echo 'Update: ' . $objResult['date_update']; ?><br>
                        <?php echo 'by: ' . $objResult2['fname'] . ' ' . $objResult2['lname']; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

</main>
<!-- End #main -->

<?php require 'footer.php' ?>

</html>
