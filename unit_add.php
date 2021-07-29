<?php 
    require_once('con_db.php');

    if (isset($_REQUEST['save'])) {
        $unit_name = $_REQUEST['txt_unit_name'];
        

        if (empty($unit_name)) {
            $errorMsg = "Please enter unit_name";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $insert_stmt = $db->prepare("INSERT INTO unit (unit_name) VALUES (:unit_name)");
                    $insert_stmt->bindParam(':unit_name', $unit_name);

                    if ($insert_stmt->execute()) {
                        $insertMsg = "Insert Successfully...";
                        header("refresh:2;unit_add.php");
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="bootstrap/bootstrap.css">
</head>
<body>
    <?php include_once('layout/nav.php')?>

    <div class="container">
    <div class="display-3 text-center">Add unit</div>

    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>

    <form method="post" class="form-horizontal mt-5">
            
            <div class="form-group text-center">
                <div class="row">
                    <label for="unit_name" class="col-sm-3 control-label">ชื่อหน่วยนับ</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_unit_name" class="form-control" placeholder="Enter unit_name...">
                    </div>
                </div>
            </div>
            
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="save" class="btn btn-success" value="Insert">
                    <a href="unit.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
    </form>


    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>