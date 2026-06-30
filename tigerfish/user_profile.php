<?php
session_start();
if (!isset($_SESSION['user_login'])) { // ถ้าไม่ได้เข้าระบบอยู่
    header("location: login.php"); // redirect ไปยังหน้า login.php
    exit;
}
$pagename = 'อัพเดทข้อมูลผู้ใช้';
require 'header.php';
require 'Sidebar.php';
$user = $_SESSION['user_login'];
include_once('./function.php');
$objCon = connectDB();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(() => {
        $('#newpassword, #renewpassword').on('keyup', function() {
            if ($('#newpassword').val() == "" && $('#renewpassword').val() == "") {
                $('#submit-pass').prop('disabled', true);
                $('#message').hide();
                $("#savepassword").attr("enabled", "enabled");
            } else if ($('#newpassword').val() == $('#renewpassword').val()) {
                $('#submit-pass').prop('disabled', false);
                $('#message').show().html('รหัสผ่านตรงกัน <i class="bi bi-check-circle-fill"></i>').css('color', 'green');
                $("#savepassword").attr("enabled", "enabled");
            } else {
                $('#submit-pass').prop('disabled', true);
                $('#message').show().html('รหัสผ่านไม่ตรงกัน <i class="bi bi-x-circle-fill"></i>').css('color', 'red');
                $("#savepassword").attr("disabled", "disabled");
            }
        });
    });
    $(function() {
        // Now, DOM is ready. 
        $("form input").on({
            "keyup": function() {
                var pass = $('#newpassword').val();
                var confirmPass = $('#renewpassword').val();
                var saveButton = $("#savepassword");
                if (pass == confirmPass) {
                    saveButton.removeAttr('disabled');
                } else {
                    saveButton.attr('disabled', 'disabled');
                }
            }
        });
    });
</script>
<main id="main" class="main">
    <div class="pagetitle">
        <h1><?php echo $pagename; ?></h1>
        <nav>
            <ol class="breadcrumb">
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="./assets/img/favicon.png" alt="Profile" class="rounded-circle">
                        <h2><?php echo $user['fname'] . ' ' . $user['lname']; ?></h2>
                        <h6><?php echo $user['org']; ?></h6>
                        <h6><?php echo $user['email']; ?></h6>
                        <h6><?php echo $user['tel']; ?></h6>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Edit Profile</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <form action="./uuprof.php" method="post" id="profileupdate" name="profileupdate" enctype="multipart/form-data" novalidate class="needs-validation">
                                    <div class=" row mb-3">
                                        <input type="text" name="uid" value="<?php echo $user['U_id']; ?>" hidden>
                                        <label for="fname" class="col-md-4 col-lg-3 col-form-label">ชื่อ - สกุล</label>
                                        <div class="col-md-4 col-lg-4">
                                            <input name="fname" type="text" class="form-control" id="fname" value="<?php echo $user['fname']; ?>">
                                        </div>
                                        <div class="col-md-4 col-lg-4">
                                            <input name="lname" type="text" class="form-control" id="lname" value="<?php echo $user['lname']; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="org" class="col-md-4 col-lg-3 col-form-label">หน่วยงาน</label>
                                        <div class="col-md-8 col-lg-8">
                                            <input name="org" type="text" class="form-control" id="org" value="<?php echo $user['org']; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-8">
                                            <input name="email" type="text" class="form-control" id="email" value="<?php echo $user['email']; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="tel" class="col-md-4 col-lg-3 col-form-label">เบอร์ติดต่อ</label>
                                        <div class="col-md-8 col-lg-8">
                                            <input name="tel" type="text" class="form-control" id="tel" value="<?php echo $user['tel']; ?>">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary" name="saveprofile " id="saveprofile">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form action="./uupass.php" method="post" id="passwordupdate" name="passwordupdate" enctype="multipart/form-data" novalidate class="needs-validation">
                                    <input type="text" class="form-control" hidden name="uid" id="uid" value="<?php echo $user['U_id']; ?>">
                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">รหัสผ่านใหม่<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-8">
                                            <input name="newpassword" type="password" class="form-control" id="newpassword" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">กรอกรหัสผ่านใหม่อีกครั้ง<span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-lg-8">
                                            <input name="renewpassword" type="password" class="form-control" id="renewpassword" required>
                                            <span id="message"></span>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary" name="savepassword" disabled="disabled" id="savepassword">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
</main><!-- End #main -->
<?php require 'footer.php' ?>

</html>