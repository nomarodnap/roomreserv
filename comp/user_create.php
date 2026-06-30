<?php
session_start();
$pagename = "เพิ่มผู้ใช้งาน";
include './header.php';
include './Sidebar.php';
$user = $_SESSION['user_login'];
if ($user['status'] != 'admin') {
    echo '<script>alert("สำหรับผู้ดูแลระบบเท่านั้น");window.location="index.php";</script>';
    exit;
}
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1><?php echo $pagename; ?></h1>
    </div><!-- End Page Title -->
    <div class="container">
        <!-- ฟอร์มเพิ่มข้อมูล -->
        <div class="card">
            <div class="card-body">
                <form action="user_action_creatuser.php" id="form_creatuser" method="post" enctype="multipart/form-data" novalidate class="needs-validation">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row mt-4">
                                <!-- แถวที่ 1 -->
                                <div class="col-md-4 mt-3">
                                    <label for="fname" class="form-label">ชื่อ<span class="text-danger">*</span></label>
                                    <input type="text" id="fname" name="fname" class="form-control" required placeholder="นายเทคโน">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="lname" class="form-label">สกุล<span class="text-danger">*</span></label>
                                    <input type="text" id="lname" name="lname" class="form-control" required placeholder="ชอบไอที">
                                </div>
                                <!-- แถวที่ 2 -->
                                <div class="col-md-4 mt-3">
                                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control " required placeholder="test@test.com">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="org" class="form-label">สังกัด<span class="text-danger">*</span></label>
                                    <input id="org" name="org" class="form-control" required placeholder="ศูนย์เทคโนโลยีสารสนเทศ">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="tel" class="form-label">โทรศัพท์<span class="text-danger">*</span></label>
                                    <input type="text" id="tel" name="tel" class="form-control" required maxlength="10" placeholder="เช่น 029406275">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="status" class="form-label">ประเภทผู้ใช้งาน<span class="text-danger">*</span></label>
                                    <select class="form-select" aria-label="Default select example" d="u_level" name="u_level" required>
                                        <option selected value="user">ผู้ใช้งานทั่วไป</option>
                                        <option value="admin">ผู้ดูแลระบบ</option>
                                    </select>
                                </div>

                                <!-- ปุ่มบันทึก -->
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary btn-sm">เพิ่มข้อมูล</button>
                                    <a href="user.php"><button type="button" class="btn btn-outline-primary btn-sm">กลับ</button></a>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</main>
<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
    </div>
</footer>

<script src="./js/bootstrap.bundle.min.js"></script>
<script src="./js/script.js"></script>
<script>
    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('c_image_preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
<?php include './footer.php'; ?>

</html>