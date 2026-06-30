<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ระบบจองห้องอบรมออนไลน์</title>
<!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<div align="center">
<!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
            <img src="Images/banner_logo.png" width="100" height="74" /><img src="Images/banner_system.png" width="320" height="80" align="top" /><a href="index.html" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-primary">            </h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                  <a href="Main.php?act=0" class="nav-item nav-link active">Home</a>
                  <a href="Main.php?act=1" class="nav-item nav-link">รายการจอง</a>
                    <a href="Main.php?act=2" class="nav-item nav-link">ข้อมูลห้องอบรม</a>
                    <a href="Main.php?act=5" class="nav-item nav-link">ยกเลิกการจอง</a>
                   <!-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Jobs</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="job-list.html" class="dropdown-item">Job List</a>
                            <a href="job-detail.html" class="dropdown-item">Job Detail</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="category.html" class="dropdown-item">Job Category</a>
                            <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                            <a href="404.html" class="dropdown-item">404</a>
                        </div>
                    </div>-->
                  <a href="#" class="nav-item nav-link">คู่มือ</a>
                </div>
              <a href="Main.php?act=7" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">About Us<i class="fa fa-arrow-right ms-3"></i></a>
            </div>
  </nav>
</div>

<div align="center">
    <p align="center">ชื่อผู้ใช้ : <?php 
  if($_SESSION['MM_Username']!="" )
  {
  echo $_SESSION['MM_Username']."  ==> "."<a href='$logoutAction '>ออกจากระบบ</a>";
  }
  else
  {
	  echo  "Guest"."  ==> "."<a href='login.php'>ลงชื่อเข้าใช้งานระบบ </a>";
  }
  ?>
 </p>
  <p align="center">
  <?php if($_SESSION['MM_UserGroup']=="1" )
  {
	  echo "<a href=Main.php?act=6><img src='Images/08.png' width='106'height='107' border='0' /></a>";
  	  echo "<a href=Main.php?act=3><img src='Images/04.png' width='106'height='107' border='0' /></a>";
  }elseif($_SESSION['MM_UserGroup']=="2" )
  {
	  echo "<a href=Main.php?act=6><img src='Images/08.png' width='106'height='107' border='0' /></a>";
  }
   ?><!--<a href="download.php?pic=Files/Manual.pdf"><img src="Images/05.png" width="82" height="101" border="0" /></a><a href="Main.php?act=5"><img src="Images/06.png" width="128" height="102" border="0" /></a><a href="http://203.157.229.33/ReservBookRooms/Webboard/Webboard.php" target="_new"><img src="Images/07.png" width="93" height="101" border="0" /></a><a href="Main.php?act=7"><img src="Images/09.jpg" width="111" height="96" border="0" /></a></p>-->
</div><hr >
<p align="center">
  <?php 
if($_GET["act"]=="1")   //ตรวจสอบว่าลิ๊งค์ใดถูกคลิก
{
  include("list_reserv.php");
}
elseif($_GET["act"]=="2") 
{
  include("list_room.php");
}
elseif($_GET["act"]=="3") 
{
  include("Manage_admin.php");
}
elseif($_GET["act"]=="5") 
{
  include("reserv_cancel.php");
}
elseif($_GET["act"]=="6") 
{
  include("ReservRoomsCircle.php");
}
elseif($_GET["act"]=="7") 
{
  include("About.php");
}
else
{
  include("ReservRooms.php");
}
?>
</p>

</body>
</html>