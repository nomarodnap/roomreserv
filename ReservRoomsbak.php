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

function compareDateUp($date1,$date2) {
		$Rdate1 = substr($date1,0,10);
		$arrDate1 = explode("-",$Rdate1);
		$Rdate2 = substr($date2,0,10);
		$arrDate2 = explode("-",$Rdate2);
		$Rtime1 = substr($date1,11,8);
		$arrtime1 = explode(":",$Rtime1);
		$Rtime2 = substr($date2,11,8);
		$arrtime2 = explode(":",$Rtime2);
		$timeStmp1 = mktime($arrtime1[0],$arrtime1[1],$arrtime1[2],$arrDate1[1],$arrDate1[2],$arrDate1[0]);
		$timeStmp2 = mktime($arrtime2[0],$arrtime2[1],$arrtime2[2],$arrDate2[1],$arrDate2[2],$arrDate2[0]);

		 if ($timeStmp1 == $timeStmp2) {
			//echo "\$date = \$date2";
			return true;
		} else if ($timeStmp1 > $timeStmp2) {
			//echo "\$date > \$date2";
			return true;
		} else if ($timeStmp1 < $timeStmp2) {
			//echo "\$date < \$date2";
			return false;
		}
	}
	
	function compareDateDown($date1,$date2) {
		$Rdate1 = substr($date1,0,10);
		$arrDate1 = explode("-",$Rdate1);
		$Rdate2 = substr($date2,0,10);
		$arrDate2 = explode("-",$Rdate2);
		$Rtime1 = substr($date1,11,8);
		$arrtime1 = explode(":",$Rtime1);
		$Rtime2 = substr($date2,11,8);
		$arrtime2 = explode(":",$Rtime2);
		$timeStmp1 = mktime($arrtime1[0],$arrtime1[1],$arrtime1[2],$arrDate1[1],$arrDate1[2],$arrDate1[0]);
		$timeStmp2 = mktime($arrtime2[0],$arrtime2[1],$arrtime2[2],$arrDate2[1],$arrDate2[2],$arrDate2[0]);

		 if ($timeStmp1 == $timeStmp2) {
			//echo "\$date = \$date2";
			return true;
		} else if ($timeStmp1 > $timeStmp2) {
			//echo "\$date > \$date2";
			return false;
		} else if ($timeStmp1 < $timeStmp2) {
			//echo "\$date < \$date2";
			return true;
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
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
if($_POST['textconfirm']== "fisheries"){	
if ((!empty($_POST['time_in'])) && (!empty($_POST['time_out']))) {
  $T_timein = $_POST['time_in'];
  //$D_timein = strtotime($T_timein);
  $T_timeout = $_POST['time_out'];
  //$D_timeout = strtotime($T_timeout);
  $checkdatetime = false;
  
  if($totalRows_Rs_check_time > 0){
  while($value = mysql_fetch_assoc($Rs_check_time)){
	$timeinDB = $value['time_in'];
	//$timeinDB = strtotime($timeinDB);    
	$timeoutDB = $value['time_out'];
	//$timeoutDB = strtotime($timeoutDB); 
	$remainTime1=compareDateUp($T_timein,$timeinDB);
	$remainTime2=compareDateDown($T_timein,$timeoutDB);
	$remainTime3=compareDateUp($T_timeout,$timeinDB);
	$remainTime4=compareDateDown($T_timeout,$timeoutDB);
	
	if (($remainTime1 == true) && ($remainTime2 == true)){
		$checkdatetime = false;
		//$CLoop = "ลูปเวลาเริ่มต้น";
		echo "<script language=\"JavaScript\">";
		echo "alert('ช่วงเวลาเริ่มต้นไม่สามารถเลือกได้');";
		echo "</script>";
		break;
	}
	elseif (($remainTime3 == true) && ($remainTime4 == true)){
		$checkdatetime = false;
		//$CLoop = "ลูปเวลาสิ้นสุด";
		echo "<script language=\"JavaScript\">";
		echo "alert('ช่วงเวลาสิ้นสุดไม่สามารถเลือกได้');";
		echo "</script>";
		break;
	}
	else{
  		$checkdatetime = true;
		//$CLoop = "ลูปเช็คเวลาผ่าน";
	}
  }
}
else{
	$checkdatetime = true;
	//$CLoop = "ไม่มีรายการจองล่วงหน้า";
}
  if ($checkdatetime == true){
	  $stringdetail = "จำนวนผู้เข้าอบรมจำนวน ".$_POST['txtdetail']." คน";
  $insertSQL = sprintf("INSERT INTO reservroom (r_name, time_in, time_out, t_goal, goal_detail, goal_sub1, t_detail, do_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['select'], "text"),
                       GetSQLValueString($_POST['time_in'], "date"),
                       GetSQLValueString($_POST['time_out'], "date"),
                       GetSQLValueString($_POST['RadioGoal'], "text"),
                       GetSQLValueString($_POST['TxtGoal'], "text"),
                       GetSQLValueString($_POST['TxtGoalSub1'], "text"),
                       GetSQLValueString($stringdetail, "text"),
                       GetSQLValueString($_POST['txt_doby'], "text"));

  mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
  $Result1 = mysql_query($insertSQL, $ReservBookRooms) or die(mysql_error());
	
  	$checkdatetime = false;
    echo "<script language=\"JavaScript\">";
	echo "alert('บันทึกการจองเรียบร้อยแล้วครับ');";
	echo "</script>";
  }
  else{
	 	echo "<script language=\"JavaScript\">";
		echo "alert('ไม่สามารถบันทึกรายการจองได้');";
		echo "</script>"; 
  }
}
else{
		echo "<script language=\"JavaScript\">";
		echo "alert('คุณยังไม่ได้ระบุวันเริ่มและสิ้นสุดครับ');";
		echo "</script>"; 
}	
}
else{
		echo "<script language=\"JavaScript\">";
		echo "alert('คุณกรอกข้อความยืนยันไม่ถูกต้องครับ');";
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
<title>หน้าจองห้อง</title>
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
.test {
	color: #FF0000;
}
.color_red {
	color: #F00;
}
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
changeMonth: true,
changeYear: true,
dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
yearRange: '-0:+2',
minDate: 0,
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
changeMonth: true,
changeYear: true,
dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
yearRange: '-0:+2',
minDate: 0,
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
        <td colspan="3"><div align="center"><strong>ข้อมูลการจองห้อง</strong></div></td>
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
          <input name="RadioGoal" type="radio" id="RadioGoal" value="Conferent" checked="checked" />
          <label for="RadioGoal">อบรมเรื่อง</label>
          <label for="TxtGoal"></label>
          <input type="text" name="TxtGoal" id="TxtGoal" />
          <label for="TxtGoalSub1">หน่วยงาน</label>
          <input type="text" name="TxtGoalSub1" id="TxtGoalSub1" />
        </p>
        <p>
          <input type="radio" name="RadioGoal" id="RadioGoal2" value="Other" />
          <label for="RadioGoal2">วัตถุประสงค์อื่น(ระบุ)</label>
          <label for="TxtGoal"></label>
          <input type="text" name="TxtGoal2" id="TxtGoal" />
        </p></td>
      </tr>
      <tr>
        <td><div align="right"><strong>จำนวนผู้เข้าอบรม</strong></div></td>
        <td>&nbsp;</td>
        <td><select name="txtdetail">
              <option value="25" selected> 25
              <option value="24"> 24
			  <option value="23"> 23
			  <option value="22"> 22
			  <option value="21"> 21
			  <option value="20"> 20
			  <option value="19"> 19
			  <option value="18"> 18
			  <option value="17"> 17
			  <option value="16"> 16
			  <option value="15"> 15
			  <option value="14"> 14
			  <option value="13"> 13
			  <option value="12"> 12
			  <option value="11"> 11
			  <option value="10"> 10
			  <option value="9"> 9
			  <option value="8"> 8
			  <option value="7"> 7
			  <option value="6"> 6
			  <option value="5"> 5
			</select> 
        &nbsp;&nbsp; <span class="color_red">หมายเหตุ : ห้องอบรมสามารถจุได้ 25 คนเท่านั้น</span></td>
      </tr>
      <tr>
        <td><div align="right"><strong>ข้อมูลผู้จอง</strong></div></td>
        <td>&nbsp;</td>
        <td><label for="textfield2"></label>
        <input type="text" name="txt_doby" id="textfield2" /> 
        &nbsp;&nbsp;<span class="color_red">ตัวอย่าง : นายวันชัย ใจดี โทร.091-2348762</span></td>
      </tr>
      <tr>
        <td><div align="right"><strong>ข้อความยืนยัน</strong></div></td>
        <td>&nbsp;</td>
        <td><label for="textconfirm"></label>
        <input type="text" name="textconfirm" id="textconfirm" /> <label>กรุณาพิมพ์ในช่องข้อความยืนยันว่า  <span class="color_red">fisheries</span></label></td>
      </tr>
      <tr>
        <td>&nbsp;
        <input name="hidUname" type="hidden" id="hidUname" value="<?php echo $_SESSION['MM_Username'] ?>" />
        <label for="txt_doby"></label></td>
        <td>&nbsp;</td>
        <td><div align="left">
          <input type="submit" name="button" id="button" value="จอง" /> 
          <input type="reset" name="button2" id="button2" value="เคลียร์ค่า" />
        </div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </div>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p align="center" style="color:#0000FF">&nbsp;</p>
<p align="center" style="color:#0000FF">&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Rs_list_room);
?>
