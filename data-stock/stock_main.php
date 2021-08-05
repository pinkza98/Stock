<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['delete_id'])) {
      $bn_id = $_REQUEST['delete_id'];
      $select_stmt = $db->prepare("SELECT * FROM branch WHERE bn_id = :bn_id");
      $select_stmt->bindParam(':bn_id', $bn_id);
      $select_stmt->execute();
      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
      // Delete an original record from db
      $delete_stmt = $db->prepare('DELETE FROM branch WHERE bn_id = :bn_id');
      $delete_stmt->bindParam(':bn_id', $bn_id);
      $delete_stmt->execute();
        header('Location:set_branch.php');
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
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/b-1.7.1/datatables.min.css"/>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/b-1.7.1/datatables.min.js"></script>
    <script>
        $(document).ready( function () {
            
        $('#stock').DataTable();
            } );
    </script>
    <?php include('../components/header.php');?>
  </head>
  <body>
    
    <?php include('../components/nav_stock.php'); ?>
    <header>
      <div class="display-3 text-xl-center">
        <H2>แสดงข้อมูล</H2>  
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
   <div class="container px-4">
    <br>
    <table class="table table-dark table-hover text-xl-center" id="stock">
    <thead class="table-dark">
        <tr class="table-active">
            <th scope="col">#</th>
            <th scope="col">ชื่อสาขา</th>
            <th scope="col">แก้ไข</th>
            <th scope="col">ลบ</th>
        </tr>
    </thead>
    <tbody >
    <?php 
          $select_stmt = $db->prepare("SELECT * FROM branch ORDER BY bn_id DESC");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr  class="table-light">
        <td><?php echo $row["bn_id"]; ?></td>
        <td><?php echo $row["bn_name"]; ?></td>
        <td><a href="edit/bn_edit.php?update_id=<?php echo $row["bn_id"]; ?>" class="btn btn-warning">View</a></td>
         <td><a href="?delete_id=<?php echo $row["bn_id"];?>" class="btn btn-danger">Delete</a></td>
        <?php } ?>
      </tr>
    </tbody>
  </table>
   </div>
   <?php include('../components/footer.php')?>
   <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
