<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="components/images/tooth.png"/>
    <title>Plus Dental Clinic
</title>
<?php include('components/header.php');?>
   
<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="text-center mt-4">
    <H2>
      หน้าดึงข้อมูล ไป google sheet
    </H2>
  </div>
  <br>
  <div class="m-4">
   <table class="table table-dark table-hover text-xl-center ">
    <thead>
      <tr>
      <th scope="col" class="text-center">รหัสบาร์โค้ด</th>
                        <th scope="col" class="text-center">ชื่อรายการ</th>
                        <th scope="col" class="text-center">จำนวน</th>
                        <th scope="col" class="text-center">หมวดหมู่</th>
                        <th scope="col" class="text-center">ประเภท</th>
                        <th scope="col" class="text-center">สาขา</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    require_once('database/db.php');
          $select_stmt = $db->prepare("SELECT unit_name,item_name,catagories_name,img_stock,type_name,exp_date_log,exd_date_log ,code_item,bn_name,SUM(branch_stock_log.item_quantity) as sum FROM branch_stock  
          INNER JOIN stock ON branch_stock.stock_id = stock.stock_id
          INNER JOIN item ON stock.item_id = item.item_id
          INNER JOIN catagories ON stock.type_catagories = catagories.catagories_id
          INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
          INNER JOIN unit ON stock.unit = unit.unit_id
          INNER JOIN type_name ON stock.type_item = type_name.type_id
          INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
          group by code_item, bn_name");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?php echo $row["code_item"]; ?></td>
        <td><?php echo $row["item_name"]; ?></td>
        <td><?php echo $row["sum"]; ?> <?php echo $row["unit_name"]; ?> </td>
        <td><?php echo $row["catagories_name"]; ?></td>
        <td><?php echo $row["type_name"]; ?></td>
        <td><?php echo $row["bn_name"]; ?></td>
        <?php } ?>
      </tr>
    </tbody>
  </table>
  </div>
</body>
</html>
