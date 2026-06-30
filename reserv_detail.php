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

$colname_rs_reserv_detail = "-1";
if (isset($_GET['Rname'])) {
  $colname_rs_reserv_detail = $_GET['Rname'];
}
mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
$query_rs_reserv_detail = sprintf("SELECT * FROM reservroom WHERE r_name = %s AND time_out > now() ORDER BY time_in ASC", GetSQLValueString($colname_rs_reserv_detail, "text"));
$rs_reserv_detail = mysql_query($query_rs_reserv_detail, $ReservBookRooms) or die(mysql_error());
$row_rs_reserv_detail = mysql_fetch_assoc($rs_reserv_detail);
$totalRows_rs_reserv_detail = mysql_num_rows($rs_reserv_detail);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>รายงานจอง</title>

<script language="javascript">
function js_popup(theURL,width,height) { //v2.0
	leftpos = (screen.availWidth - width) / 2;
    	toppos = (screen.availHeight - height) / 2;
  	window.open(theURL, "viewdetails","width=" + width + ",height=" + height + ",left=" + leftpos + ",top=" + toppos);
}
</script>

</head>

<body>
<div align="center">
  <table width="781" border="1">
    <tr>
      <td colspan="4"><div align="center"><strong>รายการจองห้องอบรม</strong></div></td>
    </tr>
    <tr>
      <td width="100"><div align="center"><strong>ชื่อห้อง</strong></div></td>
      <td width="80"><div align="center"><strong>เวลาเริ่ม</strong></div></td>
      <td width="80"><div align="center"><strong>เวลาสิ้นสุด</strong></div></td>
      <td width="80"><div align="center"><strong>ผู้จอง</strong></div></td>
    </tr>
    <?php do { ?>
      <?php if ($totalRows_rs_reserv_detail > 0) { // Show if recordset not empty ?>
        <tr>
          <td><div align="center"><?php echo $row_rs_reserv_detail['r_name']; ?></div></td>
          <td><div align="center"><?php
		  $str_TimeIn = date("d/m/Y H:i:s",strtotime($row_rs_reserv_detail['time_in']));
		  echo $str_TimeIn; ?></div></td>
          <td><div align="center"><?php
		  $str_TimeOut = date("d/m/Y H:i:s",strtotime($row_rs_reserv_detail['time_out']));
		  echo $str_TimeOut; ?></div></td>
          <td><div align="center"><a href="#" onClick="js_popup('UserDetail.php?pid=<?php echo $row_rs_reserv_detail['do_by']; ?>',300,90); return false;" title="<?php echo $row_rs_reserv_detail['do_by']; ?>"><?php echo $row_rs_reserv_detail['do_by']; ?></a></div></td>
        </tr>
        <?php } // Show if recordset not empty ?>
      <?php } while ($row_rs_reserv_detail = mysql_fetch_assoc($rs_reserv_detail)); ?>
    <?php if ($totalRows_rs_reserv_detail == 0) { // Show if recordset empty ?>
      <tr>
        <td colspan="4"><div align="left"><strong>ไม่มีข้อมูล</strong></div></td>
      </tr>
      <?php } // Show if recordset empty ?>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($rs_reserv_detail);
?>
