<?php
include './connect.php'; // เรียกใช้งานไฟล์เชื่อมต่อกับฐานข้อมูล
include './thai_date.php';
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
</head>

<body>

    <?php

    $sql = "SELECT * FROM bookingRoom_2 INNER JOIN user ON bookingRoom_2.U_id=user.U_id WHERE id ='" . $_GET['id'] . "'  ";
    $result = $mysqli->query($sql);
    $rs = $result->fetch_object();

    $sql2 = "SELECT * FROM bookingRoom_2 LEFT JOIN user ON bookingRoom_2.admin_update=user.U_id WHERE id ='" . $_GET['id'] . "'  ";
    $result2 = $mysqli->query($sql);
    $rs2 = $result2->fetch_object();

    if ($rs->B_status == 'accept') {
        $status1 =
            "<button class='btn btn-success btn-lg'style='font-weight: bold;'>" .
            "<i class='fa fa-check pr-2'></i> อนุมัติแล้ว </button><p>Update: $rs->date_update</p>";
        $alt = "success";
    } elseif ($rs->B_status == 'reject') {
        $status1 =
            "<button class='btn btn-danger btn-lg'style='font-weight: bold;'>" .
            "<i class='fa fa-remove pr-2'></i> ยกเลิก</button><p>Remark: $rs->remark Update: $rs->date_update by: $rs2->fname $rs2->lname</p>";
        $alt = "danger";
    } elseif ($rs->B_status == 'Suspend') {
        $status1 =
            "<div class='btn btn-warning btn-lg'style='font-weight: bold;'>" .
            "<i class='fa fa-remove pr-2'></i> รออนุมัติ</div>";
        $alt = "warning";
    } else {
        $status1 =
            "<button class='btn btn-primary btn-lg'style='font-weight: bold;'>" .
            "<i class='fa fa-refresh pr-2'></i>  อนุมัติ / รอใช้</button>";
    }
    ?>
    <div id="wrapper">

        <div class="row">

            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-weight: bold;">
                        รายละเอียดการขอใช้งานห้องฝึกอบรมคอมพิวเตอร์
                    </div>
                    <div class="panel-body">
                        <button class="btn btn-default btn-sm" style="font-weight: bold;"> ชื่อเรื่องการประชุม </button>
                        <div class="alert alert-<?php echo $alt; ?>">
                            <?php echo $rs->title; ?>
                        </div>
                        <button class="btn btn-default btn-sm" style="font-weight: bold;"> วัน-เวลาใช้ห้อง </button>
                        <div class="alert alert-<?php echo $alt; ?>">
                            เริ่ม <?php echo DateThai(
                                        $rs->start
                                    ); ?> ถึง <?php echo DateThai($rs->end); ?>
                        </div>
                        <button class="btn btn-default btn-sm " style="font-weight: bold;"> จำนวนผู้ใช้ห้อง </button>
                        <div class="alert alert-<?php echo $alt; ?>">
                            <?php echo $rs->persion . " คน"; ?>
                        </div>
                        <button class="btn btn-default btn-sm " style="font-weight: bold;"> หน่วยงานที่จอง </button>
                        <div class="alert alert-<?php echo $alt; ?>">
                            <?php echo $rs->org; ?>
                        </div>
                        <button class="btn btn-default btn-sm " style="font-weight: bold;"> ผู้จอง </button>
                        <div class="alert alert-<?php echo $alt; ?>">
                            <?php echo $rs->fname;
                            echo " " . $rs->lname;
                            echo "<br>โทร." . $rs->tel; ?>
                        </div><a href="booking_update.php?ref=<?php echo urlencode($rs->id); ?>" 
   class="btn btn-outline-secondary btn-sm" 
   style="font-weight: bold; padding: 0.375rem 0.75rem; border-radius: 0.25rem; display: inline-block; text-align: center; cursor: pointer;" 
   target="_blank" 
   rel="noopener noreferrer">
  สถานะ
  <?php echo $status1; ?>
</a>


                    </div><!-- .panel-body -->

                </div> <!-- panel panel-default -->
            </div> <!-- col-lg-8 -->


        </div><!-- row -->
    </div>
</body>

</html>