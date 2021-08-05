<link rel="icon" type="image/png" href="../components/images/tooth.png"/>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <title>Plus dental clinic</title>

    <?php include('../components/header.php');?>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

  </head>

  </head>
  <body>
    <?php include('../components/nav_user.php'); ?>
    <header>
    
    <div class="text-center"><H2>แสดงข้อมูล</H2></div>

    </header>
    <?php include('../components/content.php')?>
    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger mb-2">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success mb-2">
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>
    
   <div class="container px-4">
  <hr>
  <br>
   <table class="table table-dark table-hover text-xl-center">
    <thead>
      <tr>
        <th scope="col">ชื่อรายการ</th>
        <th scope="col">รหัสบาร์โค้ด</th>
        <th scope="col">หน่วยนับ</th>
        <th scope="col">ราคา(บาท)</th>
        <th scope="col">แก้ไข</th>
        <th scope="col">ลบ</th>

      </tr>
    </thead>
    <tbody>
    <?php 
          $select_stmt = $db->prepare("SELECT * FROM item INNER JOIN unit ON item.unit = unit.unit_id ");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?php echo $row["item_name"]; ?></td>
        <td><?php echo $row["code_item"]; ?></td>
        <td><?php echo $row["unit_name"]; ?></td>
        <td><?php echo $row["price_stock"]; ?></td>
        <td><a href="edit/item_edit.php?update_id=<?php echo $row["item_id"]; ?>" class="btn btn-outline-warning">View</a></td>
        <td><a href="?delete_id=<?php echo $row["item_id"];?>" class="btn btn-outline-danger">Delete</a></td>
        
        <?php } ?>
      </tr>
    </tbody>
  </table>
   </div>

   <?php include('../components/footer.php')?>
   
   <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>