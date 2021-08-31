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
<link rel="icon" type="image/png" href="../components/images/tooth.png"/>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <title>Plus dental clinic</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
<!-- <==========================================booystrap 5==================================================> -->
<!-- <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- <========================================== jquery ==================================================> -->
<script src="../node_modules/jquery/dist/jquery.js"></script>
  <!-- <==========================================data-teble==================================================> -->
  <script type="text/javascript" src="../node_modules/data-table/jquery-table-2.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">    
  <link rel="stylesheet" href="../node_modules/data-table/dataTables.bootstrap.min.css" />  
  <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<!-- <==========================================data-teble==================================================> -->
            
    <?php include('../components/header.php');?>
    <script>
    $(document).ready(function() {

        $('#stock_main').DataTable({
            dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
        });
    });
    </script>
    </head>
  <body>
    <?php include('../components/nav_stock.php'); ?>
    <header>
      <div class="display-3 text-xl-center">
      <H2>รายการคงคลัง</H2>
      </div>
    </header>
    <hr><br>
    <?php include('../components/content.php')?>
  <div class="m-5">
    <br>
    <table class="table table-dark table-hover text-xl-center" id="stock_main">
    <thead class="table-dark">
        <tr class="table-active">
            
            <th scope="col" class="text-center">รหัส</th>
            
            <th scope="col" class="text-center">ชื่อรายการ</th>
            <th scope="col" class="text-center">หน่วยนับ</th>
            <th scope="col" class="text-center">EXD</th>
            <th scope="col" class="text-center">ชนิด</th> 
            <th scope="col" class="text-center">หมวดหมู่</th>
            <th scope="col" class="text-center">ฝ่าย</th>
            <th scope="col" class="text-center">ลักษณะ</th>
            <th scope="col" class="text-center">ผู้ขาย</th>
            <th scope="col" class="text-center">แก้ไข</th>  
            <th scope="col" class="text-center">ลบ</th>  
        </tr>
    </thead>
    <tbody class="table-light">
    <?php 
          $select_stmt = $db->prepare("SELECT stock_id,code_item ,catagories_name,item_name,unit_name,type_name,vendor_name,item.exd_date,cotton_name,nature_name FROM stock  
          INNER JOIN item ON stock.item_id = item.item_id 
          INNER JOIN vendor ON stock.vendor = vendor.vendor_id
          INNER JOIN unit ON item.unit = unit.unit_id  
          INNER JOIN catagories ON stock.type_catagories = catagories.catagories_id   
          INNER JOIN type_name ON stock.type_item = type_name.type_id
          INNER JOIN cotton ON stock.cotton_id = cotton.cotton_id
          INNER JOIN nature ON stock.nature_id = nature.nature_id
          ORDER BY stock_id DESC ");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
      
      <tr  >
        <td><?php echo $row["code_item"]; ?></td>
        <td><?php echo $row["item_name"]; ?></td>
          <td><?php echo $row["unit_name"]; ?></td>
          <?php if($row["exd_date"] >=1 && $row["exd_date"] <= 400){?>
          <td><?php echo $row["exd_date"]; ?>(วัน)</td>
          <?php }else{?>
            <td>-</td>
            <?php } ?>
        <td><?php echo $row["type_name"]; ?></td>
        <td><?php echo $row["catagories_name"]; ?></td>
        <td><?php echo $row["cotton_name"]; ?></td>
        <td><?php echo $row["nature_name"]; ?></td>
        
        <td><?php echo $row["vendor_name"]; ?></td>  
        <td><a href="edit/stock_edit.php?update_id=<?php echo $row["stock_id"]; ?>" class="btn btn-warning">View</a></td>
        <td><a href="?delete_id=<?php echo $row["stock_id"];?>" class="btn btn-danger">Delete</a></td>
        <?php } ?>
      </tr>
    </tbody>
    <tfoot  a>
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
            <th scope="col" class="text-center"></th>
            <th scope="col" class="text-center"></th>
            </tr>
        </tfoot>
  </table>
  </div>
  
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
