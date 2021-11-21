<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['delete_id'])) {
      $stock_id = $_REQUEST['delete_id'];
      $select_stmt = $db->prepare("SELECT * FROM stock WHERE stock_id = :new_stock_id");
      $select_stmt->bindParam(':new_stock_id', $stock_id);
      $select_stmt->execute();
      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
      // Delete an original record from db
      $delete_stmt = $db->prepare('DELETE FROM stock WHERE stock_id = :new_stock_id');
      $delete_stmt->bindParam(':new_stock_id', $stock_id);
      $delete_stmt->execute();
        header('Location:stock_main.php');
    }
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
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <==========================================booystrap 5==================================================> -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/bootstrap@4.5.0/dist/css/bootstrap.min.css" > -->
    <script src="https://kit.fontawesome.com/43df76ab35.js" crossorigin="anonymous"></script>
    <!-- <==========================================data-teble==================================================> -->
    <script src="../node_modules/data-table/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../node_modules/data-table/datatables.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <!-- <==========================================data-teble==================================================> -->
  


    <?php include('../components/header.php');?>
    
</head>

<body>
    
    <?php include('../components/nav_stock.php'); ?>
    

    <header>
        <div class="display-3 text-xl-center">
            <H2>PIVOT สต๊อกคลังสาขา : <?php echo $row_session['bn_name']; ?> </H2>
            <input type="button" name="view" value="view" class="btn btn-info view_data" id="1690"/>            



        </div>
    </header>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col">
            <?php include('../components/nav_stock_sild_bn.php'); ?>
            </div>
        </div>
    </div>
    </header>
    <?php include('../components/content.php')?>
    <div  class="tableFixHead"style ="width:1900; word-wrap: break-word">
        <br>
        <table class="table table-hover text-center m-2 " id="stock_po">
            <thead class="table-dark">
                <tr style="font-size:12px;">
                    <th class="text-center ">No.</th>
                    <th class="text-center ">รหัส</th>
                    <th class="text-center ">รายการ</th>
                    <th class="text-center ">หน่วย</th>
                    <th class="text-center ">ผู้ขาย</th>
                    <th class="text-center ">ราคา</th>
                    <th class="text-center">คลัง</th>
                    <th class="text-center">ธุระกรรม</th>
                    <th class="text-center">จำนวน</th>
                    <th class="text-center">ผู้ดำเนินการ</th>
                    <th class="text-center">ปรับยอด</th>
                    
                </tr>
                </thead>
                <tbody class="table-light">
                <?php 
                $select_pivot_bn = $db->prepare("SELECT
                bn.stock_id,it.code_item,unit_name,item_name,v.vendor_name,price_stock,transaction_update,quantity_update,name_update,datetime_update,
                SUM(IF(bn_stock = ".$row_session['user_bn'].", item_quantity, 0)) AS BN_stock
                FROM branch_stock bn
                INNER JOIN stock s  on bn.stock_id = s.stock_id
                INNER JOIN vendor v  on s.vendor_id = v.vendor_id
                INNER JOIN item it  on s.item_id = it.item_id
                INNER JOIN unit u  on it.unit_id = u.unit_id
                INNER JOIN  branch_stock_log bsl  on bn.full_stock_id = bsl.full_stock_id_log
                WHERE bn.bn_stock = ".$row_session['user_bn']."
                GROUP BY it.item_id
                ");
                $select_pivot_bn->execute();
                date_default_timezone_set("Asia/Bangkok");
                $today = date('Y-m-d');
                $tomorrow = strtotime($today);
                $No = 1;
                while ($row = $select_pivot_bn->fetch(PDO::FETCH_ASSOC)) {
                    $date_stock = strtotime($row['datetime_update']." +15 day");
                ?>
                
                <tr class="table-light" style="font-size:12px;">
                    <td class="text-center"><?php echo $No ?></td>
                    <td class="text-center"><?php echo $row['code_item'];?></td>
                    <td class="text-left"><?php echo $row['item_name'];?></td>
                    <td class="text-center"><?php echo $row['unit_name'];?></td>
                    <td class="text-center"><?php echo $row['vendor_name'];?></td>
                    <td class="text-center"><?php echo $row['price_stock'];?></td>
                    <?php 
                    if($date_stock >= $tomorrow and $row['quantity_update'] !=null){?>
                    <td class="text-center" style="background-color: #00A00F;color:#fff"><?php echo $row['BN_stock'];?></td>
                    <td class="text-center"><?php echo $row['transaction_update'];?></td>
                    <td class="text-center"><?php echo $row['quantity_update'];?></td>
                    <td class="text-center"><?php echo $row['name_update'];?></td>
                    <td><i class="far fa-check-square fa-3x" style="color:#00A00F"></i></td> 
                

                    <?php }elseif($date_stock < $tomorrow ){?>
                        <td class="text-center" style="background-color: #ECD532;color:#090909"><?php echo $row['BN_stock'];?></td>
                    <td class="text-center"><?php echo $row['transaction_update'];?></td>
                    <td class="text-center" ><?php echo $row['quantity_update'];?></td>
                    <td class="text-center" ><?php echo $row['name_update'];?></td>
                    <td><button class="text-right view_data" id="<?php echo $row["stock_id"]; ?>"><i class="fas fa-edit fa-2x" style="color:#D5C45A"></i></button></td> 
                
                    <?php } else{ ?>
                    <td class="text-center" style="background-color: #63635D;color:#fff"><?php echo $row['BN_stock'];?></td>
                    <td class="text-center"><?php echo $row['transaction_update'];?></td>
                    <td class="text-center"><?php echo $row['quantity_update'];?></td>
                    <td class="text-center"><?php echo $row['name_update'];?></td>
                    <td><button class="text-right view_data" id="1690"><i class="fas fa-edit fa-2x" style="color:red"></i></button></td> 
                    
                    
                    <?php }?>
                   
                </tr>
                <?php $No++; } ?>
          
              
            </tbody>
        </table>
    </div>
    <?php require ('viewmodal.php');?>
<script type="text/javascript">
$(document).ready(function() {
    $('.view_data').click(function(){
        var uid=$(this).attr("id");
        $.ajax({
        url:"select_stock.php",
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
</body>
</html>

<?php if($row_session['user_lv']==1){?>
    <script>
    $(document).ready(function() {

        var table = $('#stock_po').DataTable({
            "lengthMenu": false,
            "searching": true,
            "paging": false
        });
    });
    </script>
    <?php }else{?>
        <script>
         $(document).ready(function() {
    // Setup - add a text input to each footer cell
    // DataTable
    var table = $('#stock_po').DataTable({
        dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
          "lengthMenu": false,
          "searching": true,
          "paging": false
    });
 
} );
    </script>
      <?php }?>