<?php 
    require_once('../../database/db.php');

    if (isset($_REQUEST['update_id'])) {
        try {
            $bn_id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM branch WHERE bn_id = :id");
            $select_stmt->bindParam(':id', $bn_id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $bn_name_new = $_REQUEST['txt_bn_name'];
        

        if (empty($bn_name_new)) {
            $errorMsg = "Please Enter branch Name";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE branch SET bn_name = :barnch_name_up  WHERE bn_id = :bn_id");
                    $update_stmt->bindParam(':barnch_name_up', $bn_name_new);
                    $update_stmt->bindParam(':bn_id', $bn_id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "Record update successfully...";
                        header("refresh:2;../set_branch.php");
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
        <H2>เพิ่มสาขา</H2>  
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
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>
   <div class="container px-4">
  <form method="post">
   <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">ชื่อสาขา</label>
      <input type="text" class="form-control col-auto" name="txt_bn_name" id="formGroupExampleInput" value="<?php echo $bn_name; ?>" require>
      </div>
      <div class="mb-4">
      <input type="submit" name="btn_update" class="btn btn-outline-success" value="update">
                    <a href="../set_branch.php" class="btn btn-outline-danger">Cancel</a>
    </div>
    </form>
   </div>

      
   
   <?php include('../../components/footer.php')?>
   
   <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
