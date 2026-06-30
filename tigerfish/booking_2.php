<?php
session_start();
if (!isset($_SESSION['user_login'])) { // ถ้าไม่ได้เข้าระบบอยู่
    header("location: login.php"); // redirect ไปยังหน้า login.php
    exit;
}
$pagename = 'จองห้องอบรม';
require 'header.php';
require 'Sidebar.php';
$user = $_SESSION['user_login'];
?>
<!-------- addon  ----------->
<link rel="stylesheet" media="all" type="text/css" href="./assets/js/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="./assets/js/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="./assets/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="./assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="./assets/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="./assets/js/jquery-ui-sliderAccess.js"></script>
<script>
    $(function() {

        var startDateTextBox = $('#startdate');
        var endDateTextBox = $('#enddate');

        startDateTextBox.datepicker({
            dateFormat: 'd-m-yy',
            onClose: function(dateText, inst) {
                if (endDateTextBox.val() != '') {
                    var testStartDate = startDateTextBox.datetimepicker('getDate');
                    var testEndDate = endDateTextBox.datetimepicker('getDate');
                    if (testStartDate > testEndDate)
                        endDateTextBox.datetimepicker('setDate', testStartDate);
                } else {
                    endDateTextBox.val(dateText);
                }
            },
            onSelect: function(selectedDateTime) {
                endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate'));
            }
        });
        endDateTextBox.datepicker({
            dateFormat: 'd-m-yy',
            onClose: function(dateText, inst) {
                if (startDateTextBox.val() != '') {
                    var testStartDate = startDateTextBox.datetimepicker('getDate');
                    var testEndDate = endDateTextBox.datetimepicker('getDate');
                    if (testStartDate > testEndDate)
                        startDateTextBox.datetimepicker('setDate', testEndDate);
                } else {
                    startDateTextBox.val(dateText);
                }
            },
            onSelect: function(selectedDateTime) {
                startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate'));
            }
        });

    });
</script>
<main id="main" class="main">
    <div class="pagetitle">
        <h1><?php echo $pagename; ?></h1>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="card w-80 mb-3">
                <h5 class="card-header">กรุณากรอกรายละเอียด</h5>
                <div class="card-body">
                    <form novalidate action="action_booking_2.php" method="post" enctype="multipart/form-data" class="needs-validation">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">วัตถุประสงค์การใช้งาน</label>
                            <div class="col-sm-8">
                                <input type="text" name="title" class="form-control" required>
                                <div class="invalid-feedback">กรุณากรอกวัตถุประสงค์การใช้งาน</div>
                            </div>
                        </div>
                        <div class="row mb-3">
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
        </div>
    </section>
</main><!-- End #main -->

<?php require 'footer.php' ?>

</html>