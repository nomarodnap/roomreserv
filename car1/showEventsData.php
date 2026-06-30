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

    $sql = "SELECT * FROM car1 INNER JOIN user ON car1.U_id=user.U_id WHERE id ='" . $_GET['id'] . "'  ";
    $result = $mysqli->query($sql);
    $rs = $result->fetch_object();

    $sql2 = "SELECT * FROM car1 LEFT JOIN user ON car1.admin_update=user.U_id WHERE id ='" . $_GET['id'] . "'  ";
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
                        รายละเอียดการขอใช้รถ
                    </div>
                    <div class="panel-body">
                        <button class="btn btn-default btn-sm" style="font-weight: bold;"> ขออนุญาติใช้รถไป </button>
                        <div class="alert alert-<?php echo $alt; ?>">
                            <?php echo $rs->title; ?>
                        </div>
						
							<button class="btn btn-default btn-sm " style="font-weight: bold;"> เพื่อ </button>
<div class="alert alert-<?php echo $alt; ?>">
    <?php echo nl2br(htmlspecialchars($rs->purpose)); ?>
</div>
                        <button class="btn btn-default btn-sm" style="font-weight: bold;"> วัน-เวลาออกเดินทางและกลับเดินทาง </button>
                        <div class="alert alert-<?php echo $alt; ?>">
                            ออกเดินทาง <?php echo DateThai(
                                        $rs->start
                                    ); ?> กลับเดินทาง <?php echo DateThai($rs->end); ?>
                        </div>
                        <button class="btn btn-default btn-sm " style="font-weight: bold;"> จำนวนผู้โดยสาร </button>
                        <div class="alert alert-<?php echo $alt; ?>">
                            <?php echo $rs->persion . " คน"; ?>
                        </div>
						
<?php if ($rs->B_status == 'accept'): ?>
    <button class="btn btn-default btn-sm " style="font-weight: bold;"> พนักงานขับรถ </button>
    <div class="alert alert-<?php echo $alt; ?>">
        <?php
        echo $rs->driver ? htmlspecialchars($rs->driver) : 'ยังไม่ระบุ';

        // ถ้ามีชื่อคนขับ → คำนวณคะแนนเฉลี่ย
        if ($rs->driver) {
            $driverName = $mysqli->real_escape_string($rs->driver);
            $sql_avg = "SELECT AVG(rating) as avg_rating FROM driver_rating WHERE driver_name = '$driverName'";
            $res_avg = $mysqli->query($sql_avg);
            $avg_rating = 0;

            if ($res_avg && $row = $res_avg->fetch_assoc()) {
                $avg_rating = round($row['avg_rating'] * 2) / 2; // ปัดเป็น 0.5
            }

            // ฟังก์ชันแสดงดาวตามคะแนน
            function renderStars($avg) {
                $html = '<span style="margin-left:10px; color: gold; font-size: 18px;">';
                for ($i = 1; $i <= 5; $i++) {
                    if ($avg >= $i) {
                        $html .= '★'; // เต็ม
                    } elseif ($avg >= ($i - 0.5)) {
                        $html .= '☆'; // ครึ่ง
                    } else {
                        $html .= '✩'; // ว่าง
                    }
                }
                $html .= '</span>';
                return $html;
            }

            echo renderStars($avg_rating);
        }
        ?>
    </div>

    <?php if (isset($_SESSION['user_login']) && $_SESSION['user_login']['U_id'] == $rs->U_id): ?>
        <?php
        // เช็กว่าเคยให้คะแนนคนขับแล้วหรือยัง
        $uid = $_SESSION['user_login']['U_id'];
        $booking_id = $rs->id;
        $sql_rating = "SELECT * FROM driver_rating WHERE booking_id = '$booking_id' AND user_id = '$uid' LIMIT 1";
        $res_rating = $mysqli->query($sql_rating);
        $hasRated = $res_rating && $res_rating->num_rows > 0;
        ?>

<?php if (!$hasRated): ?>
    <?php
    // ตรวจสอบเวลาปัจจุบันกับเวลาสิ้นสุดการเดินทาง
    $now = new DateTime();
    $endTime = new DateTime($rs->end);
    ?>

    <?php if ($now >= $endTime): ?>
        <!-- ให้คะแนนได้ -->
        <button class="btn btn-default btn-sm " style="font-weight: bold;">ให้คะแนนคนขับ</button>
        <div class="alert alert-<?php echo $alt; ?>">
            <form method="post" action="rate_driver.php" style="margin-bottom: 0;">
                <input type="hidden" name="booking_id" value="<?php echo $rs->id; ?>">
                <input type="hidden" name="driver" value="<?php echo htmlspecialchars($rs->driver); ?>">

                <div class="star-rating">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" required />
                        <label for="star<?php echo $i; ?>">★</label>
                    <?php endfor; ?>
                </div>
                </br>
                <button type="submit" class="btn btn-success btn-sm mt-2">ส่งคะแนน</button>
            </form>
        </div>
    <?php else: ?>
        <!-- ยังให้คะแนนไม่ได้ -->
        <div class="alert alert-warning">
            <i class="fa fa-clock-o text-warning"></i> หลังจากที่เดินทางกลับเรียบร้อยแล้วระบบจะเปิดให้คะแนนคนขับ
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="alert alert-info">
        <i class="fa fa-star text-warning"></i> คุณได้ให้คะแนนคนขับเรียบร้อยแล้ว
    </div>
<?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
						
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
	
	
	            <style>
                .star-rating {
                    direction: rtl;
                    font-size: 30px;
                    display: inline-flex;
                }

                .star-rating input[type="radio"] {
                    display: none;
                }

                .star-rating label {
                    color: lightgray;
                    cursor: pointer;
                    transition: color 0.2s;
                }

                .star-rating input[type="radio"]:checked ~ label,
                .star-rating label:hover,
                .star-rating label:hover ~ label {
                    color: gold;
                }
            </style>
</body>

</html>