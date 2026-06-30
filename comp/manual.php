<?php
session_start();
$pagename = 'คู่มือการใช้งาน';
require 'header.php';
require 'Sidebar.php';
?>
<main id="main" class="main">
    <section class="section dashboard">
        <div class="page-header theme-bg-dark py-5 text-center position-relative">
            <div class="theme-bg-shapes-right"></div>
            <div class="theme-bg-shapes-left"></div>
            <div class="container">
                <h1 class="page-heading single-col-max mx-auto">คู่มือการใช้งานระบบจองห้องประชุมเสือตอ</h1>
                <div class="page-intro single-col-max mx-auto"><a href="./assets/pdf/Manual_roomreserv.pdf">ดาวน์โหลดเอกสาร <i class="bi bi-cloud-download"></i></a> </div>
            </div>
        </div>
        <div class="page-content">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <!-- Bordered Tabs Justified -->
                        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100 active" id="role-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-role" type="button" role="tab" aria-controls="role" aria-selected="true">ขั้นตอน</button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100" id="function-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-function" type="button" role="tab" aria-controls="function" aria-selected="true">Function</button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100" id="login-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-login" type="button" role="tab" aria-controls="login" aria-selected="false">ลงทะเบียนและลงชื่อเข้าใช้</button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100" id="booking-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-booking" type="button" role="tab" aria-controls="booking" aria-selected="false">การจอง</button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                            <div class="tab-pane fade show active" id="bordered-justified-role" role="tabpanel" aria-labelledby="role-tab">
                                <div class="card">
                                    <div class="card-body">
                                       <!-- <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators">
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                            </div>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">-->
                                                    <img src="./assets/img/roomreserv2.png" class="d-block w-100" alt="...">
                                               <!-- </div>
                                                <div class="carousel-item">
                                                    <img src="./assets/img/roomreserv.png" class="d-block w-100" alt="...">
                                                </div>
                                            </div>

                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>

                                        </div><!-- End Slides with indicators -->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="bordered-justified-function" role="tabpanel" aria-labelledby="function-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <p>ผู้ใช้งานสามารถดูรายละเอียดการจองห้องได้ โดยไม่ต้องลงชื่อเข้าใช้งาน<br>โดยสถานะของห้องแบ่งออกเป็น 3 ประเภทไดเแก่</p>
                                        <ul>
                                            <li> <span class="text-success">สีเขียว</span> คือ อนุมัติการจองแล้ว</li>
                                            <li> <span class="text-warning">สีเหลือง</span> คือ รอการอนุมัติ</li>
                                            <li> <span class="text-danger">สีแดง</span> คือ ยกเลิกการจอง</li>
                                        </ul>
                                        <!-- Slides with indicators -->
                                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators">
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                                            </div>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="./assets/img/Screenshot 2566-11-02 at 09.14.52.png" class="d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="./assets/img/Screenshot 2566-11-02 at 09.20.08.png" class="d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="./assets/img/Screenshot 2566-11-02 at 09.17.17.png" class="d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="./assets/img/Screenshot 2566-11-02 at 09.29.42.png" class="d-block w-100" alt="...">
                                                </div>
                                            </div>

                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>

                                        </div><!-- End Slides with indicators -->

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="bordered-justified-login" role="tabpanel" aria-labelledby="login-tab">
                                ผู้ใช้งาน จะต้องลงชื่อเข้าใช้งานก่อนจึงจะสามารถจองห้องได้
                                <div class="row">
                                    <div class="card col-6">
                                        <div class="card-body">
                                            <h5 class="card-title">หน้าจอการลงทะเบียน</h5>
                                            <p class="card-text">กรุณากรอกข้อมูลให้ครบถ้วนและตรวจสอบข้อมูลของท่านให้ถูกต้อง</p>
                                        </div>
                                        <img src="./assets/img/Screenshot 2566-11-03 at 11.08.04.png" class="card-img-bottom" alt="...">
                                    </div>
                                    <div class="card col-6">
                                        <div class="card-body">
                                            <h5 class="card-title">หน้าจอการลงชื่อเข้าใช้</h5>
                                            <p class="card-text">กรอก Email และ Password ที่ท่านลงทะเบียนไว้</p>
                                        </div>
                                        <img src="./assets/img/Screenshot 2566-11-02 at 09.15.23.png" class="card-img-top" alt="...">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="bordered-justified-booking" role="tabpanel" aria-labelledby="booking-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Accordion without outline borders -->
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                        การจองห้อง
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body" style="font-weight:bold;">คลิกที่แถบเมนู "จองห้องอบรม" จากนั้นกรอกรายละเอียดให้ครบถ้วน</div>
                                                    <img src="./assets/img/Screenshot 2566-11-02 at 09.16.15.png" class="img-fluid">
                                                    <hr>
                                                    <div class="accordion-body" style="font-weight:bold;">เมื่อบันทึกการจอแล้ว จะแสดงแจ้งเตือนจองสำเร็จ</div>
                                                    <img src="./assets/img/Screenshot 2566-11-02 at 09.16.32.png" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingTwo">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                        ตรวจสอบสถานะการจอง
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body" style="font-weight:bold;">ท่านสามารถดูรายละเอียดการจอง และสถานะการจองได้จากแถมเมนูรายการจอง</div>
                                                    <img src="./assets/img/Screenshot 2566-11-02 at 09.21.42.png" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingThree">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                        แก้ไขข้อมูลการจองและยกเลิกการจอง
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body" style="font-weight:bold;">ท่านสามารถคลิก "Update" ในหน้ารายการจองเพื่อแก้ไขข้อมูลการจอง</div>
                                                    <img src="./assets/img/Screenshot 2566-11-02 at 09.28.04.png" class="img-fluid">
                                                    <hr>
                                                    <div class="accordion-body" style="font-weight:bold;">หากต้องการยกเลิกการจอง ให้เลือกช่องสถานะเป็น "ยกเลิกการจอง"</div>
                                                    <img src="./assets/img/Screenshot 2566-11-02 at 09.28.11.png" class="img-fluid">
                                                    <blockquote class="blockquote" style="color:red;">
                                                        <p>หากท่านยกเลิกการจองแล้ว จะไม่สามารถคืนสถานะได้ กรุณาติดต่อผู้ดูแลระบบเพื่อคืนสถานะการจอง</p>
                                                        <p>การจองที่มีสถานนะ
                                                            <span style="color:green;">"อนุมัติการจอง"</span> จะไม่สามารถแก้ไขได้ หากต้องการยกเลิกกรุณาติดต่อผู้ดูแลระบบ
                                                        </p>
                                                    </blockquote>
                                                </div>
                                            </div>
                                        </div><!-- End Accordion without outline borders -->

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel" aria-labelledby="profile-tab">
                                ผู้ใช้งานสามารถปรับปรุงข้อมูลที่ลงทะเบียนเอาไว้ได้ โดยคลิกที่แถบเมนูด้านบนขวา และเลือก Accout Setting
                                <div class="text-center"><img src="./assets/img/Screenshot 2566-11-03 at 08.47.58.png" class="img-fluid"></div>
                                <hr>
                                กรอกข้อมูลในส่วนที่ต้องการแก้ไขข้อมูล
                                <img src="./assets/img/Screenshot 2566-11-03 at 08.48.12.png" class="img-fluid">

                            </div>
                        </div><!-- End Bordered Tabs Justified -->

                    </div>
                </div>
            </div>
        </div><!--//page-content-->
    </section>
</main><!-- End #main -->

<?php require 'footer.php' ?>

</html>