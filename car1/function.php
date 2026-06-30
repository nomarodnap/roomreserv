<?php
$webname = 'ระบบจองห้องอบรม ศทส.';
function connectDB()
{
    $serverName = "localhost";
    $userName = "roomreserv";
    $userPassword = "rrsev?864db";
    $dbName = "roomreserv_db";

    $objCon = mysqli_connect($serverName, $userName, $userPassword, $dbName);
    mysqli_set_charset($objCon, "utf8");
    return $objCon;
}

function date_th($date)
{
    if ($date == '0000-00-00')
        return '-';

    $date_array = explode('-', $date);
    $th_date = $date_array[2] .
        '/' . $date_array[1] . '/' .
        ($date_array[0] + 543);

    return $th_date;
}

function date_en($date)
{
    $date_array = explode('/', $date);
    $en_date = ($date_array[2] - 543) . '-' .
        $date_array[1] . '-' . $date_array[0];
    return $en_date;
}

function randomString($length = 5)
{
    $str = "";
    $characters = array_merge(range('0', '9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}
function DateThai($dates)
{
    $strYear = date("Y", strtotime($dates)) + 543;
    $strMonth = date("n", strtotime($dates));
    $strDay = date("j", strtotime($dates));
    $strHour = date("H", strtotime($dates));
    $strMinute = date("i", strtotime($dates));
    $strSeconds = date("s", strtotime($dates));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}
