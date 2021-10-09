<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['save'])) {
      $bn_name = $_REQUEST['txt_branch_name'];
      $bn_acronym = $_REQUEST['txt_branch_acronym'];

      if (empty($bn_name)) {
          $errorMsg = "Please enter branch name";
      }if (empty($bn_acronym)) {
        $errorMsg = "Please enter branch acronym name";
    }else {
          try {
              if (!isset($errorMsg)) {
                  $insert_stmt = $db->prepare("INSERT INTO branch (bn_name,bn_acronym) VALUES (:bn_name,:bn_acronym)");
                  $insert_stmt->bindParam(':bn_name', $bn_name);
                  $insert_stmt->bindParam(':bn_acronym', $bn_acronym);
                  if ($insert_stmt->execute()) {
                      $insertMsg = "Insert Successfully...";
                      header("refresh:1;set_branch.php");
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
  </head>
  <script>
    $(document).ready(function() {

        $('#stock_bn').DataTable({
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
        <H2>เพิ่มสาขา</H2>  
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
      <label for="formGroupExampleInput" class="form-label">ชื่อสาขา</label>
      <input type="text" class="form-control" name="txt_branch_name" id="formGroupExampleInput"  placeholder="ชื่อสาขา" require>
      </div>
      <div class="mb-4">
      <input type="text" class="form-control" name="txt_branch_acronym" id="formGroupExampleInput" placeholder="ชื่อย่อสาขา" require>
      </div>
      <div class="mb-4">
      <input type="submit" name="save" class="btn btn-outline-success" value="Insert">
                    <a href="set_branch.php" class="btn btn-outline-danger">reset</a>
    </div>
    </form>
  <hr>
  <div class="text-center">
    <H2>
      แสดงข้อมูล
    </H2>
  </div>
  <br>
   <table class="table table-dark table-hover text-xl-center" id="stock_bn">
    <thead>
      <tr>
        
        <th>ชื่อสาขา</th>
        <th>ชื่อย่อ</th>
        <th>แก้ไข</th>
      </tr>
    </thead>
    <tbody class="table-light">
    <?php 
          $select_stmt = $db->prepare("SELECT * FROM branch ORDER BY bn_id DESC");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
       
        <td><?php echo $row["bn_name"]; ?></td>
        <td><?php echo $row["bn_acronym"]; ?></td>
        <td><a href="edit/bn_edit.php?update_id=<?php echo $row["bn_id"]; ?>" class="btn btn-outline-warning">View</a></td>
        <?php } ?>
      </tr>
    </tbody>
  </table>
   </div>  
   <?php include('../components/footer.php')?>
   
   <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
