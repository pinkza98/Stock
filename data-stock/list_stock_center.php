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

    <title>Plus dental clinic</title>
      <!-- <==========================================booystrap 5==================================================> -->
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
<!-- <==========================================booystrap 5==================================================> -->
  <!-- <==========================================data-teble==================================================> -->
  <script src="../node_modules/jquery/dist/jquery.js"></script>
  <script type="text/javascript" src="../node_modules/data-table/datatables.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">    
  <link rel="stylesheet" href="../node_modules/data-table/dataTables.bootstrap.min.css" />  
  <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<!-- <==========================================data-teble==================================================> -->

   
    
    <?php include('../components/header.php');?>
</head>
<body>
    <?php include('../components/nav_stock.php'); ?>
    
        <header></header>
        <div class="display-3 text-xl-center">
            <H2>รายการคลังศูนย์ </H2>
        </div>
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
        <div class="container">
            <br>
            <table class="table table-dark table-hover text-xl-center" id="stock_bn">
                <thead class="table-dark">
                    <tr class="table-active">

                    <th scope="col" class="text-center">รหัสบาร์โค้ด</th>
                        <th scope="col" class="text-center">ชื่อรายการ</th>
                        <th scope="col" class="text-center">จำนวน</th>
                        <th scope="col" class="text-center">หน่วย</th>
                        <th scope="col" class="text-center">ประเภท</th>
                        <th scope="col" class="text-center">ลักษณะ</th>
                        <th scope="col" class="text-center">แผนก</th>
                        <th scope="col" class="text-center">สาขา</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                        $select_stmt = $db->prepare("SELECT division_name,full_stock_id,unit_name,code_item,item_name,SUM(branch_stock_log.item_quantity) as sum,type_name,bn_name,nature_name FROM branch_stock  
                        INNER JOIN stock ON branch_stock.stock_id = stock.stock_id
                        INNER JOIN item ON stock.item_id = item.item_id
                        INNER JOIN division ON stock.division_id = division.division_id
                        INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
                        INNER JOIN unit ON  item.unit_id = unit.unit_id
                        INNER JOIN type_item ON stock.type_id = type_item.type_id
                        INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
                        INNER JOIN nature ON stock.nature_id = nature.nature_id
                        WHERE branch_stock_log.item_quantity != 0 AND bn_stock = 1
                        group by code_item, bn_name");
                    
          
                        $select_stmt->execute();
                        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr class="table-light">
                        <td><?php echo $row["code_item"]; ?></td>
                        <td><?php echo $row["item_name"]; ?></td>
                        <td><?php echo $row["unit_name"]; ?></td>
                        <td><?php echo $row["sum"]; ?> <?php echo $row["unit_name"]; ?> </td>
                        <td><?php echo $row["type_name"]; ?></td>
                        <td><?php echo $row["nature_name"]; ?></td>
                        <td><?php echo $row["division_name"]; ?></td>
                        <td><?php echo $row["bn_name"]; ?></td>
                        <?php } ?>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="table-active">
                    <th scope="col" class="text-center">รหัสบาร์โค้ด</th>
                        <th scope="col" class="text-center">ชื่อรายการ</th>
                        <th scope="col" class="text-center">จำนวน</th>
                        <th scope="col" class="text-center">หน่วย</th>
                        <th scope="col" class="text-center">ประเภท</th>
                        <th scope="col" class="text-center">ลักษณะ</th>
                        <th scope="col" class="text-center">แผนก</th>
                        <th scope="col" class="text-center">สาขา</th>
                    </tr>
                </tfoot>
            </table>
        </div>



    </body>
</html>

    <?php if($row_session['user_lv']==1){?>
        <script>
    $(document).ready(function() {

        $('#stock_bn').DataTable({
          "lengthMenu": [ [10, 20, 50,100, -1], [10, 20, 50,100, "All"] ]
        });
    });
    </script>
    <?php }else{?>
        <script>
    $(document).ready(function() {

        $('#stock_bn').DataTable({
            dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
          "lengthMenu": [ [10, 20, 50,100, -1], [10, 20, 50,100, "All"] ]
        });
    });
    </script>
      <?php }?>