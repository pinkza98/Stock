<?php 
    require_once('../../database/db.php');

    if (isset($_REQUEST['update_id'])) {
        try {
            $type_id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM type_item WHERE type_id = :id");
            $select_stmt->bindParam(':id', $type_id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $type_name_new = $_REQUEST['txt_type_name'];
        

        if (empty($type_name_new)) {
            $errorMsg = "Please Enter type_item Name";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE type_item SET type_name = :type_name_up  WHERE type_id = :type_id");
                    $update_stmt->bindParam(':type_name_up', $type_name_new);
                    $update_stmt->bindParam(':type_id', $type_id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "Record update successfully...";
                        header("refresh:1;../set_type_item.php");
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>
<link rel="icon" type="image/png" href="../../components/images/tooth.png"/>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <title>Plus dental clinic</title>
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <?php include('../../components/header.php');?>
  </head>
  <body>
    
    <?php include('../../components/nav_edit.php'); ?>

    <header>
    
      <div class="display-3 text-xl-center">
        <H2>แก้ไขข้อมูล</H2>  
      </div>

    </header>
    <hr><br>

    <?php include('../../components/content.php')?>
    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger mb-2">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success mb-2">
            <strong>Update Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>
   <div class="container px-4"">
     
   <form method="post">
   <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">ประเภท</label>
      <input type="text" class="form-control col-auto" name="txt_type_name" id="formGroupExampleInput" value="<?php echo $type_name; ?>" require>
      </div>
      <div class="mb-4">
      <input type="submit" name="btn_update" class="btn btn-outline-success" value="Update">
                    <a href="../set_type_item.php" class="btn btn-outline-danger">Cancel</a>
    </div>
    </form>
   </div>

   <?php include('../../components/footer.php')?>
   
   <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
