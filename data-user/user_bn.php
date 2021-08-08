<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['delete_id'])) {
      $user_id_del = $_REQUEST['delete_id'];
      $select_stmt = $db->prepare("SELECT * FROM user WHERE user_id = :del_user_id");
      $select_stmt->bindParam(':del_user_id', $user_id_del);
      $select_stmt->execute();
      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
      // Delete an original record from db
      $delete_stmt = $db->prepare('DELETE FROM user WHERE user_id = :del_user_id');
      $delete_stmt->bindParam(':del_user_id', $user_id_del);
      $delete_stmt->execute();
        header('Location:user_bn.php');
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
    <?php include('../components/header.php');?>
      <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/b-1.7.1/datatables.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">         
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
      <script type="text/javascript" src="node_modules/data-table/bootstrap-table.min.css"></script>  <!---แก้ไขแล้ว--> 
  </head>
  <script>
        $(document).ready( function () {
            
        $('#user').DataTable();
            } );
  </script>
  <body>
    <?php include('../components/nav_user.php'); ?>
    <header>
    <div class="text-center"><H2>แสดงข้อมูลบุคลากรประจำสาขา</H2></div>
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
   <table class="table table-dark table-hover text-xl-center" id="user">
    <thead>
      <tr>
        <th scope="col">E-mail</th>
        <th scope="col">ชื่อ-สกุล</th>
        <th scope="col">สาขา</th>
        <th scope="col">ตำแหน่ง</th>
        <th scope="col">เบอร์โทร</th>
        <th scope="col">ไลน์ไอดี</th>
        <th scope="col">แก้ไข</th>
        <th scope="col">ลบ</th>
      </tr>
    </thead>
    <tbody>
    <?php 
          $select_stmt = $db->prepare("SELECT * FROM user 
          INNER JOIN branch ON user.user_bn = branch.bn_id 
          INNER JOIN prefix ON user.user_prefix = prefix.prefix_id 
          INNER JOIN level ON user.user_lv = level.level_id
          WHERE user.user_bn = branch.bn_id AND user.user_bn != 1");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr class="table-light">
        <td><?php echo $row["username"]; ?></td>
        <td><?php echo $row["prefix_name"]; ?><?php echo $row["user_fname"]; ?> <?php echo $row["user_lname"]; ?></td>
        <td><?php echo $row["bn_name"]; ?></td>
        <td><?php echo $row["level_name"]; ?></td>
        <td><?php echo $row["user_tel"]; ?></td>
        <td><?php echo $row["user_line"]; ?></td>
        <?php if($row["user_lv"]>=3 && $row["bn_id"]!=1) {?>
        <td><a href="edit/user_edit.php?update_id=<?php echo $row["user_id"]; ?>" class="btn btn-outline-warning">View</a></td>
        <td><a href="?delete_id=<?php echo $row["user_id"];?>" class="btn btn-outline-danger">Delete</a></td>
        <?php }?>
        <?php } ?>
      </tr>
    </tbody>
    <tfoot class="table-light">
        <tr class="table-active">
          <th scope="col">E-mail</th>
          <th scope="col">ชื่อ-สกุล</th>
          <th scope="col">สาขา</th>
          <th scope="col">ตำแหน่ง</th>
          <th scope="col">เบอร์โทร</th>
          <th scope="col">ไลน์ไอดี</th>
          <th scope="col">แก้ไข</th>
          <th scope="col">ลบ</th>    
            <!-- <th scope="col" class="text-center">รูปภาพประกอบ</th> -->
          </tr>
        </tfoot>
  </table>
   </div>
   <?php include('../components/footer.php')?>
   <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>