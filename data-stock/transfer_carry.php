<?php 
    require_once('../database/db.php');
 
?>
<link rel="icon" type="image/png" href="../components/images/tooth.png" />
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <title>Plus dental clinic</title>
 <!-- liberty ทำงานในคำสั่งตามที่คาดหัวไว้ -->
    <!-- <==========================================booystrap 5==================================================> -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- <========================================== jquery ==================================================> -->
    <script src="../node_modules/jquery/dist/jquery.js"></script>
    <!-- <==========================================data-teble==================================================> -->
    <script type="text/javascript" src="../node_modules/data-table/jquery-table-2.min.js"></script>
    <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <!-- <==========================================data-teble==================================================> -->
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <!-- <==========================================data-teble==================================================> -->
    <script>
        //function สำหรับการแสดงข้อมูล  liberty dataTables
    $(document).ready(function() {
        $('#stock').DataTable({
            dom: 'lBfrtip',
            buttons: [
                'excel', 'print'
            ],
            "searching": true,
            "lengthChange": false,
            "paging": false
        });
    });
    </script>
    <?php include('../components/header.php');?>
</head>

<body>
    <?php include('../components/nav_stock.php'); ?>

    <header></header>
    <div class="display-3 text-xl-center">
        <H2>รายการขนส่ง </H2>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col">
                <?php include('../components/nav_transfer_status.php'); ?>
            </div>
        </div>
    </div>
    </header>
    <?php include('../components/content.php')?>
    <div class="m-5">
        <br>
        <table class="table table-dark table-hover text-xl-center" id="stock">

            <thead class="table-dark">
                <tr class="table-active">
                    <th scope="col" class="text-center">รหัสรายการ</th>
                    <th scope="col" class="text-center">สาขาส่ง</th>
                    <th scope="col" class="text-center">สาขารับ</th>
                    <th scope="col" class="text-center">ผู้อนุมัติ</th>
                    <th scope="col" class="text-center">มูลค่า</th>
                    <th scope="col" class="text-center">รายการ</th>
                    <th scope="col" class="text-center">วันที่</th>
                    <th scope="col" class="text-center">หมายเหตุ</th>
                    <th scope="col" class="text-center">กดส่ง</th>

                </tr>
            </thead>
            <tbody>
                <?php 
                //กำหนดสิทธิ์ สำหรับการแสดงข้อมูล AM ขึ้นไป
                if($row_session['user_lv']>=3){
                    $select_transfer_stock = $db->prepare("SELECT bn_id_1,bn_id_2,transfer_stock.transfer_id,user2,transfer_stock.transfer_date,transfer_name,COUNT(transfer_log_id)as count_log,b1.bn_name as bn_name1 ,b2.bn_name as bn_name2,transfer_stock.transfer_stock_id,note2,transfer_status  FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id 
                    INNER JOIN transfer_stock_log ON transfer.transfer_name = transfer_stock_log.transfer_stock_id
                    INNER JOIN branch as b1 ON b1.bn_id  = transfer_stock.bn_id_1 
                    INNER JOIN branch as b2 ON b2.bn_id  = transfer_stock.bn_id_2 
                    WHERE transfer_status BETWEEN  2 AND 3  GROUP BY transfer_name");
                }else{
                    $select_transfer_stock = $db->prepare("SELECT bn_id_1,bn_id_2,transfer_stock.transfer_id,user2,transfer_stock.transfer_date,transfer_name,COUNT(transfer_log_id)as count_log,b1.bn_name as bn_name1 ,b2.bn_name as bn_name2,transfer_stock.transfer_stock_id,note2,transfer_status  FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id 
                    INNER JOIN transfer_stock_log ON transfer.transfer_name = transfer_stock_log.transfer_stock_id
                    INNER JOIN branch as b1 ON b1.bn_id  = transfer_stock.bn_id_1 
                    INNER JOIN branch as b2 ON b2.bn_id  = transfer_stock.bn_id_2 
                    WHERE transfer_status BETWEEN  2 AND 3 AND bn_id_1 = ".$row_session['user_bn']." GROUP BY transfer_name");
                }

$select_transfer_stock->execute();
$i =0;
while ($row_transfer = $select_transfer_stock->fetch(PDO::FETCH_ASSOC) ) {
extract($row_transfer);
$select_transfer_log = $db->prepare("SELECT SUM(transfer_qty*transfer_price) as sum ,transfer_stock_id FROM transfer_stock_log WHERE transfer_stock_id = '$transfer_name' GROUP BY transfer_stock_id");
$select_transfer_log->execute();
$sum_count = $row_transfer['count_log'];
$sum_new = 0;
$i++;
while ($row_transfer_log = $select_transfer_log->fetch(PDO::FETCH_ASSOC)) {
 

$sum_new = $sum_new+ $row_transfer_log['sum']; 

?>
                <tr class="table-light">
                    <td><?php echo $row_transfer['transfer_name'];?></td>
                    <td><?php echo $row_transfer['bn_name1'];?></td>
                    <td><?php echo $row_transfer['bn_name2'];?></td>
                    <td><?php echo $row_transfer['user2'];?></td>
                    <td><?php echo number_format($sum_new);  ?></td>
                    <td><input type="button" name="view" value="รายการ" class="btn btn-info view_data"
                            id="<?php echo $row_transfer['transfer_name']?>"></input></td>
                    <td><?php echo DateThai($row_transfer['transfer_date']);?></td>
                    <td><?php echo $row_transfer['note2'];?></td>
                    <?php if($row_transfer['transfer_status']==2){?>
                    <td><button type="submit" class="btn btn-success data_id_1" onclick="submitResult(event)"
                            id=<?php echo $row_transfer['transfer_stock_id'] ?>>ส่ง</button></td>
                    <?php }elseif($row_transfer['transfer_status']==3){?>
                    <td><button type="submit" class="btn btn-danger data_id_2" onclick="submitResult(event)"
                            id=<?php echo $row_transfer['transfer_stock_id'] ?>>ลบ</button></td>
                    <?php }?>

                </tr>
                <?php }?>
                <?php ?>
                <?php }?>
            </tbody>
            <tfoot>
                <tr class="table-active">
                    <th scope="col" class="text-center"></th>
                    <th scope="col" class="text-center"></th>
                    <th scope="col" class="text-center"></th>
                    <th scope="col" class="text-center"></th>
                    <th scope="col" class="text-center"></th>
                    <th scope="col" class="text-center"></th>
                    <th scope="col" class="text-center"></th>
                    <th scope="col" class="text-center"></th>
                    <th scope="col" class="text-center"></th>

                </tr>
            </tfoot>
        </table>
    </div>

</body>
<?php require 'viewmodal_transfer.php'?>
<script>
    //function เช็คสินค้ารายการที่มี
$(document).ready(function() {
    $('.view_data').click(function() {
        var uid = $(this).attr("id");
        $.ajax({
            url: "select_transfer.php",
            method: "POST",
            data: {
                uid
            },
            success: function(data) {
                $('#detail').html(data);
                $('#dataModal').modal('show');
            }
        });
    });
});
</script>
<script type="text/javascript">
function submitResult(e) {
    //function อนุมัติรายการผ่านการกดปุ่มอนุมัติ - ยอดเครดิต
    $('.data_id_1').click(function() {
        (async () => {
            const {
                value: formValues
            } = await Swal.fire({
                title: 'ข้อมูลขนส่งโอนย้าย',
                html: '<input type="text"id="text1" class="swal2-input"  placeholder="บริษัทขนส่ง/สาขา" >' +
                    '<input type="text" id="text2" class="swal2-input"  placeholder="รหัสติดตามสินค้า">' +
                    '<input type="number"id="text3" class="swal2-input"  placeholder="ค่าบริการขนส่ง">',
                showCancelButton: true,
                icon: 'question',
                focusConfirm: false,
                preConfirm: () => {
                    return [
                        document.getElementById('text1').value,
                        document.getElementById('text2').value,
                        document.getElementById('text3').value
                    ]
                }
            })
            if (formValues) {
                var text1 = formValues[0];
                var text2 = formValues[1];
                var text3 = formValues[2];
                var status = "set_carry";
                var uid = $(this).attr("id");
                $.ajax({
                    url: "transfer_db.php",
                    method: "POST",
                    data: {
                        uid: uid,
                        status: status,
                        text1: text1,
                        text2: text2,
                        text3: text3,
                    },
                    success: function(data) {
                        // alert(data);
                        if (data != false) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: data,
                                showConfirmButton: true,
                                timer: false
                            })
                            setTimeout(function(){
                            window.location.reload(1);
                            }, 2800);
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: "มีรายการไม่ถูกต้อง!!",
                                showConfirmButton: false,
                                timer: 2200
                            })
                        }
                    }
                });

            }
        })()
    });
    //function ลบรายการที่ไม่อนุมัติ
    $('.data_id_2').click(function() {
        e.preventDefault();
        Swal.fire({
            title: 'ลบรายการ?',
            text: "เคลียร์รายการเพื่อเพิ่มใหม่!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#BAB3B1',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                var uid = $(this).attr("id");
                var status ="del_row";
                $.ajax({
                    url: "transfer_db.php",
                    method: "POST",
                    data:{uid:uid,status:status},
                    success: function(data) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: data,
                            showConfirmButton: true,
                            timer: 2000
                            })
                            window.location.reload(2);
                        
                    }
                })
            }
        })
    });
}
</script>

</html>
<?php
//function แปลงวันที่เป็นวันที่ไทย
function DateThai($strDate)
{
$strYear = date("Y",strtotime($strDate))+543;
$strMonth= date("n",strtotime($strDate));
$strDay= date("j",strtotime($strDate));

$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$strMonthThai=$strMonthCut[$strMonth];
return "$strDay $strMonthThai $strYear";
}
?>