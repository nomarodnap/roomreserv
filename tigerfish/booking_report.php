<?php
session_start();
$pagename = 'รายงานการจองห้อง';
include_once('./function.php');
$objCon = connectDB();
$strSQL = "SELECT * FROM bookingRoom INNER JOIN user ON bookingRoom.U_id=user.U_id ORDER BY id DESC";
$objQuery = mysqli_query($objCon, $strSQL);
$total_record = mysqli_num_rows($objQuery);
$user = $_SESSION['user_login'];
if ($user['status'] != 'admin_1') {
    echo '<script>alert("สำหรับผู้ดูแลระบบเท่านั้น");window.location="index.php";</script>';
    exit;
}

require './header2.php';
?>

<head>
    <title><?php echo $pagename . ' | ' . $webname; ?></title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="./assets/lib/jquery/dist/jquery.min.js"></script>
</head>
<style type="text/css">
    @media screen {
        p.bodyText {
            font-family: 'Anuphan', sans-serif;
        }
    }

    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }
    }
</style>

<body>

    <main id="" class="">

        <section class="section dashboard">
            <div class="row">
                <div class="text-center fw-bold"><?php echo $pagename; ?></div>
                <div class="text-center fw-bold">การลงทะเบียนเข้าใช้งานห้องประชุมเสือตอ</div>
                <div class="mb-3 mt-4">จำนวนการจองทั้งหมด <?php echo $total_record; ?> รายการ รายละเอียดดังนี้</div>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="text-align:center;">ลำดับ</th>
                            <th>วัตถุประสงค์ใช้งาน</th>
                            <th>วันเวลาเริ่มต้น</th>
                            <th>วันเวลาสิ้นสุด</th>
                            <th>ผู้จอง</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                            $i++;
                        ?>
                            <tr>
                                <td style="text-align:center;"><?php echo $i; ?></td>
                                <td><?php echo $objResult['title']; ?></td>
                                <td><?php echo DateThai($objResult['start']) . ' ' . 'น.'; ?></td>
                                <td><?php echo DateThai($objResult['end']) . ' ' . 'น.'; ?></td>
                                <td><?php echo 'หน่วยงาน: '.$objResult['org'].'<br>'.$objResult['fname'], ' ', $objResult['lname'],' โทร.',$objResult['tel']; ?></td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>

                <!-- ปุ่มพิมพ์ -->
                <div class="mt-4 text-center no-print">
                    <button type="button" class="btn btn-primary" onclick="return print();">พิมพ์</button>
                    <a href="./booking_list.php" class="btn btn-warning">กลับ</a>
                </div>
            </div>
        </section>
    </main>
    <?php require './footer.php'; ?>
</body>

</html>