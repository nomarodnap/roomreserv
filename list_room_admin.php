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
<?php require_once('Connections/ReservBookRooms.php'); ?>
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

mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
//if($btnsearch != NULL)  //ตรวจสอบว่ามีการกดปุ่มค้นหาหรือไม่
//{
	if($_POST['txtsearch']!="")
	{
		$query_Rs_listroom = "SELECT * FROM listroom WHERE r_name LIKE '".$_POST['txtsearch']."%' ORDER BY r_name ASC";
	}
	else
	{
  		$query_Rs_listroom = "SELECT * FROM listroom ORDER BY r_name ASC";
	}
//}
//else
//{
  //$query_Rs_listroom = "SELECT * FROM listroom ORDER BY r_name ASC";
//}
$Rs_listroom = mysql_query($query_Rs_listroom, $ReservBookRooms) or die(mysql_error());
$row_Rs_listroom = mysql_fetch_assoc($Rs_listroom);
$totalRows_Rs_listroom = mysql_num_rows($Rs_listroom);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>รายงานจอง</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <label for="txtsearch"></label>
  <div align="center">โปรดระบุชื่อห้องที่ต้องการค้นหา
    <input type="text" name="txtsearch" id="txtsearch" />
   <input type="submit" name="btnsearch" id="btnsearch" value="ค้นหา" />
  </div>
</form>
<div align="center">
  <table width="855" border="1">
    <tr>
      <th colspan="5" scope="col">รายการห้องทั้งหมด</th>
    </tr>
    <tr>
      <th width="199" scope="col"><div align="center">ชื่อห้อง</div></th>
      <th width="181" scope="col"><div align="center">สถานะ</div></th>
      <th width="147" scope="col"><div align="center">รายละเอียดการจอง</div></th>
      <th colspan="2" scope="col">&nbsp;</th>
    </tr>
    <?php if ($totalRows_Rs_listroom > 0) { // Show if recordset not empty ?>
      <?php do { ?>
        <tr>
          <td><div align="center"><?php echo $row_Rs_listroom['r_name']; ?></div></td>
          <td><div align="center"><?php echo $row_Rs_listroom['r_status']; ?></div></td>
          <td><div align="center">แสดง</div></td>
          <td width="147"><div align="center"><strong><a href="Edit_room.php?txtRname=<?php echo $row_Rs_listroom['r_name']; ?>">แก้ไข</a></strong></div></td>
          <td width="147"><div align="center"><strong><a href="Delete_room.php?txtRname=<?php echo $row_Rs_listroom['r_name']; ?>">ลบ</a></strong></div></td>
        </tr>
        <?php } while ($row_Rs_listroom = mysql_fetch_assoc($Rs_listroom)); ?>
  <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_Rs_listroom == 0) { // Show if recordset empty ?>
      <tr>
        <td colspan="5">ไม่มีข้อมูล</td>
      </tr>
      <?php } // Show if recordset empty ?>
  </table>
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Rs_listroom);
?>
