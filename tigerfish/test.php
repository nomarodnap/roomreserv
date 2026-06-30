<?php
require './con.php';
echo $_POST['treasure'];
if ($_POST['treasure']=='goo!') {
    $sql = "SELECT * FROM bookingRoom INNER JOIN user ON bookingRoom.U_id=user.U_id ORDER BY id DESC";
    $objQuery = mysqli_query($mysqli, $sql);
    ?>
    <table class="table datatable">
                <thead>
                    <tr>
                        <th>หัวข้ออบรม</th>
                        <th>วันเวลาเริ่มต้น </th>
                        <th>วันเวลาสิ้นสุด</th>
                        <?php
                        if ($user['status'] == 'admin') {
                            echo '<th>หน่วยงาน</th>
                        <th>ผู้จอง</th>
                        <th>เบอร์ติดต่อ</th>';
                        }
                        ?>
                        <th>สถานะจอง</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    function DateThai2($dates)
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
                    while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                    ?>
                        <tr>
                            <td><?php echo $objResult['title']; ?></td>
                            <td><?php echo DateThai2($objResult['start']) . ' ' . 'น.'; ?></td>
                            <td><?php echo DateThai2($objResult['end']) . ' ' . 'น.'; ?></td>
                            <?php
                            if ($user['status'] == 'admin') { ?>
                                <td><?php echo $objResult['org']; ?></td>
                                <td><?php echo $objResult['fname'], ' ', $objResult['lname']; ?></td>
                                <td><?php echo $objResult['tel']; ?></td>
                            <?php }
                            ?>
                            <td><?php if ($objResult['B_status'] == "accept") {
                                    echo '<span class="badge bg-success">อนุมัติแล้ว</span>';
                                } elseif ($objResult['B_status'] == "Suspend") {
                                    echo ' <span class="badge bg-warning text-dark">รออนุมัติ</span>';
                                } else echo '<span class="badge bg-danger">ยกเลิก</span>';
                                ?></td>
                            <td>
                                <a href="booking_update.php?id=<?php echo $objResult['id']; ?>" class="btn btn-outline-info btn-sm">Update</a>

        </div>
        </div>
        </div>
        </div>
        </td>
        </tr>
    <?php } ?>
    </tbody>
    </table>
<?php }?>
<form method="post">
    <input type="submit" name="treasure" value="go!">
</form>