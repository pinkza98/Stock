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

  <!-- <==========================================data-teble==================================================> -->
  <script src="../node_modules/data-table/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="../node_modules/data-table/datatables.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">    
  <link rel="stylesheet" href="../node_modules/data-table/dataTables.bootstrap.min.css" />  
  <!---แก้ไขแล้ว--> 
<!-- <==========================================data-teble==================================================> -->
    <script>
    $(document).ready(function() {

        $('#stock').DataTable();
    });
    </script>
    <?php include('../components/header.php');?>
    </head>

<body>
    <?php include('../components/nav_stock.php'); ?>
   
        <header>
            <div class="display-3 text-xl-center">
                <H2>PIVOT สต๊อกคลัง </H2>
            </div>
        </header>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col">
                    <?php include('../components/nav_stock_sild_all.php'); ?>
                </div>
            </div>
        </div>
        </header>
        <?php include('../components/content.php')?>
        <div class="text-center m-4 ">
            <br> 
            <table class="table table-hover table-dark container-max-auto text-center tableFixHead">
                <thead class="">
                    <tr>
                        <th scope="col" class="text-center">รหัสใหม่</th>
                        <th scope="col" class="text-center">รายการ</th>
                        <th scope="col" class="text-center">ผู้ขาย</th>
                        <th scope="col" class="text-center">หน่วย</th>
                        <th scope="col" class="text-center">รามคำแหง</th>
                        <th scope="col" class="text-center">อารีย์</th>
                        <th scope="col" class="text-center">สาทร</th>
                        <th scope="col" class="text-center">อโศก</th>
                        <th scope="col" class="text-center">อ่อนนุช</th>
                        <th scope="col" class="text-center">อุดมสุข</th>
                        <th scope="col" class="text-center">งามวงค์วาน</th>
                        <th scope="col" class="text-center">แจ้งวัฒนะ</th>
                        <th scope="col" class="text-center">พระราม2</th>
                        <th scope="col" class="text-center">ลาดกระบัง</th>
                        <th scope="col" class="text-center">บางแค</th>
                        <th scope="col" class="text-center">สาขาส่วนกลาง</th>
                        <th scope="col" class="text-center">รวม</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
    
    $select_stmt = $db->prepare("SELECT
    it.code_item,unit_name,item_name,v.vendor_name,
    SUM(IF(bn_stock = 1, item_quantity, 0)) AS BN1,
    SUM(IF(bn_stock = 2, item_quantity, 0)) AS BN2,
    SUM(IF(bn_stock = 3, item_quantity, 0)) AS BN3,
      SUM(IF(bn_stock = 4, item_quantity, 0)) AS BN4,
      SUM(IF(bn_stock = 5, item_quantity, 0)) AS BN5,
      SUM(IF(bn_stock = 6, item_quantity, 0)) AS BN6,
      SUM(IF(bn_stock = 7, item_quantity, 0)) AS BN7,
      SUM(IF(bn_stock = 8, item_quantity, 0)) AS BN8,
      SUM(IF(bn_stock = 9, item_quantity, 0)) AS BN9,
      SUM(IF(bn_stock = 10, item_quantity, 0)) AS BN10,
      SUM(IF(bn_stock = 11, item_quantity, 0)) AS BN11,
      SUM(IF(bn_stock = 12, item_quantity, 0)) AS BN12,
      SUM(CASE WHEN bn_stock=1 or bn_stock=2 or bn_stock=3 or bn_stock=4 or bn_stock=5 or bn_stock=6 or bn_stock=7 or bn_stock=8 or bn_stock=9 or bn_stock=10 or bn_stock=11 or bn_stock=12 THEN item_quantity ELSE NULL END) AS SUM_BN
    FROM branch_stock bn
    INNER JOIN stock s  on bn.stock_id = s.stock_id
    INNER JOIN vendor v  on s.vendor = v.vendor_id
    INNER JOIN item it  on s.item_id = it.item_id
    INNER JOIN unit u  on it.unit = u.unit_id
    INNER JOIN  branch_stock_log bsl  on bn.full_stock_id = bsl.full_stock_id_log
    WHERE
      bn.bn_stock BETWEEN 1 AND 12
    GROUP BY
      it.item_id;");
    $select_stmt->execute();
    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>                  
                    <?php if($row['SUM_BN']==0){ ?>
                    <tr class="table-danger">
                        <?php }else {?>
                    <tr class="table-light">
                        <?php } ?>
                        <td><?php echo $row["code_item"]; ?></td>
                        <td><?php echo $row["item_name"]; ?></td>
                        <td><?php echo $row["vendor_name"]; ?></td>
                        <td><?php echo $row["unit_name"]; ?></td>
                        <td><?php echo $row["BN2"]; ?></td>
                        <td><?php echo $row["BN3"]; ?></td>
                        <td><?php echo $row["BN4"]; ?></td>
                        <td><?php echo $row["BN5"]; ?></td>
                        <td><?php echo $row["BN6"]; ?></td>
                        <td><?php echo $row["BN7"]; ?></td>
                        <td><?php echo $row["BN8"]; ?></td>
                        <td><?php echo $row["BN9"]; ?></td>
                        <td><?php echo $row["BN10"]; ?></td>
                        <td><?php echo $row["BN11"]; ?></td>
                        <td><?php echo $row["BN12"]; ?></td>
                        <td><?php echo $row["BN1"]; ?></td>
                        <td><?php echo $row["SUM_BN"]; ?></td>

                        <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>