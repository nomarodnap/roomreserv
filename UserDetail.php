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

$colname_Recordset1 = "-1";
if (isset($_GET['pid'])) {
  $colname_Recordset1 = $_GET['pid'];
}
mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
$query_Recordset1 = sprintf("SELECT * FROM userhistory WHERE USERNAME = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $ReservBookRooms) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>รายละเอียดผู้จอง</title>
</head>

<body>
<table width="250" border="1">
  <tr>
    <td colspan="3"><div align="center"><strong>ข้อมูลผู้ใช้</strong></div></td>
  </tr>
  <tr>
    <td width="30"><div align="center"><strong>ชื่อ</strong></div></td>
    <td width="30"><div align="center"><strong>สกุล</strong></div></td>
    <td width="141"><div align="center"><strong>เบอร์</strong></div></td>
  </tr>
  <?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
    <tr>
      <td><?php echo $row_Recordset1['fname']; ?></td>
      <td><?php echo $row_Recordset1['lname']; ?></td>
      <td><div align="center"><?php echo $row_Recordset1['u_phone']; ?></div></td>
    </tr>
    <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
  <tr>
    <td colspan="3">ไม่พบข้อมูล</td>
  </tr>
  <?php } // Show if recordset empty ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
