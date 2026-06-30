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
$query_Rs_list_room_reserv = "SELECT * FROM reservroom WHERE time_in > now() OR time_out > now() ORDER BY time_in ASC";
$Rs_list_room_reserv = mysql_query($query_Rs_list_room_reserv, $ReservBookRooms) or die(mysql_error());
$row_Rs_list_room_reserv = mysql_fetch_assoc($Rs_list_room_reserv);
$totalRows_Rs_list_room_reserv = mysql_num_rows($Rs_list_room_reserv);
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
  <table width="1190" border="1">
    <tr>
      <td colspan="6"><div align="center"><strong>รายการจองห้อง</strong></div></td>
    </tr>
    <tr>
      <td width="100"><div align="center"><strong>ชื่อห้อง</strong></div></td>
      <td width="110"><div align="center"><strong>เวลาเริ่ม</strong></div></td>
      <td width="110"><div align="center"><strong>เวลาสิ้นสุด</strong></div></td>
      <td width="200"><div align="center"><strong>วัตถุประสงค์</strong></div></td>
      <td width="230"><div align="center"><strong>รายละเอียด</strong></div></td>
      <td width="70"><div align="center"><strong>ผู้จอง</strong></div></td>
    </tr>
    <?php do { ?>
      <?php if ($totalRows_Rs_list_room_reserv > 0) { // Show if recordset not empty ?>
        <tr>
          <td><div align="center"><?php echo $row_Rs_list_room_reserv['r_name']; ?></div></td>
          <td><div align="center"><?php
		  $str_TimeIn = date("d/m/Y H:i:s",strtotime($row_Rs_list_room_reserv['time_in']));
		  echo $str_TimeIn; ?></div></td>
          <td><div align="center"><?php
		  $str_TimeOut = date("d/m/Y H:i:s",strtotime($row_Rs_list_room_reserv['time_out']));
		  echo $str_TimeOut; ?></div></td>
          <td><font size=2><?php 
		  if($row_Rs_list_room_reserv['t_goal']=="Conferent"){
		  echo "[อบรมเรื่อง] ".$row_Rs_list_room_reserv['goal_detail']." (".$row_Rs_list_room_reserv['goal_sub1'].")"; 
		  }else{
			  echo $row_Rs_list_room_reserv['goal_detail']; 
		  }
		  ?></font></td>
          <td><?php echo $row_Rs_list_room_reserv['t_detail']; ?></td>
          <td><div align="center"><font color="#0000FF"><strong><a href="#" onClick="js_popup('UserDetail.php?pid=<?php echo $row_Rs_list_room_reserv['do_by']; ?>',300,90); return false;" title="<?php echo $row_Rs_list_room_reserv['do_by']; ?>"></a><?php echo $row_Rs_list_room_reserv['do_by']; ?></strong></font></div></td>
        </tr>
        <?php } // Show if recordset not empty ?>
      <?php } while ($row_Rs_list_room_reserv = mysql_fetch_assoc($Rs_list_room_reserv)); ?>
<tr>
  <?php if ($totalRows_Rs_list_room_reserv == 0) { // Show if recordset empty ?>
    <td colspan="6">ไม่มีข้อมูล</td>
    <?php } // Show if recordset empty ?>
    </tr>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($Rs_list_room_reserv);
?>
