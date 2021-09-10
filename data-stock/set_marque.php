<?php 
    require_once('../database/db.php');

    if (isset($_REQUEST['delete_id'])) {
      $marque_id = $_REQUEST['delete_id'];

      $select_stmt = $db->prepare("SELECT * FROM marque WHERE marque_id = :marque_id");
      $select_stmt->bindParam(':marque_id', $marque_id);
      $select_stmt->execute();
      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

      // Delete an original record from db
      $delete_stmt = $db->prepare('DELETE FROM marque WHERE marque_id = :marque_id');
      $delete_stmt->bindParam(':marque_id', $marque_id);
      $delete_stmt->execute();

        header('Location:marque.php');
    }if (isset($_REQUEST['save'])) {
      $marque_name = $_REQUEST['txt_marque_name'];
      

      if (empty($marque_name)) {
          $errorMsg = "Please enter marque name";
      } else {
          try {
              if (!isset($errorMsg)) {
                  $insert_stmt = $db->prepare("INSERT INTO marque (marque_name) VALUES (:marque_name)");
                  $insert_stmt->bindParam(':marque_name', $marque_name);

                  if ($insert_stmt->execute()) {
                      $insertMsg = "Insert Successfully...";
                      header("refresh:1;set_marque.php");
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
    
    <!-- <==========================================booystrap 5==================================================> -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <==========================================booystrap 5==================================================> -->

    <!-- <==========================================data-teble==================================================> -->
    <link rel="stylesheet" href="../node_modules/data-table/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="../node_modules/data-table/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../node_modules/data-table/datatables.min.js"></script>
    <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <!-- <==========================================data-teble==================================================> -->
    <?php include('../components/header.php');?>
  </head>
  <script>
    $(document).ready(function() {

        $('#stock').DataTable({
            dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
        });
    });
    </script>
  <body>
    
    <?php include('../components/nav_stock.php'); ?>

    <header>
    
      <div class="display-3 text-xl-center">
        <H2>เพิ่มยี่ห้อ</H2>  
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
      <label for="formGroupExampleInput" class="form-label">ชื่อยี่ห้อ</label>
      <input type="text" class="form-control" name="txt_marque_name" id="formGroupExampleInput" placeholder="ยี่ห้อ........" require>
      </div>
      <div class="mb-4">
      <input type="submit" name="save" class="btn btn-outline-success" value="Insert">
                    <a href="set_marque.php" class="btn btn-outline-danger">reset</a>
    </div>
    </form>
  
  <hr>
  <div class="text-center"><H2>แสดงข้อมูล</H2></div>
  <br>
   <table class="table table-dark table-hover text-center" id="stock">
    <thead class="table-dark text-center">
      <tr>
       
        <th class="text-center" scope="col">ยี่ห้อ</th>
        <th class="text-center" scope="col">แก้ไข</th>
        <!-- <th scope="col">ลบ</th> -->
      
      </tr>
    </thead>
    <tbody class="table-light">
    <?php 
          $select_stmt = $db->prepare("SELECT * FROM marque ORDER BY marque_id DESC");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        
        <td><?php echo $row["marque_name"]; ?></td>
        <td><a href="edit/marque_edit.php?update_id=<?php echo $row["marque_id"]; ?>" class="btn btn-outline-warning">View</a></td>
         <!-- <td><a href="?delete_id=<?php echo $row["marque_id"];?>" class="btn btn-outline-danger">Delete</a></td> -->
        <?php } ?>
      </tr>
    </tbody>
  </table>
   </div>

      
   
   <?php include('../components/footer.php')?>
   

  </body>
</html>
