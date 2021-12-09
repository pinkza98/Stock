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

    <!-- <==========================================booystrap 5==================================================> -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- <========================================== jquery ==================================================> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/cesiumjs/1.78/Build/Cesium/Cesium.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script> -->
    <!-- <========================================== jquery ==================================================> -->
    <script src="../node_modules/jquery/dist/jquery.js"></script>
    <!-- <==========================================data-teble==================================================> -->
    <script type="text/javascript" src="../node_modules/data-table/jquery-table-2.min.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">     -->
    <!-- <link rel="stylesheet" href="../node_modules/data-table/dataTables.bootstrap.min.css" />  -->
    <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <!-- <==========================================data-teble==================================================> -->
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <!-- <==========================================data-teble==================================================> -->
    <script>
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
        <H2>รายการตรวจรับสินค้า </H2>
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
                    <th scope="col" class="text-center">มูลค่า</th>
                    <th scope="col" class="text-center">รายการ</th>
                    <th scope="col" class="text-center">ปรับยอดรายการ</th>
                    <th scope="col" class="text-center">บริษัทขนส่ง</th>
                    <th scope="col" class="text-center">รหัสติดตามพัสดุ</th>
                    <th scope="col" class="text-center">ขั้นตอน</th>
                    <th scope="col" class="text-center">กดส่ง</th>

                </tr>
            </thead>
            <tbody>
                <?php 
                if($row_session['user_lv'] >= 3){
                    $select_transfer_stock = $db->prepare("SELECT bn_id_1,bn_id_2,transfer_stock.transfer_id,user1,transfer_stock.transfer_date,transfer_name,COUNT(transfer_log_id)as count_log,b1.bn_name as bn_name1 ,b2.bn_name as bn_name2,transfer_stock.transfer_stock_id,note2,transfer_status,code_service,transfer_service  FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id 
                    INNER JOIN transfer_stock_log ON transfer.transfer_name = transfer_stock_log.transfer_stock_id
                    INNER JOIN branch as b1 ON b1.bn_id  = transfer_stock.bn_id_1 
                    INNER JOIN branch as b2 ON b2.bn_id  = transfer_stock.bn_id_2 
                    WHERE transfer_status BETWEEN 1 AND 4
                    GROUP BY transfer_name
                    ");
                }else{
                    $select_transfer_stock = $db->prepare("SELECT bn_id_1,bn_id_2,transfer_stock.transfer_id,user1,transfer_stock.transfer_date,transfer_name,COUNT(transfer_log_id)as count_log,b1.bn_name as bn_name1 ,b2.bn_name as bn_name2,transfer_stock.transfer_stock_id,note2,transfer_status,code_service,transfer_service  FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id 
                    INNER JOIN transfer_stock_log ON transfer.transfer_name = transfer_stock_log.transfer_stock_id
                    INNER JOIN branch as b1 ON b1.bn_id  = transfer_stock.bn_id_1 
                    INNER JOIN branch as b2 ON b2.bn_id  = transfer_stock.bn_id_2 
                    WHERE transfer_status BETWEEN 1 AND 4 AND bn_id_2 = ".$row_session['user_bn']."
                    GROUP BY transfer_name
                    ");
                }

//  AND bn_id_2 = ".$row_session['user_bn']."
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
<form action="">
                <tr class="table-light">
                    <td><?php echo $row_transfer['transfer_name'];?></td>
                    <td><?php echo $row_transfer['bn_name1'];?></td>
                    <td><?php echo $row_transfer['bn_name2'];?></td>
                    <td><?php  echo number_format($sum_new); ?></td>
                    <td><input type="button" name="view" value="รายการ" class="btn btn-info view_data"id="<?php echo $row_transfer['transfer_name']?>"></input></td>
                    <?php if($row_transfer['transfer_status']==4){?>
                    <td><a href="edit/transfer_reconcile.php?update_id=<?php echo $row_transfer['transfer_name']?>" class="btn btn-warning">ปรับยอด</a></td>
                    <?php }else{?>
                    <td><a href="#" class="btn btn-secondary">ปรับยอด</a></td>
                    <?php } ?>
                    <td><?php echo $row_transfer['transfer_service'];?></td>
                    <td><?php echo $row_transfer['code_service'];?></td>
                    <?php if($row_transfer['transfer_status'] == 1){?>
                        <td>รออนุมัติรายการ</td>
                        <td><button type="submit" class="btn btn-primary ">กำลังดำเนินการ</button></td>
                        <?php }elseif($row_transfer['transfer_status'] == 2){?>
                        <td>รอแพ๊คของส่ง/อนุมัติแล้ว</td>
                        <td><button type="submit" class="btn btn-primary ">กำลังดำเนินการ</button></td>
                        <?php }elseif($row_transfer['transfer_status'] == 3){?>
                        <td>รายการถูกยกเลิกแล้ว</td>
                        <td><button type="submit" class="btn btn-danger ">ไม่อนุมัติรายการ</button></td>
                        <?php }elseif($row_transfer['transfer_status'] == 4){?>
                        <td>กำลังส่ง/รอตรวจรับ</td>
                        <td><button type="submit" class="btn btn-success data_id" onclick="submitResult(event)"id=<?php echo $row_transfer['transfer_stock_id'] ?>>รับสินค้า</button></td>
                        <?php } ?>    
                </tr>
</form>
                <?php }?>
                <?php ?>
                <?php }?>
            </tbody>
            <tfoot>
                <tr class="table-active">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    

                </tr>
            </tfoot>
        </table>
    </div>

</body>

<?php require 'view/viewmodal_transfer_edit.php'?>
<?php $user_name = $row_session['user_fname'].$row_session['user_lname'];?>
<script>
$(document).ready(function() {
    $('.view_data').click(function() {
        var uid = $(this).attr("id");
        $.ajax({
            url: "select_stock/select_transfer_edit.php",
            method: "POST",
            data: {
                uid
            },
            success: function(data) {
                $('#detail_edit').html(data);
                $('#dataModal_edit').modal('show');
            }
        });
    });
});
</script>
<script type="text/javascript">
function submitResult(e) {
    $('.data_id').click(function() {
        e.preventDefault();
        Swal.fire({
            title: 'รับสินค้า?',
            text: "เพิ่มสินค้าเข้าคลัง: #กรุณาตรวจเช็ค ปรับยอดก่อนทุกครั้งที่ กดปุ่มนี้!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#BAB3B1',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                var uid = $(this).attr("id");
                var status ="add_stock";
                var name = "<?php echo $user_name?>";
                $.ajax({
                    url: "transfer_db.php",
                    method: "POST",
                    data:{uid:uid,status:status,name:name},
                    success: function(data) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: data,
                            showConfirmButton: true,
                            timer: false
                            })
                            setTimeout(function(){
                            window.location.reload(1);
                            }, 2200);
                        
                    }
                })
            }
        })
    });
}
</script>

</html>
<?php
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