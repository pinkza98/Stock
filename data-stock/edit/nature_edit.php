<?php 
    require_once('../../database/db.php');

    if (isset($_REQUEST['update_id'])) {
        try {
            $nature_id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM nature WHERE nature_id = :id");
            $select_stmt->bindParam(':id', $nature_id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $nature_name_new = $_REQUEST['txt_nature_name'];
        

        if (empty($nature_name_new)) {
            $errorMsg = "Please Enter nature Name";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE nature SET nature_name = :nature_name_up  WHERE nature_id = :nature_id");
                    $update_stmt->bindParam(':nature_name_up', $nature_name_new);
                    $update_stmt->bindParam(':nature_id', $nature_id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "Record update successfully...";
                        header("refresh:2;../nature.php");
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
      <label for="formGroupExampleInput" class="form-label">ลักษณะ</label>
      <input type="text" class="form-control col-auto" name="txt_nature_name" id="formGroupExampleInput" value="<?php echo $nature_name; ?>" require>
      </div>
      <div class="mb-4">
      <input type="submit" name="btn_update" class="btn btn-outline-success" value="Update">
                    <a href="../set_nature.php" class="btn btn-outline-danger">Cancel</a>
    </div>
    </form>
   </div>

   <?php include('../../components/footer.php')?>
   
   <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
