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
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">     -->
   <!-- <link rel="stylesheet" href="../node_modules/data-table/dataTables.bootstrap.min.css" />  -->
  <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<!-- <==========================================data-teble==================================================> -->
<script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <!-- <==========================================sweetalert2==================================================> -->
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
    <style>
        .btn-info {
            color: #FFF;
        }
        .btn-warning {
            color: #FFF; 
        }
    </style>
</head>

<body>
    <?php include('../components/nav_stock.php'); ?>

    <header></header>
    <div class="display-3 text-xl-center">
        <H2>รายการรออนุมัติ </H2>
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
                    <th scope="col" class="text-center">ผู้ส่งคำขอ</th>
                    <th scope="col" class="text-center">มูลค่า</th>
                    <th scope="col" class="text-center">รายการ</th>
                    <?php 
                    if($row_session['user_lv']>=3){
                    ?>
                    <th scope="col" class="text-center">ปรับยอด</th>
                    <?php } ?>
                    <th scope="col" class="text-center">วันที่</th>
                    <th scope="col" class="text-center">อนุมัติ</th>
                    <th scope="col" class="text-center">ไม่อนุมัติ</th>
                </tr>
            </thead>
            <tbody>
    <?php 
    if($row_session['user_lv'] >= 3){
        $select_transfer_stock = $db->prepare("SELECT bn_id_1,bn_id_2,transfer_stock.transfer_id,user1,transfer_stock.transfer_date,transfer_name,COUNT(transfer_log_id)as count_log,b1.bn_name as bn_name1 ,b2.bn_name as bn_name2,transfer_stock.transfer_stock_id  FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id 
        LEFT JOIN transfer_stock_log ON transfer.transfer_name = transfer_stock_log.transfer_stock_id
        INNER JOIN branch as b1 ON b1.bn_id  = transfer_stock.bn_id_1 
        INNER JOIN branch as b2 ON b2.bn_id  = transfer_stock.bn_id_2 
        WHERE transfer_status = 1 
         GROUP BY transfer_name
        ");
    }else{
        $select_transfer_stock = $db->prepare("SELECT bn_id_1,bn_id_2,transfer_stock.transfer_id,user1,transfer_stock.transfer_date,transfer_name,COUNT(transfer_log_id)as count_log,b1.bn_name as bn_name1 ,b2.bn_name as bn_name2,transfer_stock.transfer_stock_id  FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id 
        LEFT JOIN transfer_stock_log ON transfer.transfer_name = transfer_stock_log.transfer_stock_id
        INNER JOIN branch as b1 ON b1.bn_id  = transfer_stock.bn_id_1 
        INNER JOIN branch as b2 ON b2.bn_id  = transfer_stock.bn_id_2 
        WHERE transfer_status = 1 AND bn_id_1 = ".$row_session['user_bn']."
         GROUP BY transfer_name
        ");
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
                    <td><?php echo $row_transfer['user1'];?></td>
                    <td><?php echo number_format($sum_new);  ?></td>
                    <td><input type="button" name="view" value="รายการ" class="btn btn-info view_data" id="<?php echo $row_transfer['transfer_name']?>"></input></td>
                    <?php 
                    if($row_session['user_lv']>=3){
                    ?>
                    <td><a href="edit/transfer_status.php?update_id=<?php echo $row_transfer['transfer_name']?>" class="btn btn-warning">ปรับยอด</a></td>
                    <?php
                    }
                    ?>
                    <td><?php echo DateThai($row_transfer['transfer_date']);?></td>
                    <td><button type="submit" class="btn btn-success data_id" onclick="submitResult(event)" id=<?php echo $row_transfer['transfer_stock_id'] ?>>อนุมัติ</button></td>
                    <td><button type="submit" class="btn btn-danger data_id" onclick="nosubmit(event)" id=<?php echo $row_transfer['transfer_stock_id'] ?>>ไม่อนุมัติ</button></td>
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
                    <?php 
                    if($row_session['user_lv']>=3){
                    ?>
                    <th scope="col" class="text-center"></th>
                    <?php } ?>
                </tr>
            </tfoot>
        </table>
    </div>
   
</body>
<?php require 'viewmodal_transfer.php'?>
<?php $user_name = $row_session['user_fname'].$row_session['user_lname'];
      $user_credit = $row_session['credit'];
      $user_id = $row_session['user_id'];
?>
  <script>
  $(document).ready(function(){
    $('.view_data').click(function(){
      var uid=$(this).attr("id");
      $.ajax({
        url:"select_transfer.php",
        method:"POST",
        data:{uid},
        success:function(data) {
          $('#detail').html(data);
          $('#dataModal').modal('show');
        }
      });
    });
  });
</script>
<script type="text/javascript" >
 function submitResult(e) {
        $('.data_id').click(function(){ 
        Swal.fire({
        title: "หมายเหตุ#ผ่าน!",
        text: "ยืนยันรายการโอนย้ายของ",
        icon:'question',
        input: 'text',
        showCancelButton: true        
        }).then((result) => {
            if (result.value) {
                text1 = result.value;
            var uid=$(this).attr("id");
            var status ="pass";
            var name = "<?php echo $user_name ?>"
            var credit = "<?php echo $user_credit ?>"
            var user_id = "<?php echo $user_id ?>"
                $.ajax({
                    url:"transfer_db.php",
                    method:"POST",
                    data:{uid:uid,text1:text1,status:status,name:name,credit:credit,user_id:user_id},
                    success:function(data) {
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
        });
    });
}
    function nosubmit(e) {
        $('.data_id').click(function(){ 
        e.preventDefault();
        Swal.fire({
        title: "หมายเหตุ#ไม่ผ่าน!",
        text: "ยืนยันยกเลิกรายการ",
        icon:'warning',
        input: 'text',
        showCancelButton: true        
        }).then((result) => {
            if (result.value) {
                text1 = result.value;
            var uid=$(this).attr("id");
            var status ="no_pass";
            var name = "<?php echo $user_name ?>"
                $.ajax({
                    url:"transfer_db.php",
                    method:"POST",
                    data:{uid:uid,text1:text1,status:status,name:name},
                    success:function(data) {
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
