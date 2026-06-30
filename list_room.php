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
  <table width="549" border="1">
    <tr>
      <th colspan="3" scope="col">รายการห้องทั้งหมด</th>
    </tr>
    <tr>
      <th width="199" scope="col"><div align="center">ชื่อห้อง</div></th>
      <th width="181" scope="col"><div align="center">สถานะ</div></th>
      <th width="147" scope="col"><div align="center">รายละเอียดการจอง</div></th>
    </tr>
    <?php if ($totalRows_Rs_listroom > 0) { // Show if recordset not empty ?>
      <?php do { ?>
        <tr>
          <td><div align="center"><?php echo $row_Rs_listroom['r_name']; ?></div></td>
          <td><div align="center"><?php echo $row_Rs_listroom['r_status']; ?></div></td>
          <td><div align="center"><a href="reserv_detail.php?Rname=<?php echo $row_Rs_listroom['r_name']; ?>" target="_new">แสดง</a></div></td>
        </tr>
        <?php } while ($row_Rs_listroom = mysql_fetch_assoc($Rs_listroom)); ?>
  <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_Rs_listroom == 0) { // Show if recordset empty ?>
      <tr>
        <td colspan="3">ไม่มีข้อมูล</td>
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
