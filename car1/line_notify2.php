<html>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
</html>
<?php
        $line_api = 'https://notify-api.line.me/api/notify';
        $access_token = 'd8tSwba30L66cI3YthU8GUR3r1oiZSkXQCbZmLVzJ65';
        $str = 	"\r\n" . '📢 มีการจองห้องอบรมใหม่' .
    "\r\n" . '📘 เรื่อง : ' . $titel2 .
    "\r\n" . '📅 วันที่จอง : ' . $start2 . ' ถึง ' . $end2 .
    "\r\n" . '🏢 หน่วยงาน : ' . $$org2 .
    "\r\n" . '👤 ผู้จอง : ' . $user2 .
    "\r\n" . '📞 โทร : ' . $tel2 .
    "\r\n" . '🔗 ตรวจสอบข้อมูล : https://roomreserv.fisheries.go.th/newweb/comp/newbooking.php?ref=' . $id2;



        $message_data = array(
            'message' => $str,
            'imageThumbnail' => $image_thumbnail_url,
            'imageFullsize' => $image_fullsize_url,
            'stickerPackageId' => $sticker_package_id,
            'stickerId' => $sticker_id
        );

        $result = send_notify_message($line_api, $access_token, $message_data);
        print_r($result);

        function send_notify_message($line_api, $access_token, $message_data)
        {
            $headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer ' . $access_token);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $line_api);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $message_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            // Check Error
            if (curl_error($ch)) {
                $return_array = array('status' => '000: send fail', 'message' => curl_error($ch));
            } else {
                //$return_array = json_decode($result, true);
            }
            curl_close($ch);
            return $return_array;
        }

