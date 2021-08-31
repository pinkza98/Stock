<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['delete_id'])) {
        $full_stock_id = $_REQUEST['delete_id'];
        $select_stmt = $db->prepare("SELECT * FROM branch_stock WHERE full_stock_id  = :new_stock_id");
        $select_stmt->bindParam(':new_stock_id', $full_stock_id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        // Delete an original record from db
        $delete_stmt = $db->prepare('DELETE FROM branch_stock WHERE full_stock_id  = :new_stock_id');
        $delete_stmt->bindParam(':new_stock_id', $full_stock_id);
        $delete_stmt->execute();
        header('Location:list_stock_branch.php');
    }
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
    
    <?php include('../components/header.php');?>
</head>
<body>
    <?php include('../components/nav_stock.php'); ?>
    
        <header></header>
        <div class="display-3 text-xl-center">
            <H2>รายการคลังสาขา </H2>
        </div>
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
        <div class="container">
            <br>
            <table class="table table-dark table-hover text-xl-center" id="stock_bn">
                <thead class="table-dark">
                    <tr class="table-active">

                        <th scope="col" class="text-center">รหัสบาร์โค้ด</th>
                        <th scope="col" class="text-center">ชื่อรายการ</th>
                        <th scope="col" class="text-center">จำนวน</th>
                        <th scope="col" class="text-center">หมวดหมู่</th>
                        <th scope="col" class="text-center">ประเภท</th>
                        <th scope="col" class="text-center">สาขา</th>
                        <!-- <th scope="col" class="text-center">ราคา</th> -->
                        <!-- <th scope="col" class="text-center">ชนิด</th> -->
                        <!-- <th scope="col" class="text-center">ผู้ขาย</th>   -->
                        <!-- <th scope="col" class="text-center">รูปภาพประกอบ</th> -->
                        <!-- <th scope="col" class="text-center">แก้ไข</th>    -->
                        <!-- <th scope="col" class="text-center">ลบ</th> -->

                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                        $select_stmt = $db->prepare("SELECT unit_name,item_name,catagories_name,type_name,exp_date_log,exd_date_log ,code_item,bn_name,SUM(branch_stock_log.item_quantity) as sum FROM branch_stock  
                        INNER JOIN stock ON branch_stock.stock_id = stock.stock_id
                        INNER JOIN item ON stock.item_id = item.item_id
                        INNER JOIN catagories ON stock.type_catagories = catagories.catagories_id
                        INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
                        INNER JOIN unit ON item.unit = unit.unit_id
                        INNER JOIN type_name ON stock.type_item = type_name.type_id
                        INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log 
                        WHERE branch_stock_log.item_quantity != 0
                        group by code_item, bn_name");
                    
          
                        $select_stmt->execute();
                        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr class="table-light">
                        <td><?php echo $row["code_item"]; ?></td>
                        <td><?php echo $row["item_name"]; ?></td>
                        <td><?php echo $row["sum"]; ?> <?php echo $row["unit_name"]; ?> </td>
                        <td><?php echo $row["catagories_name"]; ?></td>
                        <td><?php echo $row["type_name"]; ?></td>
                        <td><?php echo $row["bn_name"]; ?></td>
                        <!-- <td><a href="edit/stock_edit.php?update_id=<?php echo $row["full_stock_id"]; ?>" class="btn btn-warning">View</a></td> -->
                        <!-- <td><a href="?delete_id=<?php echo $row["full_stock_id"];?>" class="btn btn-danger">Delete</a></td> -->
                        <?php } ?>
                    </tr>
                </tbody>
                <tfoot a>
                    <tr class="table-active">
                        <th scope="col" class="text-center">รหัสบาร์โค้ด</th>
                        <th scope="col" class="text-center">ชื่อรายการ</th>
                        <th scope="col" class="text-center">จำนวน</th>
                        <th scope="col" class="text-center">หมวดหมู่</th>
                        <th scope="col" class="text-center">ประเภท</th>
                        <th scope="col" class="text-center">สาขา</th>

                        <!-- <th scope="col" class="text-center">รูปภาพประกอบ</th> -->
                        <!-- <th scope="col" class="text-center">แก้ไข</th> -->
                        <!-- <th scope="col" class="text-center">ลบ</th> -->
                    </tr>
                </tfoot>
            </table>
        </div>



    </body>
</html>