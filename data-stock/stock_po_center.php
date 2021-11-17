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
    <!-- <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- <==========================================booystrap 5==================================================> -->

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
            <H2>PIVOT รายการสั่งซื้อ </H2>
        </div>
    </header>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col">
                <?php include('../components/nav_stock_slid.php'); ?>
            </div>
        </div>
    </div>
    </header>
    <?php include('../components/content.php')?>
    <div  class="tableFixHead"style ="width:1900; word-wrap: break-word">
        <br>
        <table class="table table-hover text-center m-2 " id="stock_po">
            <thead class="table-dark">
                <tr>
                    <th class="text-center ">รหัส</th>
                    <th class="text-center ">รายการ</th>
                    <th class="text-center ">หน่วย</th>
                    <th class="text-center ">ผู้ขาย</th>
                    <th class="text-center ">ราคา</th>
                    <th class="text-center">RA</th>
                    <th class="text-center">AR</th>
                    <th class="text-center">SA</th>
                    <th class="text-center">AS</th>
                    <th class="text-center">ON</th>
                    <th class="text-center">UD</th>
                    <th class="text-center">NW</th>
                    <th class="text-center">CW</th>
                    <th class="text-center">R2</th>
                    <th class="text-center">LB</th>
                    <th class="text-center">BK</th>
                    <th class="text-center">HQ</th>
                    <th class="text-center">CN</th>
                    <th class="text-center">รวม</th>
                    <th class="text-center">มูลค่า</th>
                    
                </tr>
            </thead>
            <tbody class="table-light">
                <?php 
                 $select_stock_po = $db->prepare("SELECT price_stock,vendor_name,unit_name,item_name,code_item,cn,ra,ar,sa,as_1,on_1,ud,nw,cw,r2,lb,bk,hq FROM stock_po 
                 INNER JOIN stock ON stock.stock_id = stock_po.stock_po_id
                 LEFT JOIN item ON  item.item_id  =stock.item_id
                 LEFT JOIN unit ON item.unit_id = unit.unit_id  
                 LEFT JOIN nature ON stock.nature_id = nature.nature_id   
                 LEFT JOIN type_item ON stock.type_id = type_item.type_id
                 LEFT JOIN vendor ON stock.vendor_id = vendor.vendor_id
                 LEFT JOIN division ON stock.division_id = division.division_id
                 LEFT JOIN marque ON stock.marque_id = marque.marque_id
                 ORDER BY code_item ASC");
                 $select_stock_po->execute();
                 $sum_order =0;
                 while ($row_stock_po = $select_stock_po->fetch(PDO::FETCH_ASSOC)) {
                     $sum_po = $row_stock_po['ra'] + $row_stock_po['ar'] + $row_stock_po['sa'] + $row_stock_po['as_1'] + $row_stock_po['on_1'] + $row_stock_po['ud'] + $row_stock_po['nw'] + $row_stock_po['cw'] + $row_stock_po['r2'] + $row_stock_po['lb'] + $row_stock_po['bk'] + $row_stock_po['hq'] + $row_stock_po['cn'];
                     if($sum_po == 0){
                        $sum_po = "-";
                     }if($row_stock_po['cn'] == 0){
                        $row_stock_po['cn'] = "-";
                     }if($row_stock_po['ra'] == 0){
                        $row_stock_po['ra'] = "-";
                     }if($row_stock_po['ar']== 0){
                        $row_stock_po['ar'] = "-";
                     }if($row_stock_po['sa']== 0){
                        $row_stock_po['sa'] = "-";
                     }if($row_stock_po['as_1']== 0){
                        $row_stock_po['as_1'] = "-";
                     }if($row_stock_po['on_1']== 0){
                        $row_stock_po['on_1'] = "-";
                     }
                     if($row_stock_po['ud']== 0){
                        $row_stock_po['ud'] = "-";
                     }
                     if($row_stock_po['nw']== 0){
                        $row_stock_po['nw'] = "-";
                     }
                     if($row_stock_po['cw']== 0){
                        $row_stock_po['cw'] = "-";
                     }
                     if($row_stock_po['r2']== 0){
                        $row_stock_po['r2'] = "-";
                     }
                     if($row_stock_po['lb']== 0){
                        $row_stock_po['lb'] = "-";
                     }
                     if($row_stock_po['bk']== 0){
                        $row_stock_po['bk'] = "-";
                     }
                     if($row_stock_po['hq']== 0){
                        $row_stock_po['hq'] = "-";
                     }
                ?>
                <tr>
                    <td><?php echo $row_stock_po['code_item'] ?></td>
                    <td><?php echo $row_stock_po['item_name'] ?></td>
                    <td><?php echo $row_stock_po['unit_name'] ?></td>
                    <td><?php echo $row_stock_po['vendor_name'] ?></td>
                    <td><?php echo $row_stock_po['price_stock'] ?></td>
                    <td><?php echo $row_stock_po['ra'] ?></td>
                    <td><?php echo $row_stock_po['ar'] ?></td>
                    <td><?php echo $row_stock_po['sa'] ?></td>
                    <td><?php echo $row_stock_po['as_1'] ?></td>
                    <td><?php echo $row_stock_po['on_1'] ?></td>
                    <td><?php echo $row_stock_po['ud'] ?></td>
                    <td><?php echo $row_stock_po['nw'] ?></td>
                    <td><?php echo $row_stock_po['cw'] ?></td>
                    <td><?php echo $row_stock_po['r2'] ?></td>
                    <td><?php echo $row_stock_po['lb'] ?></td>
                    <td><?php echo $row_stock_po['bk'] ?></td>
                    <td><?php echo $row_stock_po['hq'] ?></td>
                    <td><?php echo $row_stock_po['cn'] ?></td>
                    <td style="background-color: #82E0AA;color:#21618C"><?php echo $sum_po ?></td>
                    <?php 
                    if($row_stock_po['price_stock'] == null AND $row_stock_po['price_stock'] == 0 or $sum_po == 0){?>
                    <td>-</td>
                    <?php }else{
                        $sum_order=$sum_order+$sum_po*$row_stock_po['price_stock'];
                        ?>
                    <td><?php echo number_format($sum_po*$row_stock_po['price_stock']) ?></td>
                    <?php }?>
                    
                </tr>
                <?php }?>
                
            </tbody>
            <tfoot>
                <tr>
                <th class="text-center "></th>
                    <th class="text-center "></th>
                    <th class="text-center "></th>
                    <th class="text-center "></th>
                    <th class="text-center "></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center">รวมมูลค่าทั้งหมด</th>
                    <th class="text-left" rowspan="3">
                        <?php echo number_format($sum_order); ?> บาท
                    </th>
                    
                </tr>
            </tfoot>
        </table>
    </div>

    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php if($row_session['user_lv']==1){?>
    <script>
    $(document).ready(function() {

        $('#stock_po').DataTable({
            "lengthMenu": [ [ -1], [ "All"] ],
        });
    });
    </script>
    <?php }else{?>
        <script>
         $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#stock_po tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#stock_po').DataTable({
        dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
          "lengthMenu": [ [ -1], [ "All"] ],
    });
 
} );
    </script>
      <?php }?>