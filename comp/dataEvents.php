<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// เรียกใช้งานไฟล์เชื่อมต่อกับฐานข้อมูล
include './connect.php';

$json_data = array();

$q = "SELECT * FROM bookingRoom_2 LEFT JOIN user ON bookingRoom_2.U_id=user.U_id ORDER by id";


$result = $mysqli->query($q);

while ($rs = $result->fetch_object()) {
    if ($rs->B_status == 'accept') {
        $color = '#009C6B';
        //FF0000
    }
    if ($rs->B_status == 'Suspend') {
        $color = '#F2C80F';
        //FF0000
    }
    if ($rs->B_status == 'reject') {
        $color = '#DD3224';
    }
    if ($rs->B_status == '') {
        $color = '#DBDCFF';
    }
    $json_data[] = [
        'id' => $rs->id,
        'title' =>
        $rs->title . ', โดย:' . $rs->org,
        'start' => $rs->start,
        'end' => $rs->end,
        'url' => 'showEventsData.php?id=' . $rs->id,
        'color' => $color,
    ];
}
$json = json_encode($json_data);
echo $json;

//แสดงข้อมูลแบบง่ายๆ นะครับ ส่วนเรื่องความปลอดภัยของข้อมูล ต้องมีเงื่อนไขในการเข้าถึงข้อมูลด้วยนะครับ ถ้าไม่อยากให้ที่อื่นเรียใช้ข้อมูลได้ 