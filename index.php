<?php  require_once('database/db.php');?>
<link rel="icon" type="image/png" href="components/images/tooth.png"/>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <title>Plus Dental Clinic</title>
    
    <?php include('components/header.php');?>
   <!-- <==========================================booystrap 5==================================================> -->
<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- <==========================================booystrap 5==================================================> -->

  <!-- <==========================================data-teble==================================================> -->
  <script src="node_modules/data-table/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="node_modules/data-table/datatables.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">    
  <link rel="stylesheet" href="node_modules/data-table/dataTables.bootstrap.min.css" />  
  <!---แก้ไขแล้ว--> 

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.0/b-2.0.0/b-html5-2.0.0/sl-1.3.3/datatables.min.css"/>
 
 <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.0/b-2.0.0/b-html5-2.0.0/sl-1.3.3/datatables.min.js"></script>
 
<!-- <==========================================data-teble==================================================> -->
    <script>
        $(document).ready( function () {
            
        $('#stock').DataTable({
          
          "processing" : true,
          "serverSide" : true,
          "ajax" : {
            url:"fetch_stock.php",
            type:"POST"
          },
          dom: 'lBfrtip',
          buttons: [
            'excel', 'csv', 'pdf', 'copy'
          ],
          "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
  });
  
 });
    </script>
    
  </head>
  <body>
    <?php include('components/nav.php'); ?>
    <header>
      <div class="display-3 text-xl-center">
      <H2>Plus Dental Clinic</H2>
      </div>
    </header>
    <hr><br>
    <?php include('components/content.php')?>
    
  <div class="m-4">
    <br>
    <table class="table table-dark table-hover text-xl-center " id="stock">
    <thead class="table-dark ">
        <tr class="table-active">
            
            <th scope="col" class="text-center">รหัส</th>
            
            <th scope="col" class="text-center">ชื่อรายการ</th>
            <th scope="col" class="text-center">หน่วยนับ</th>
            <th scope="col" class="text-center">ราคา</th>
            <th scope="col" class="text-center">หมวดหมู่</th>
            <th scope="col" class="text-center">ชนิด</th>
            <th scope="col" class="text-center">ฝ่าย</th>
            <th scope="col" class="text-center">ลักษณะ</th>  
            <th scope="col" class="text-center">ผู้ขาย</th>  
            <!-- <th scope="col" class="text-center">รูปภาพ</th> -->
            
        </tr>
    </thead>
    <tbody class="table-light" >
    <?php 
          $select_stmt = $db->prepare("SELECT price_stock,stock_id,code_item,item_name,unit_name,item.exd_date,type_name,catagories_name,vendor_name,cotton_name,nature_name FROM stock  
          INNER JOIN item ON stock.item_id = item.item_id  
          INNER JOIN unit ON item.unit = unit.unit_id  
          INNER JOIN vendor ON stock.vendor = vendor.vendor_id
          INNER JOIN catagories ON stock.type_catagories = catagories.catagories_id   
          INNER JOIN type_name ON stock.type_item = type_name.type_id
          INNER JOIN cotton ON stock.cotton_id = cotton.cotton_id
          INNER JOIN nature ON stock.nature_id = nature.nature_id
           ORDER BY stock_id  DESC");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr  >
        <td><?php echo $row["code_item"]; ?></td>
        <td><?php echo $row["item_name"]; ?></td>
          <td><?php echo $row["unit_name"]; ?></td>
          <?php if($row['exd_date']==NUll or $row['exd_date'] < 1 or $row['exd_date'] > 500){ ?>
            <td>-</td>
        <?php }else{ ?>
          <td><?php echo $row["price_stock"]; ?>(วัน)</td>
          <?php }?>
        <td><?php echo $row["type_name"]; ?></td>
        <td><?php echo $row["catagories_name"]; ?></td>
        <td><?php echo $row["cotton_name"]; ?></td>
        <td><?php echo $row["nature_name"]; ?></td>
        <td><?php echo $row["vendor_name"]; ?></td>   
        <?php } ?>
      </tr>
    </tbody>
    <tfoot  a>
            <tr class="table-active">
            <th scope="col" class="text-center">รหัส</th>
            <th scope="col" class="text-center">ชื่อรายการ</th>
            <th scope="col" class="text-center">หน่วยนับ</th>
            <th scope="col" class="text-center">ราคา</th>
            <th scope="col" class="text-center">หมวดหมู่</th>
            <th scope="col" class="text-center">ชนิด</th>
            <th scope="col" class="text-center">ฝ่าย</th>
            <th scope="col" class="text-center">ลักษณะ</th>  
            <th scope="col" class="text-center">ผู้ขาย</th>  
            <!-- <th scope="col" class="text-center">รูปภาพ</th> -->
            </tr>
        </tfoot>
  </table>
  </div>

  </body>
</html>
