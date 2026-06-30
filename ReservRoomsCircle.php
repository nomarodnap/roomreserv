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

$query_rs_user_history = sprintf("SELECT fname, lname, u_phone FROM userhistory WHERE USERNAME = %s ORDER BY USERNAME ASC", GetSQLValueString($_POST['hidUname'], "text"));
$rs_user_history = mysql_query($query_rs_user_history, $ReservBookRooms) or die(mysql_error());
$row_rs_user_history = mysql_fetch_assoc($rs_user_history);

function compareDateUp($date1,$date2) {
		$timeStmp1 = $date1;
		$timeStmp2 = $date2;

		 if ($timeStmp1 == $timeStmp2) {
			//echo "\$date = \$date2";
			return false;
		} else if ($timeStmp1 > $timeStmp2) {
			//echo "\$date > \$date2";
			return true;
		} else if ($timeStmp1 < $timeStmp2) {
			//echo "\$date < \$date2";
			return false;
		}
	}
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$RoomNumber = "-1";
if (isset($_POST['select'])){
  $RoomNumber = $_POST['select'];
}
mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
$query_Rs_check_time = sprintf("SELECT r_name, time_in, time_out FROM reservroom WHERE r_name = %s AND time_out > now() ORDER BY time_in ASC", GetSQLValueString($RoomNumber, "text"));
$Rs_check_time = mysql_query($query_Rs_check_time, $ReservBookRooms) or die(mysql_error());
//$row_Rs_check_time = mysql_fetch_assoc($Rs_check_time);
$totalRows_Rs_check_time = mysql_num_rows($Rs_check_time);

if($_POST['RadioGoal']=="Other"){
	$_POST['TxtGoal']=$_POST['TxtGoal2'];
	$_POST['TxtGoalSub1']="";
	$_POST['TxtGoalSub2']="";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
if($_POST['hidUname']!= ""){	
if ((!empty($_POST['time_in'])) && (!empty($_POST['time_out']))) {
  $T_timein = new DateTime($_POST['time_in']);
  $T_timeout = new DateTime($_POST['time_out']);
  
	$remainTime = compareDateUp($T_timein,$T_timeout);
	while($remainTime == false){
	//$T_timein->modify('next 7 days');
	$remainTime = compareDateUp($T_timein,$T_timeout);
  if ($remainTime == false){
	  $CalTime1 = $T_timein->format('Y-m-d H:i:s');
	  $Rdate1 = substr($CalTime1,0,10);
	  $Rtime1 = substr($_POST['time_out'],11,8);
	  $CalTime2 = $Rdate1." ".$Rtime1;
   $insertSQL = sprintf("INSERT INTO reservroom (r_name, time_in, time_out, t_goal, goal_detail, goal_sub1, goal_sub2, t_detail, do_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['select'], "text"),
                       //GetSQLValueString($_POST['time_in'], "date"),
					   GetSQLValueString($CalTime1, "text"),
                       //GetSQLValueString($_POST['time_out'], "date"),
					   GetSQLValueString($CalTime2, "text"),
                       GetSQLValueString($_POST['RadioGoal'], "text"),
                       GetSQLValueString($_POST['TxtGoal'], "text"),
                       GetSQLValueString($_POST['TxtGoalSub1'], "text"),
                       GetSQLValueString($_POST['TxtGoalSub2'], "text"),
                       GetSQLValueString($_POST['txtdetail'], "text"),
                       GetSQLValueString($_POST['hidUname'], "text"));
					   				   
   mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
  $Result1 = mysql_query($insertSQL, $ReservBookRooms) or die(mysql_error());
  //echo "<br />วันที่/เวลา หลังจากเพิ่มอีก 7 วัน = ".$T_timein->format('Y-m-d H:i:s');
  }
  $T_timein->modify('next 7 days');
}
   echo "<div align='center' style='color:#093'><strong>บันทึกเรียบร้อยแล้ว </strong></div>";
}
else{
		echo "<script language=\"JavaScript\">";
		echo "alert('คุณยังไม่ได้ระบุวันเริ่มและสิ้นสุดครับ');";
		echo "</script>"; 
}	
}
else{
		echo "<script language=\"JavaScript\">";
		echo "alert('คุณยังไม่ได้เข้าสู่ระบบ กรุณาเข้าสู่ระบบก่อนทำการจองห้องครับ');";
		echo "</script>"; 
}	
}

mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
$query_Rs_list_room = "SELECT * FROM listroom WHERE r_status <> 'ปิดปรับปรุง' ORDER BY r_name ASC";
$Rs_list_room = mysql_query($query_Rs_list_room, $ReservBookRooms) or die(mysql_error());
$row_Rs_list_room = mysql_fetch_assoc($Rs_list_room);
$totalRows_Rs_list_room = mysql_num_rows($Rs_list_room);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>หน้าจองห้องประชุม</title>
<style>
body,img,p,h1,h2,h3,h4,h5,h6,form,table,td,ul,li,dl,dt,dd,pre,blockquote,fieldset,label{
margin:0;
padding:0;
border:1;
}
/* css for timepicker */
.clear{ clear: both; }
#ui-datepicker-div, .ui-datepicker{ font-size: 80%; }
.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
.ui-timepicker-div dl { text-align: left; }
.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
.ui-timepicker-div td { font-size: 90%; }
.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
</style>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<script type="text/javascript" src="js/jquery-1_7_2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.18.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
</head>

<body>
<script>
$(function(){

//แบบมี OPTION     
$('#timer').datetimepicker({
timeOnlyTitle: 'เลือกเวลา',
timeText: 'เวลา',
hourText: 'ชั่วโมง',
minuteText: 'นาที',
secondText: 'วินาที',
currentText: 'ปัจจุบัน',
closeText: 'ปิด',
dateFormat: 'yy-mm-dd',
timeFormat: 'HH:mm:ss',
showSecond: true,
ampm: true,
hourGrid: 4,
minuteGrid: 10
});

$('#timer2').datetimepicker({
timeOnlyTitle: 'เลือกเวลา',
timeText: 'เวลา',
hourText: 'ชั่วโมง',
minuteText: 'นาที',
secondText: 'วินาที',
currentText: 'ปัจจุบัน',
closeText: 'ปิด',
dateFormat: 'yy-mm-dd',
timeFormat: 'HH:mm:ss',
showSecond: true,
ampm: true,
hourGrid: 4,
minuteGrid: 10
});
 
//หรือจะใช้แบบไม่มี Option ก็ใช้แบบนี้ได้ครับ บรรทัดเดียวจบเลย ได้ทั้งปฏิทินและเวลา
//$('#timer').timepicker();
});
 
</script>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <div align="center">
    <table width="881" border="1">
      <tr>
        <td colspan="3"><div align="center"><strong>ข้อมูลการจองห้องประชุมรายภาค</strong></div></td>
      </tr>
      <tr>
        <td width="168"><div align="right"><strong>ชื่อห้องที่ต้องการจอง</strong></div></td>
        <td width="3">&nbsp;</td>
        <td width="688"><label for="select"></label>
          <div align="left">
            <select name="select" id="select">
              <?php
do {  
?>
              <option value="<?php echo $row_Rs_list_room['r_name']?>"><?php echo $row_Rs_list_room['r_name']?></option>
              <?php
} while ($row_Rs_list_room = mysql_fetch_assoc($Rs_list_room));
  $rows = mysql_num_rows($Rs_list_room);
  if($rows > 0) {
      mysql_data_seek($Rs_list_room, 0);
	  $row_Rs_list_room = mysql_fetch_assoc($Rs_list_room);
  }
?>
            </select>
        </div></td>
      </tr>
      <tr>
        <td><div align="right"><strong>ช่วงเวลาเริ่มต้น </strong></div></td>
        <td>&nbsp;</td>
        <td><div align="left">
          <input type="text" name="time_in" id="timer" readonly="readonly" />
        </div></td>
      </tr>
      <tr>
        <td><div align="right"><strong>ช่วงเวลาสิ้นสุด</strong></div></td>
        <td>&nbsp;</td>
        <td><div align="left">
          <input type="text" name="time_out" id="timer2" readonly="readonly" />
        </div></td>
      </tr>
      <tr>
        <td><div align="right"><strong>วัตถุประสงค์</strong></div></td>
        <td>&nbsp;</td>
        <td><p>
          <input name="RadioGoal" type="radio" id="RadioGoal" value="Teach" checked="checked" />
          <label for="RadioGoal">สอนวิชา</label>
          <label for="TxtGoal"></label>
          <input type="text" name="TxtGoal" id="TxtGoal" />
          <label for="TxtGoalSub1">ให้ นศ. คณะ</label>
          <input type="text" name="TxtGoalSub1" id="TxtGoalSub1" />
          <label for="TxtGoalSub2">สาขา</label>
          <input type="text" name="TxtGoalSub2" id="TxtGoalSub2" />
        </p>
        <p>
          <input type="radio" name="RadioGoal" id="RadioGoal2" value="Other" />
          <label for="RadioGoal2">วัตถุประสงค์อื่น(ระบุ)</label>
          <label for="TxtGoal"></label>
          <input type="text" name="TxtGoal2" id="TxtGoal" />
        </p></td>
      </tr>
      <tr>
        <td><div align="right"><strong>อุปกรณ์ที่ต้องการให้จัด</strong></div></td>
        <td>&nbsp;</td>
        <td><textarea name="txtdetail" cols="45" id="txtdetail"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;
        <input name="hidUname" type="hidden" id="hidUname" value="<?php echo $_SESSION['MM_Username'] ?>" />
        <label for="textfield"></label></td>
        <td>&nbsp;</td>
        <td><div align="left">
          <input type="submit" name="button" id="button" value="จอง" /> 
          <input type="reset" name="button2" id="button2" value="เคลียร์ค่า" />
        </div></td>
      </tr>
    </table>
  </div>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p align="center" style="color:#0000FF">&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Rs_list_room);
?>
