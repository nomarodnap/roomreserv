<?php

// Line Channel Access Token
$access_token = '7owMururPBylaONgrTjSyKt+hrYFgjY4sRU4dbyGaOrOpUDQmYdSdp5PmGn45CTE7NuOmkr+1gE3GLL6yM9Hr7EbIINP+AWEUVWqM54EB/NfjXM1nNGP/W+FYRGp5kB2KiriYn9f4hGxtVYq3oBYzwdB04t89/1O/w1cDnyilFU='; // 🔥 ใส่ Access Token ของคุณที่นี่

// รายละเอียดข้อความที่ต้องการส่ง
$str = "\r\n" . '📢 มีการจองห้องอบรมใหม่' .
"\r\n" . ' 📘 เรื่อง :  ' . $titel2 .
"\r\n" . ' 📅 วันที่จอง : ' . $start2 . ' ถึง ' . $end2 .
"\r\n" . ' 🏢 หน่วยงาน : ' . $org2 .
"\r\n" . ' 👤 ผู้จอง : ' . $user2 .
"\r\n" . ' 📞 โทร : ' . $tel2 .
"\r\n" . ' 🔗 ตรวจสอบข้อมูล :https://roomreserv.fisheries.go.th/newweb/newbooking.php?ref=' . $id2;

        $message = array(
            'message' => $str,
            'imageThumbnail' => $image_thumbnail_url,
            'imageFullsize' => $image_fullsize_url,
            'stickerPackageId' => $sticker_package_id,
            'stickerId' => $sticker_id
        );

// อ่านรายชื่อ user_id ที่อยู่ในไฟล์ user_ids.txt
$user_ids = file_exists('user_ids.txt') ? file('user_ids.txt', FILE_IGNORE_NEW_LINES) : [];

// วนลูปเพื่อส่งข้อความถึงทุกคนที่เคยเพิ่มเพื่อน
foreach ($user_ids as $user_id) {
    send_message($user_id, $message);
}

/**
 * ฟังก์ชันส่งข้อความไปยังผู้ใช้
 */
function send_message($user_id, $message)
{
    global $access_token;

    $message_data = array(
        'to' => $user_id, 
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $message
            )
        )
    );

    $url = 'https://api.line.me/v2/bot/message/push';
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $access_token
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
?>
