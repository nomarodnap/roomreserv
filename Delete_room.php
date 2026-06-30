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

if ((isset($_POST['txtRname'])) && ($_POST['txtRname'] != "")) {
  $deleteSQL = sprintf("DELETE FROM listroom WHERE r_name=%s",
                       GetSQLValueString($_POST['txtRname'], "text"));

  mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
  $Result1 = mysql_query($deleteSQL, $ReservBookRooms) or die(mysql_error());

  $deleteGoTo = "list_room_admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Rs_room_detail = "-1";
if (isset($_GET['txtRname'])) {
  $colname_Rs_room_detail = $_GET['txtRname'];
}
mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
$query_Rs_room_detail = sprintf("SELECT * FROM listroom WHERE r_name = %s", GetSQLValueString($colname_Rs_room_detail, "text"));
$Rs_room_detail = mysql_query($query_Rs_room_detail, $ReservBookRooms) or die(mysql_error());
$row_Rs_room_detail = mysql_fetch_assoc($Rs_room_detail);
$totalRows_Rs_room_detail = mysql_num_rows($Rs_room_detail);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <div align="center">
    <table width="297" border="1">
      <tr>
        <td colspan="3"><div align="center"><strong>ลบข้อมูลห้อง</strong></div></td>
      </tr>
      <tr>
        <td width="98"><div align="right">ชื่อห้อง</div></td>
        <td width="1">&nbsp;</td>
        <td width="176"><label for="txtRname"></label>
          <div align="left">
            <input name="txtRname" type="text" id="txtRname" value="<?php echo $row_Rs_room_detail['r_name']; ?>" />
        </div></td>
      </tr>
      <tr>
        <td><div align="right">สถานะ</div></td>
        <td>&nbsp;</td>
        <td><label for="cboStatus"></label>
          <div align="left">
            <select name="cboStatus" id="cboStatus" title="<?php echo $row_Rs_room_detail['r_status']; ?>">
              <?php
do {  
?>
              <option value="<?php echo $row_Rs_room_detail['r_status']?>"><?php echo $row_Rs_room_detail['r_status']?></option>
              <?php
} while ($row_Rs_room_detail = mysql_fetch_assoc($Rs_room_detail));
  $rows = mysql_num_rows($Rs_room_detail);
  if($rows > 0) {
      mysql_data_seek($Rs_room_detail, 0);
	  $row_Rs_room_detail = mysql_fetch_assoc($Rs_room_detail);
  }
?>
            </select>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="left">
          <input type="submit" name="btnDelete" id="btnDelete" value="ลบ" />
        </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php
mysql_free_result($Rs_room_detail);
?>
