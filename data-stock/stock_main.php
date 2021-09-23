<?php 
    include('../database/db.php');
    if (isset($_GET['delete_id'])) {
      $stock_id = $_GET['delete_id'];
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
    <title>รายการคงคลัง</title>
    
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
    <header>
      <div class="display-3 text-xl-center">
      <H2>รายการคงคลัง</H2>
      </div>
    </header>
    <hr><br>
    <?php include('../components/content.php')?>
  <div class="m-5">
    <br>
    <table class="table table-dark table-hover text-xl-center" id="stock_main" >
    <thead class="table-dark">
        <tr class="table-active">
            
            <th scope="col" class="text-center">รหัส</th>
            <th scope="col" class="text-center">ชื่อรายการ</th>
            <th scope="col" class="text-center">หน่วยนับ</th>
            <th scope="col" class="text-center">ราคา</th>
            <th scope="col" class="text-center">หมดอายุ</th>
            <th scope="col" class="text-center">ประเภท</th> 
            <th scope="col" class="text-center">ลักษณะ</th>
            <th scope="col" class="text-center">แผนก</th>
            <th scope="col" class="text-center">ผู้ขาย</th>
            <th scope="col" class="text-center">ยี่ห้อ</th>
            <th scope="col" class="text-center">ดู</th>
            <th scope="col" class="text-center">แก้ไข</th>  
            <th scope="col" class="text-center">ลบ</th>  
        </tr>
    </thead>
    <tbody class="table-light">
    <?php 
          $select_stmt = $db->prepare("SELECT stock_id,price_stock,stock.marque_id,marque_name,division_name,vendor_name,stock_id,code_item ,item_name,unit_name,type_name,item.exd_date,nature_name FROM stock  
          INNER JOIN item ON stock.item_id = item.item_id 
          INNER JOIN unit ON item.unit_id = unit.unit_id  
          INNER JOIN nature ON stock.nature_id = nature.nature_id   
          INNER JOIN type_item ON stock.type_id = type_item.type_id
          INNER JOIN vendor ON stock.vendor_id = vendor.vendor_id
          INNER JOIN division ON stock.division_id = division.division_id
          LEFT JOIN marque ON stock.marque_id = marque.marque_id
          ORDER BY code_item DESC ");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
      
      <tr>
        <td><?php echo $row["code_item"]; ?></td>
        <td><?php echo $row["item_name"]; ?></td>
          <td><?php echo $row["unit_name"]; ?></td>
          <td><?php echo $row["price_stock"]; ?></td>
          <?php if($row["exd_date"] >=1 && $row["exd_date"] <= 400){?>
          <td><?php echo $row["exd_date"]; ?>(วัน)</td>
          <?php }else{?>
            <td>-</td>
            <?php } ?>
        <td><?php echo $row["type_name"]; ?></td>
        <td><?php echo $row["nature_name"]; ?></td>
        <td><?php echo $row["division_name"]; ?></td>
        <td><?php echo $row["vendor_name"]; ?></td>
        <?php if ($row["marque_id"] == null) {?>
          <td>-</td>
        <?php }else{?>
          <td><?php echo $row["marque_name"]; ?></td>  
        <?php }?>      
        <td><input type="button" name="view" value="view" class="btn btn-info view_data" id="<?php echo $row["stock_id"]; ?>"/></td>
        <td><a href="edit/stock_edit.php?update_id=<?php echo $row["stock_id"]; ?>" class="btn btn-warning">Edit</a></td>
        <td><a href="?delete_id=<?php echo $row["stock_id"];?>" class="btn btn-danger">Delete</a></td>
        <?php } ?>
      </tr>
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
            <th scope="col" class="text-center"></th>
            <th scope="col" class="text-center"></th>
            <th scope="col" class="text-center"></th>
            <th scope="col" class="text-center"></th>
            </tr>
        </tfoot>
  </table>
  </div>
<?php 
require 'viewmodal.php'
?>
  <script>
  $(document).ready(function(){
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
    $('#stock_main').DataTable({
            dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
          "lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50,100, "All"] ]
        });
  });
</script>
  </body>
</html>

