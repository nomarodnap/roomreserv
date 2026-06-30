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
if($btnsearch != NULL)  //ตรวจสอบว่ามีการกดปุ่มค้นหาหรือไม่
{
	if($_POST['txtsearch']!="")
	{
  		$query_Rs_show_all_user = "SELECT * FROM login WHERE USERNAME LIKE '".$_POST['txtsearch']."%' ORDER BY USERNAME ASC";
	}
	else
	{
  		$query_Rs_show_all_user = "SELECT * FROM login ORDER BY USERNAME ASC";
	}
}
else
{
  $query_Rs_show_all_user = "SELECT * FROM login ORDER BY USERNAME ASC";
}
$Rs_show_all_user = mysql_query($query_Rs_show_all_user, $ReservBookRooms) or die(mysql_error());
$row_Rs_show_all_user = mysql_fetch_assoc($Rs_show_all_user);
$totalRows_Rs_show_all_user = mysql_num_rows($Rs_show_all_user);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>หน้าจัดการผู้ใช้งานระบบ</title>
</head>

<body>
<div align="center">
  <form id="form2" name="form2" method="post" action="">
    <p>โปรดระบุชื่อผู้ใช้ที่ต้องการค้นหา
  <input type="text" name="txtsearch" id="txtsearch" />
      <input type="submit" name="btnsearch" id="btnsearch" value="ค้นหา" />
    </p>
    <table width="672" border="1">
      <tr>
        <td colspan="5"><div align="center"><strong>หน้าจัดการผู้ใช้งานระบบ</strong></div></td>
      </tr>
      <tr>
        <td width="183"><div align="center"><strong>ชื่อบัญชีผู้ใช้</strong></div></td>
        <td width="184"><div align="center"><strong>รหัสผ่าน</strong></div></td>
        <td width="166"><div align="center"><strong>สิทธิ์การใช้งาน</strong></div></td>
        <td colspan="2"><div align="center"></div>
          <div align="center"></div></td>
      </tr>
      <?php if ($totalRows_Rs_show_all_user > 0) { // Show if recordset not empty ?>
      <?php do { ?>
      <tr>
        <td><div align="center"><a href="User_History.php?txtusername=<?php echo $row_Rs_show_all_user['USERNAME']; ?>"><strong><?php echo $row_Rs_show_all_user['USERNAME']; ?></strong></a></div></td>
        <td><div align="center"><?php echo $row_Rs_show_all_user['PASSWORD']; ?></div></td>
        <td><div align="center">
          <?php //echo $row_Rs_show_all_user['U_LEVEL']; 
		if ($row_Rs_show_all_user['U_LEVEL'] == 1)
		{
			echo "ผู้ดูแลระบบ";
		}
		elseif ($row_Rs_show_all_user['U_LEVEL'] == 0)
		{
			echo "ผู้ใช้งานระบบ";
		}
		elseif ($row_Rs_show_all_user['U_LEVEL'] == 2)
		{
			echo "ผู้ใช้งานพิเศษ";
		}
		else
		{
			echo "ผิดพลาด";
		}
		?>
        </div></td>
        <td width="51"><div align="center"><font color="#006633"><strong><a href="Edit_user.php?txtusername=<?php echo $row_Rs_show_all_user['USERNAME']; ?>">แก้ไข</a></strong></font></div></td>
        <td width="54"><div align="center"><font color="#006633"><strong><a href="Delete_user.php?txtusername=<?php echo $row_Rs_show_all_user['USERNAME']; ?>">ลบ</a></strong></font></div></td>
      </tr>
      <?php } while ($row_Rs_show_all_user = mysql_fetch_assoc($Rs_show_all_user)); ?>
      <?php } // Show if recordset not empty ?>
      <?php if ($totalRows_Rs_show_all_user == 0) { // Show if recordset empty ?>
      <tr>
        <td colspan="5"><div align="left">ไม่พบข้อมูล</div>
          <div align="center"></div>
          <div align="center"></div></td>
      </tr>
      <?php } // Show if recordset empty ?>
    </table>
  </form>
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Rs_show_all_user);
?>
