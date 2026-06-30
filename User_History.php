<?php require_once('Connections/ReservBookRooms.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "Index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  if($_POST['txtusername'] != "")
	{
		$rsUserCheck = mysql_query( "Select * from userhistory Where USERNAME LIKE "."'".$_POST['txtusername']."'");
		$countUserCheck = mysql_num_rows($rsUserCheck);
		if($countUserCheck > 0){
			 $updateSQL = sprintf("UPDATE userhistory SET fname=%s, lname=%s, u_address=%s, u_phone=%s WHERE USERNAME=%s",
                       GetSQLValueString($_POST['txtfname'], "text"),
                       GetSQLValueString($_POST['txtlname'], "text"),
					   GetSQLValueString($_POST['txtaddress'], "text"),
					   GetSQLValueString($_POST['txtphone'], "text"),
                       GetSQLValueString($_POST['txtusername'], "text"));
					   mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
					   $Result1 = mysql_query($updateSQL) or die(mysql_error());
		}else{
			$insertSQL = sprintf("INSERT INTO userhistory (USERNAME, fname, lname,u_address,u_phone) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtusername'], "text"),
                       GetSQLValueString($_POST['txtfname'], "text"),
					   GetSQLValueString($_POST['txtlname'], "text"),
					   GetSQLValueString($_POST['txtaddress'], "text"),
                       GetSQLValueString($_POST['txtphone'], "text"));
					   mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
                       $Result1 = mysql_query($insertSQL) or die(mysql_error());
		}
		if($Result1){
			echo "<p align='center'><span class='color_green'>บันทึกเรียบร้อยแล้วครับ</span></p>";
		}else{
			echo "<p align='center'><span class='color_red'>ไม่สามารถบันทึกข้อมูลได้ครับ</span></p>";
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('กรุณาระบุชื่อบัญชีผู้ใช้ก่อนครับ')</script>";
	}
//echo "<script>window.location.reload('User_History.php');</script>"; 
}

$colname_rs_user_history = "-1";
if (isset($_GET['txtusername'])) {
  $colname_rs_user_history = $_GET['txtusername'];
}
mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
$query_rs_user_history = sprintf("SELECT * FROM userhistory WHERE USERNAME = %s", GetSQLValueString($colname_rs_user_history, "text"));
$rs_user_history = mysql_query($query_rs_user_history, $ReservBookRooms) or die(mysql_error());
$row_rs_user_history = mysql_fetch_assoc($rs_user_history);
$totalRows_rs_user_history = mysql_num_rows($rs_user_history);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ประวัติผู้ใช้งานระบบ</title>
<style type="text/css">
.color_green {
	color: #008000;
}
.color_red {
	color: #F00;
}
</style>
</head>

<body>
<form id="form1" name="form1" method="POST" action=<?php echo $editFormAction; ?>>
  <div align="center">
    <table width="300" border="1">
      <tr>
        <td colspan="3"><div align="center">ประวัติผู้ใช้งานระบบ</div></td>
      </tr>
      <tr>
        <td width="120"><div align="right">ชื่อผู้ใช้งานระบบ</div></td>
        <td width="1">&nbsp;</td>
        <td width="131"><input name="txtusername" type="text" id="txtusername" value="<?php echo $_GET['txtusername']; ?>" readonly="readonly" /></td>
      </tr>
      <tr>
        <td><div align="right">ชื่อ</div></td>
        <td>&nbsp;</td>
        <td><input name="txtfname" type="text" id="txtfname" value="<?php echo $row_rs_user_history['fname']; ?>" /></td>
      </tr>
      <tr>
        <td><div align="right">นามสกุล</div></td>
        <td>&nbsp;</td>
        <td><input name="txtlname" type="text" id="txtlname" value="<?php echo $row_rs_user_history['lname']; ?>" /></td>
      </tr>
      <tr>
        <td><div align="right">ที่อยู่</div></td>
        <td>&nbsp;</td>
        <td><input name="txtaddress" type="text" id="txtaddress" value="<?php echo $row_rs_user_history['u_address']; ?>" /></td>
      </tr>
      <tr>
        <td><div align="right">เบอร์โทรศัพท์</div></td>
        <td>&nbsp;</td>
        <td><input name="txtphone" type="text" id="txtphone" value="<?php echo $row_rs_user_history['u_phone']; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="left">
        <input type="submit" name="cmdsave" id="cmdsave" value="บันทึก" />
        </div></td>
      </tr>
    </table>
  </div>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p align="left">
  <?php
?>
</p>
<p align="center"><a href="javascript:window.open('','_self');window.close()" >ปิดหน้าต่าง</a></p>
</body>
</html>
<?php
mysql_free_result($rs_user_history);
?>
