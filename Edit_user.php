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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmAddUser")) {
  $updateSQL = sprintf("UPDATE login SET PASSWORD=%s, U_LEVEL=%s WHERE USERNAME=%s",
                       GetSQLValueString($_POST['txtpassword'], "text"),
                       GetSQLValueString($_POST['cbolevel'], "int"),
                       GetSQLValueString($_POST['txtusername'], "text"));

  mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
  $Result1 = mysql_query($updateSQL, $ReservBookRooms) or die(mysql_error());

  $updateGoTo = "Manage_user.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Rs_add_user = "-1";
if (isset($_GET['txtusername'])) {
  $colname_Rs_add_user = $_GET['txtusername'];
}
mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
$query_Rs_add_user = sprintf("SELECT * FROM login WHERE USERNAME = %s", GetSQLValueString($colname_Rs_add_user, "text"));
$Rs_add_user = mysql_query($query_Rs_add_user, $ReservBookRooms) or die(mysql_error());
$row_Rs_add_user = mysql_fetch_assoc($Rs_add_user);
$totalRows_Rs_add_user = mysql_num_rows($Rs_add_user);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>แก้ไขข้อมูลผู้ใช้งานระบบ</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" id="form1" name="frmAddUser" method="POST">
  <div align="center">
    <table width="309" border="1">
      <tr>
        <td height="30" colspan="4"><div align="center"><strong>แก้ไขข้อมูลผู้ใช้งานระบบ</strong></div></td>
      </tr>
      <tr>
        <td width="73">USERNAME</td>
        <td width="2">&nbsp;</td>
        <td colspan="2"><input name="txtusername" type="text" id="txtusername" value="<?php echo $row_Rs_add_user['USERNAME']; ?>" readonly="readonly" /></td>
      </tr>
      <tr>
        <td>PASSWORD</td>
        <td>&nbsp;</td>
        <td colspan="2"><input name="txtpassword" type="text" id="txtpassword" value="<?php echo $row_Rs_add_user['PASSWORD']; ?>" /></td>
      </tr>
      <tr>
        <td>LEVEL</td>
        <td>&nbsp;</td>
        <td colspan="2"><div align="left">
          <select name="cbolevel" size="1" id="cbolevel" title="<?php echo $row_Rs_add_user['U_LEVEL']; ?>">
            <?php
			if($row_Rs_add_user['U_LEVEL']=="1")
			{
				echo "<option value='1' selected='selected'>ผู้ดูแลระบบ</option>";
				echo "<option value='0' >ผู้ใช้งานระบบ</option>";
				echo "<option value='2' >ผู้ใช้งานพิเศษ</option>";
			}
			elseif($row_Rs_add_user['U_LEVEL']=="0")
			{
				echo "<option value='0' selected='selected'>ผู้ใช้งานระบบ</option>";
				echo "<option value='2' >ผู้ใช้งานพิเศษ</option>";
				echo "<option value='1' >ผู้ดูแลระบบ</option>";
			}
			elseif($row_Rs_add_user['U_LEVEL']=="2")
			{
				echo "<option value='2' selected='selected'>ผู้ใช้งานพิเศษ</option>";
				echo "<option value='0' >ผู้ใช้งานระบบ</option>";
				echo "<option value='1' >ผู้ดูแลระบบ</option>";
			}
			?>
            </select>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="106"><input type="submit" name="bttAdd" id="bttAdd" value="แก้ไข" /></td>
        <td width="100"><input type=button value="ยกเลิก"onClick="javascript:window.open('','_self');window.close()" ></td>
      </tr>
    </table>
  </div>
  <input type="hidden" name="MM_update" value="frmAddUser" />
</form>
</body>
</html>
<?php
mysql_free_result($Rs_add_user);
?>
