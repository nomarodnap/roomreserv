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

if($_POST['hidRid'] > 0)
		{
			$sql="delete from reservroom where reserv_id = ".$_POST['hidRid'];
			mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
        	$rsdel = mysql_query($sql, $ReservBookRooms) or die(mysql_error());
		}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
if($_SESSION['MM_UserGroup'] > 0 )
{
	$query_Recordset1 = "SELECT * FROM reservroom WHERE time_in > now() ORDER BY time_in ASC";
}
else
{
	$query_Recordset1 = sprintf("SELECT * FROM reservroom WHERE do_by = %s AND time_in > now() ORDER BY time_in ASC", GetSQLValueString($colname_Recordset1, "text"));
}
$Recordset1 = mysql_query($query_Recordset1, $ReservBookRooms) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>รายการจองห้อง</title>

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
  <table width="1007" border="1">
    <tr>
      <td colspan="6"><div align="center"><strong>รายการจองห้อง</strong></div></td>
    </tr>
    <tr>
      <td width="142"><div align="center"><strong>ชื่อห้อง</strong></div></td>
      <td width="140"><div align="center"><strong>เวลาเริ่ม</strong></div></td>
      <td width="149"><div align="center"><strong>เวลาสิ้นสุด</strong></div></td>
      <td width="340"><div align="center"><strong>วัตถุประสงค์</strong></div></td>
      <td width="100"><div align="center"><strong>ผู้จอง</strong></div></td>
      <td width="76"><div align="center"><strong>การกระทำ</strong></div></td>
    </tr>
    <?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
      <?php do { ?>
        <tr>
          <td><div align="center"><?php echo $row_Recordset1['r_name']; ?></div></td>
          <td><div align="center"><?php
		  $str_TimeIn = date("d/m/Y H:i:s",strtotime($row_Recordset1['time_in']));
		  echo $str_TimeIn; ?></div></td>
          <td><div align="center"><?php
		  $str_TimeOut = date("d/m/Y H:i:s",strtotime($row_Recordset1['time_out']));
		  echo $str_TimeOut; ?></div></td>
          <td><font size=2><?php echo $row_Recordset1['goal_detail']; ?></font></td>
          <td><div align="center"><font color="#0000FF"><strong><a href="#" onClick="js_popup('UserDetail.php?pid=<?php echo $row_Recordset1['do_by']; ?>',300,90); return false;" title="<?php echo $row_Recordset1['do_by']; ?>"><?php echo $row_Recordset1['do_by']; ?></a></strong></font></div></td>
          <td><div align="center">
            <form id="form1" name="form1" method="post" action="">
              <input name="hidRid" type="hidden" id="hidRid" value="<?php echo $row_Recordset1['reserv_id']; ?>" />
              <input name="imgsubmit" type="image" id="imgsubmit" src="Images/cancel_stamp.jpg" alt="ยกเลิกรายการ" width="59" height="14" />
            </form>
          </div></td>
        </tr>
        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
      <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
  <tr>
    <td colspan="6"><div align="left">ไม่มีข้อมูล</div></td>
  </tr>
  <?php } // Show if recordset empty ?>
  </table> 
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
