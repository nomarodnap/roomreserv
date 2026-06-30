<html>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
</html>
<?php
        //แจ้งเตือนผ่านไลน์

        session_start();
        $token = "BNbN4SwTHh0p3j9l3sRnvjaYEYoUkF2ovnPSHpF3KIH"; //ใส่Token ที่copy เอาไว้

        $message = "\r\n" . 'มีการจองห้องอบรมใหม่' .
            "\r\n" . ' เรื่อง : ' . $titel2 .
            "\r\n" . ' วันที่จอง : ' . $start2 . ' ถึง ' . $end2 .
            "\r\n" . ' หน่วยงาน : ' . $org2 .
            "\r\n" . ' ผู้จอง : ' . $user2 .
            "\r\n" . ' โทร. : ' . $user2 .
            "\r\n" . ' ตรวจสอบข้อมูล :https://roomreserv.fisheries.go.th/newweb/newbooking.php?id=' . $id2;

        sendlinemesg();
        header('Content-Type: text/html; charset=utf8');
        $res = notify_message($message);
        function sendlinemesg()
        {
            define('LINE_API', "https://notify-api.line.me/api/notify");
            define('LINE_TOKEN', "BNbN4SwTHh0p3j9l3sRnvjaYEYoUkF2ovnPSHpF3KIH"); //เปลี่ยนใส่ Token ของเราที่นี่ 

            function notify_message($message)
            {
                $queryData = array('message' => $message);
                $queryData = http_build_query($queryData, '', '&');
                $headerOptions = array(
                    'http' => array(
                        'method' => 'POST',
                        'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                            . "Authorization: Bearer " . LINE_TOKEN . "\r\n"
                            . "Content-Length: " . strlen($queryData) . "\r\n",
                        'content' => $queryData
                    )
                );
                $context = stream_context_create($headerOptions);
                $result = file_get_contents(LINE_API, FALSE, $context);
                $res = json_decode($result);
                return $res;
            }
        }
