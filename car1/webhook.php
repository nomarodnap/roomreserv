<?php

// รับข้อมูลจาก Webhook ที่ LINE ส่งมา
$input = file_get_contents('php://input');
$events = json_decode($input, true);

// บันทึกข้อมูล Log เพื่อตรวจสอบปัญหา
file_put_contents('webhook_log.txt', $input . PHP_EOL, FILE_APPEND);

// ตรวจสอบว่า LINE ส่ง event มาหรือไม่
if (!is_null($events['events'])) {
    foreach ($events['events'] as $event) {
        
        // รับ userId จาก LINE
        $user_id = $event['source']['userId'];

        // กรณีที่เป็น event follow (มีคนเพิ่มเพื่อน)
        if ($event['type'] === 'follow') {
            save_user_id($user_id);
        }
    }
}

// ส่ง HTTP Status 200 ให้ LINE
http_response_code(200);
exit; // หยุดโปรแกรมเพื่อไม่ให้มีข้อผิดพลาดอื่น ๆ

/**
 * บันทึก user_id ลงไฟล์
 */
function save_user_id($user_id) {
    $file_path = 'user_ids.txt';
    
    // ตรวจสอบว่ามี user_id อยู่ในไฟล์หรือยัง
    $user_ids = file_exists($file_path) ? file($file_path, FILE_IGNORE_NEW_LINES) : [];
    if (!in_array($user_id, $user_ids)) {
        file_put_contents($file_path, $user_id . PHP_EOL, FILE_APPEND);
    }
}
?>