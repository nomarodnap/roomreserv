<?php
session_start();
if (!isset($_SESSION['user_login'])) { // ถ้าไม่ได้เข้าระบบอยู่
    header("location: ../login.php"); // redirect ไปยังหน้า login.php
    exit;
}

$selectedDate = isset($_GET['date']) ? $_GET['date'] : ''; 

$pagename = 'จองห้องประชุมเสือตอ';
require_once 'header.php';
require_once 'Sidebar.php';
$user = $_SESSION['user_login'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-------- addon  ----------->
    <link rel="stylesheet" media="all" type="text/css" href="./assets/js/jquery-ui.css" />
    <link rel="stylesheet" media="all" type="text/css" href="./assets/js/jquery-ui-timepicker-addon.css" />
    <script type="text/javascript" src="./assets/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="./assets/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="./assets/js/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript" src="./assets/js/jquery-ui-sliderAccess.js"></script>
    <script>
        $(document).ready(function() {
            // กำหนดค่าเริ่มต้นให้กับฟิลด์วันที่
            var selectedDate = '<?php echo $selectedDate; ?>';
            if (selectedDate) {
                $('#startdate').val(selectedDate);
                $('#enddate').val(selectedDate);
            }
        });

        $(function() {
            var startDateTextBox = $('#startdate');
            var endDateTextBox = $('#enddate');

            startDateTextBox.datepicker({
                dateFormat: 'dd-mm-yy',
                onClose: function(dateText, inst) {
                    if (endDateTextBox.val() != '') {
                        var testStartDate = startDateTextBox.datepicker('getDate');
                        var testEndDate = endDateTextBox.datepicker('getDate');
                        if (testStartDate > testEndDate)
                            endDateTextBox.datepicker('setDate', testStartDate);
                    } else {
                        endDateTextBox.val(dateText);
                    }
                },
                onSelect: function(selectedDateTime) {
                    endDateTextBox.datepicker('option', 'minDate', startDateTextBox.datepicker('getDate'));
                }
            });
            endDateTextBox.datepicker({
                dateFormat: 'dd-mm-yy',
                onClose: function(dateText, inst) {
                    if (startDateTextBox.val() != '') {
                        var testStartDate = startDateTextBox.datepicker('getDate');
                        var testEndDate = endDateTextBox.datepicker('getDate');
                        if (testStartDate > testEndDate)
                            startDateTextBox.datepicker('setDate', testEndDate);
                    } else {
                        startDateTextBox.val(dateText);
                    }
                },
                onSelect: function(selectedDateTime) {
                    startDateTextBox.datepicker('option', 'maxDate', endDateTextBox.datepicker('getDate'));
                }
            });
        });
    </script>
</head>
<body>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1><?php echo $pagename; ?></h1>
        </div><!-- End Page Title -->
        <section class="section dashboard">
            <div class="row">
                <div class="card w-80 mb-3">
                    <h5 class="card-header">กรุณากรอกรายละเอียด</h5>
                    <div class="card-body">
                        <form novalidate action="action_booking.php" method="post" enctype="multipart/form-data" class="needs-validation">
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">หัวข้อเรื่องประชุม</label>
                                <div class="col-sm-8">
                                    <input type="text" name="title" class="form-control" required>
                                    <div class="invalid-feedback">กรุณากรอกหัวข้อเรื่องประชุม</div>
                                </div>
                            </div>                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">วันและเวลาเริ่มต้น</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="startdate" id="startdate" required>
                                    <div class="invalid-feedback">กรุณากรอกวันเริ่มต้น</div>
                                </div>
                                <label for="inputText" class="col-sm-2 col-form-label">เวลาเริ่มต้น</label>
                                <div class="col-sm-3">
                                    <input type="time" class="form-control" name="starttime" value="09:00" required min="08:00" max="19:00">
                                    <div class="invalid-feedback">กรุณากรอกเวลาเริ่มต้น</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">วันและเวลาสิ้นสุด</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="enddate" id="enddate" required>
                                    <div class="invalid-feedback">กรุณากรอกวันสิ้นสุด</div>
                                </div>
                                <label for="inputText" class="col-sm-2 col-form-label">เวลาสิ้นสุด</label>
                                <div class="col-sm-3">
                                    <input type="time" class="form-control" name="endtime" value="16:30" required min="08:00" max="19:00">
                                    <div class="invalid-feedback">กรุณากรอกเวลาสิ้นสุด</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">จำนวนผู้ใช้งาน</label>
                                <div class="col-sm-4">
                                    <select class="form-select" aria-label="Default select example" name="persion" required placeholder="รองรับได้ไม่เกิน 25 คน">
                                        <?php for ($x = 1; $x <= 25; $x++) {
                                            echo "<option value=" . '"' . $x . '">' . $x . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="inputText" class="col-form-label" style="color:red;">รองรับได้ไม่เกิน 25 คน <i class="ri ri-admin-fill"></i> </label>
                                </div>
                            </div>
                            <input hidden name="uid" value="<?php echo $user['U_id']; ?>">
                            <button type="submit" class="btn btn-info rounded-pill">บันทึกการจอง</button>
                            <button type="reset" class="btn btn-light rounded-pill">ล้างค่า</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    <?php require_once 'footer.php'; ?>
</body>
</html>
