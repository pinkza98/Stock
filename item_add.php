<?php 
    require_once('con_db.php');

    if (isset($_REQUEST['save'])) {
        $item_name = $_REQUEST['txt_item_name'];
        $unit = $_REQUEST['txt_unit'];
        

        if (empty($item_name)) {
            $errorMsg = "Please enter item_name";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $insert_stmt = $db->prepare("INSERT INTO item (item_name,unit) VALUES (:item_name,:unit)");
                    $insert_stmt->bindParam(':item_name', $item_name);
                    $insert_stmt->bindParam(':unit', $unit);
                    if ($insert_stmt->execute()) {
                        $insertMsg = "Insert Successfully...";
                        header("refresh:2;item_add.php");
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
    <title>add item</title>

    <link rel="stylesheet" href="bootstrap/bootstrap.css">
</head>
<body>
    <?php include_once('layout/nav.php')?>

    <div class="container">
    <div class="display-3 text-center">Add item</div>

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
                    <label for="item_name" class="col-sm-3 control-label">ชื่อสินค้า</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_item_name" class="form-control" placeholder="Enter item name...">
                    </div>
                </div>
                
                <div class="row">
                    <label for="item_name" class="col-sm-3 control-label">หน่วยนับ</label>
                    <div class="col-sm-9">
                       <?php 
                        $select_stmt = $db->prepare("SELECT * FROM unit");
                        $select_stmt->execute();
                        ?>
                        <select name="txt_unit"  class="form-control input-lg" data-live-search="true" title="Select Category">
                            <?php  while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['id']; ?>"> <?php echo $row['unit_name']; ?></option>
                            <?php } ?>
                            </select>
                        </select>
                        
                    </div>
                </div>
            </div>
            
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="save" class="btn btn-success" value="Insert">
                    <a href="item.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
    </form>


    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>