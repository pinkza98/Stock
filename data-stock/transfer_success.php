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
        });
    });
    </script>
    <?php include('../components/header.php');?>
</head>

<body>
    <?php include('../components/nav_stock.php'); ?>

    <header></header>
    <div class="display-3 text-xl-center">
        <H2>รายการสินค้าคลังที่โอนย้ายสำเร็จ </H2>
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
                    <th scope="col" class="text-center">รหัสติดตาม</th>
                    <th scope="col" class="text-center">สาขาส่ง</th>
                    <th scope="col" class="text-center">สาขารับ</th>
                    <th scope="col" class="text-center">ผู้ส่งคำขอ</th>
                    <th scope="col" class="text-center">มูลค่า</th>
                    <th scope="col" class="text-center">รายการ</th>
                    <th scope="col" class="text-center">วันที่</th>
                    <th scope="col" class="text-center">หมายเหตุ</th>
                    <th scope="col" class="text-center">กดส่ง</th>

                </tr>
            </thead>
            <tbody>
                <?php 
$select_transfer_stock = $db->prepare("SELECT bn_id_1,bn_id_2,transfer_stock.transfer_id,user1,transfer_stock.transfer_date,transfer_name,COUNT(transfer_log_id)as count_log,b1.bn_name as bn_name1 ,b2.bn_name as bn_name2,transfer_stock.transfer_stock_id,note2,transfer_status  FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id 
INNER JOIN transfer_stock_log ON transfer.transfer_name = transfer_stock_log.transfer_stock_id
INNER JOIN branch as b1 ON b1.bn_id  = transfer_stock.bn_id_1 
INNER JOIN branch as b2 ON b2.bn_id  = transfer_stock.bn_id_2 
WHERE transfer_status BETWEEN  5 AND 6
GROUP BY transfer_name
");
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
                    <td><?php echo $row_transfer['user1'];?></td>
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
    $('.data_id_1').click(function() {
        (async () => {
            const {
                value: formValues
            } = await Swal.fire({
                title: 'ข้อมูลขนส่งโอนย้าย',
                html: '<input type="text"id="text1" class="swal2-input"  placeholder="บริษัทขนส่ง" required>' +
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
                var uid=$(this).attr("id");
                $.ajax({
                    url: "transfer_db.php",
                    method: "POST",
                    data: {
                        uid: uid,
                        status: status,
                        text1:text1,
                        text2:text2,
                        text3:text3,
                    },
                    success: function(data) {
                        // alert(data);
                                    if(data != false){
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
                        }else{
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
    $('.data_id_2').click(function() {
        e.preventDefault();
        Swal.fire({
            title: "หมายเหตุ!",
            text: "ลบรายการนี้ เพื่อดำเนินรายการโอนย้ายใหม่",
            icon: 'warning',
            input: 'text',
            showCancelButton: true
        }).then((result) => {
            if (result.value) {
                text1 = result.value;
                var uid = $(this).attr("id");
                var status = "del_row";
                $.ajax({
                    url: "transfer_db.php",
                    method: "POST",
                    data: {
                        uid: uid,
                        text1: text1,
                        status: status
                    },
                    success: function(data) {
                        alert(data);
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    }
                });
            }
        });
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