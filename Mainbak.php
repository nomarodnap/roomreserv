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
</head>

<body>
<div align="center">
  <p align="center"><img src="Images/banner_logo.png" width="189" height="122" /><img src="Images/banner_system.png" width="504" height="134" align="top" /></p>
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
  <p align="center"><a href="Main.php?act=0"><img src="Images/01.png" width="99" height="102" border="0" /></a><a href="Main.php?act=1"><img src="Images/02.png" width="111" height="104" border="0" /></a><a href="Main.php?act=2"><img src="Images/03.png" width="142" height="103" border="0" /></a>
  <?php if($_SESSION['MM_UserGroup']=="1" )
  {
	  echo "<a href=Main.php?act=6><img src='Images/08.png' width='106'height='107' border='0' /></a>";
  	  echo "<a href=Main.php?act=3><img src='Images/04.png' width='106'height='107' border='0' /></a>";
  }elseif($_SESSION['MM_UserGroup']=="2" )
  {
	  echo "<a href=Main.php?act=6><img src='Images/08.png' width='106'height='107' border='0' /></a>";
  }
   ?><a href="download.php?pic=Files/Manual.pdf"><img src="Images/05.png" width="82" height="101" border="0" /></a><a href="Main.php?act=5"><img src="Images/06.png" width="128" height="102" border="0" /></a><a href="http://203.157.229.33/ReservBookRooms/Webboard/Webboard.php" target="_new"><img src="Images/07.png" width="93" height="101" border="0" /></a><a href="Main.php?act=7"><img src="Images/09.jpg" width="111" height="96" border="0" /></a></p>
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