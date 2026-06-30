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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="checknew_user2.php";
  $loginUsername = $_POST['txtusername'];
  $LoginRS__query = sprintf("SELECT user_name FROM register WHERE user_name=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
  $LoginRS=mysql_query($LoginRS__query, $ReservBookRooms) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if($_POST['radio']=="อาจารย์"){
	$_POST['TxtFaculty'] = $_POST['TxtBranch'];
	$_POST['TxtSubBranch'] = "-";
}elseif($_POST['radio']=="นักศึกษา"){
	
}else{
	$_POST['TxtFaculty'] = $_POST['TxtOrganize'];
	$_POST['TxtSubBranch'] = "-";
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO register (user_name, user_pwd, user_fname, user_lname, user_address, user_phone, user_type, SubType_1, SubType_2) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtusername'], "text"),
                       GetSQLValueString($_POST['TxtPassword'], "text"),
                       GetSQLValueString($_POST['txtfname'], "text"),
                       GetSQLValueString($_POST['txtlname'], "text"),
                       GetSQLValueString($_POST['txtaddress'], "text"),
                       GetSQLValueString($_POST['txtphone'], "text"),
                       GetSQLValueString($_POST['radio'], "text"),
                       GetSQLValueString($_POST['TxtFaculty'], "text"),
                       GetSQLValueString($_POST['TxtSubBranch'], "text"));

  mysql_select_db($database_ReservBookRooms, $ReservBookRooms);
  $Result1 = mysql_query($insertSQL, $ReservBookRooms) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
function CompareSTR() {
		var Str1 = document.getElementById('TxtPassword').value;
		var Str2 = document.getElementById('TxtPasswordconfirm').value;
		if(Str1==Str2){
			return true;
		}else{
			return false;
		}
	}
	</script>
<title>สมัครใช้งานระบบ</title>
</head>

<body>
<form id="form1" name="form1" method="POST" action=<?php echo $editFormAction; ?>>
  <div align="center">
    <table width="641" border="1">
      <tr>
        <td colspan="3"><div align="center"><strong>สมัครใช้งานระบบ</strong></div></td>
      </tr>
      <tr>
        <td width="131"><div align="right"><strong>ชื่อผู้ใช้งานระบบ</strong></div></td>
        <td width="1">&nbsp;</td>
        <td width="487"><input name="txtusername" type="text" id="txtusername" /></td>
      </tr>
      <tr>
        <td><div align="right"><strong>รหัสผ่าน</strong></div></td>
        <td>&nbsp;</td>
        <td><label for="TxtPassword"></label>
        <input type="password" name="TxtPassword" id="TxtPassword" onkeyup="CompareSTR()"/>
        &nbsp;ยืนยันรหัสผ่าน
        <input type="password" name="TxtPasswordconfirm" id="TxtPasswordconfirm" onkeyup="CompareSTR()"/></td>
      </tr>
      <tr>
        <td><div align="right"><strong>ชื่อ</strong></div></td>
        <td>&nbsp;</td>
        <td><input name="txtfname" type="text" id="txtfname" /></td>
      </tr>
      <tr>
        <td><div align="right"><strong>นามสกุล</strong></div></td>
        <td>&nbsp;</td>
        <td><input name="txtlname" type="text" id="txtlname" /></td>
      </tr>
      <tr>
        <td><div align="right"><strong>ที่อยู่</strong></div></td>
        <td>&nbsp;</td>
        <td><input name="txtaddress" type="text" id="txtaddress" /></td>
      </tr>
      <tr>
        <td><div align="right"><strong>เบอร์โทรศัพท</strong>์</div></td>
        <td>&nbsp;</td>
        <td><input name="txtphone" type="text" id="txtphone" /></td>
      </tr>
      <tr>
        <td height="28"><div align="right"><strong>ประเภทผู้รับบริการ</strong></div></td>
        <td>&nbsp;</td>
        <td><input name="radio" type="radio" id="UserStatus" value="อาจารย์" checked="checked" />
            <label for="RadioTeacher">อาจารย์</label>
            &nbsp;  สาขา
            <input type="text" name="TxtBranch" id="TxtBranch" />
            <br />
          <input type="radio" name="radio" id="UserStatus" value="นักศึกษา" />
          <label for="RadioStudent">นักศึกษา</label> 
         &nbsp;คณะ
         <label for="TxtFaculty"></label>
         <input type="text" name="TxtFaculty" id="TxtFaculty" />
         สาขา
         <label for="TxtSubBranch"></label>
         <input type="text" name="TxtSubBranch" id="TxtSubBranch" />
         <br />
          <input type="radio" name="radio" id="UserStatus" value="หน่วยงาน" />
          <label for="RadioOther">หน่วยงาน</label>
          <label for="TxtOrganize"></label>
        <input type="text" name="TxtOrganize" id="TxtOrganize" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="left">
        <input type="submit" name="cmdsave" id="cmdsave" value="สมัครใช้งาน" />
        </div></td>
      </tr>
    </table>
  </div>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>