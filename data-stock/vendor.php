<?php 
    require_once('../database/db.php');

    if (isset($_REQUEST['delete_id'])) {
      $vendor_id = $_REQUEST['delete_id'];

      $select_stmt = $db->prepare("SELECT * FROM vendor WHERE vendor_id = :vendor_id");
      $select_stmt->bindParam(':vendor_id', $vendor_id);
      $select_stmt->execute();
      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

      // Delete an original record from db
      $delete_stmt = $db->prepare('DELETE FROM vendor WHERE vendor_id = :vendor_id');
      $delete_stmt->bindParam(':vendor_id', $vendor_id);
      $delete_stmt->execute();

        header('Location:vendor.php');
    }if (isset($_REQUEST['save'])) {
      $vendor_name = $_REQUEST['txt_vendor_name'];
      

      if (empty($vendor_name)) {
          $errorMsg = "Please enter vendor name";
      } else {
          try {
              if (!isset($errorMsg)) {
                  $insert_stmt = $db->prepare("INSERT INTO vendor (vendor_name) VALUES (:vendor_name)");
                  $insert_stmt->bindParam(':vendor_name', $vendor_name);

                  if ($insert_stmt->execute()) {
                      $insertMsg = "Insert Successfully...";
                      header("refresh:1;vendor.php");
                  }
              }
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
      }
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
    <?php include('../components/header.php');?>
  </head>
  <body>
    
    <?php include('../components/nav_stock.php'); ?>

    <header>
    
      <div class="display-3 text-xl-center">
        <H2>เพิ่มผู้ขาย</H2>  
      </div>

    </header>
    <hr><br>

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
  <form method="post">
   <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">ชื่อผู้ขาย</label>
      <input type="text" class="form-control" name="txt_vendor_name" id="formGroupExampleInput" placeholder="ผู้ขาย........" require>
      </div>
      <div class="mb-4">
      <input type="submit" name="save" class="btn btn-outline-success" value="Insert">
                    <a href="vendor.php" class="btn btn-outline-danger">reset</a>
    </div>
    </form>
  
  <hr>
  <div class="text-center"><H2>แสดงข้อมูล</H2></div>
  <br>
   <table class="table table-dark table-hover text-xl-center">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">ผู้ขาย</th>
        <th scope="col">แก้ไข</th>
        <th scope="col">ลบ</th>
      
      </tr>
    </thead>
    <tbody>
    <?php 
          $select_stmt = $db->prepare("SELECT * FROM vendor ORDER BY vendor_id DESC");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?php echo $row["vendor_id"]; ?></td>
        <td><?php echo $row["vendor_name"]; ?></td>
        <td><a href="edit/vendor_edit.php?update_id=<?php echo $row["vendor_id"]; ?>" class="btn btn-outline-warning">View</a></td>
         <td><a href="?delete_id=<?php echo $row["vendor_id"];?>" class="btn btn-outline-danger">Delete</a></td>
        <?php } ?>
      </tr>
    </tbody>
  </table>
   </div>

      
   
   <?php include('../components/footer.php')?>
   
   <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
