<?php 
    require_once('../database/db.php');

    if (isset($_REQUEST['delete_id'])) {
      $type_item_id = $_REQUEST['delete_id'];

      $select_stmt = $db->prepare("SELECT * FROM type_item WHERE type_item_id = :type_item_id");
      $select_stmt->bindParam(':type_item_id', $type_item_id);
      $select_stmt->execute();
      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

      // Delete an original record from db
      $delete_stmt = $db->prepare('DELETE FROM type_item WHERE type_item_id = :type_item_id');
      $delete_stmt->bindParam(':type_item_id', $type_item_id);
      $delete_stmt->execute();

        header('Location:type_item.php');
    }if (isset($_REQUEST['save'])) {
      $txt_type_name = $_REQUEST['txt_type_name'];
      $catagories = $_REQUEST['txt_catagories'];
      

      if (empty($txt_type_name)) {
          $errorMsg = "Please enter type item name";
      }elseif(empty($catagories)){
        $errorMsg = "Please enter catagories name";
      } 
      else {
          try {
              if (!isset($errorMsg)) {
                  $insert_stmt = $db->prepare("INSERT INTO type_item (type_item_name,type_catagories) VALUES ($txt_type_name,$catagories)");
                  $insert_stmt->bindParam(':type_item_name', $txt_type_name);
                  $insert_stmt->bindParam(':type_item_catagories', $catagories);

                  if ($insert_stmt->execute()) {
                      $insertMsg = "Insert Successfully...";
                      header("refresh:1;type_item.php");
                  }
              }
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
      }
  }
?>
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
        <H2>รายการประเภทสินค้า</H2>  
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
      <label for="formGroupExampleInput" class="form-label" >catagories</label>
      <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">Type</label>
      <select class="form-select" name="txt_type_name" aria-label="Default select example">
        <option  value="" selected>-- เลือก --</option>
        
        <?php 
              $query = "SELECT * FROM type_name ORDER BY type_id ";
              $result = $db->query($query);
            
              foreach($result as $row)
            {
              echo '<option value="'.$row['type_id'].'">'.$row['type_name'].'</option>';
            }
            ?>
      </select>
      </div>

        <select class="form-select" name="txt_catagories" aria-label="Default select example ">
            <option value="" selected>-- เลือก --</option>
            <?php 
              $query1 = "SELECT * FROM catagories ORDER BY catagories_id ";
              $result1 = $db->query($query1);
            
              foreach($result1 as $row)
            {
              echo '<option value="'.$row['catagories_id'].'">'.$row['catagories_name'].'</option>';
            }
            ?>
        </select>
      </div>

     
      <div class="mb-4">
      <input type="submit" name="save" class="btn btn-outline-success" value="Insert">
                    <a href="type_item.php" class="btn btn-outline-danger">reset</a>
    </div>
    </form>
  
  <hr>
  <div class="mb-4 text-center"><H2>แสดงข้อมูล</H2></div>
  <br>
   <table class="table table-dark table-hover text-xl-center">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">หมวดรายการ</th>
        <th scope="col">หมู่รายการ</th>
        
        <th scope="col">ลบ</th>
      
      </tr>
    </thead>
    <tbody>
    <?php 
            
          $select_stmt = $db->prepare("SELECT * FROM type_item INNER JOIN type_name ON type_item.type_item_name = type_name.type_id  INNER JOIN catagories ON type_item.type_catagories = catagories.catagories_id ORDER BY type_item_id DESC");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?php echo $row["type_item_id"]; ?></td>
        <td><?php echo $row["type_name"]; ?></td>
        <td><?php echo $row["catagories_name"]; ?></td>
        
        <td><a href="?delete_id=<?php echo $row["type_item_id"];?>" class="btn btn-outline-danger">Delete</a></td>
        <?php } ?>
      </tr>
    </tbody>
  </table>
   </div>

      
   
   <?php include('../components/footer.php')?>
   
   <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
