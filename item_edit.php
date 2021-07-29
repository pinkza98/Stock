<?php 
    require_once('con_db.php');

    if (isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM item WHERE id_item = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $item_name_up = $_REQUEST['txt_item_name'];
		$unit_up = $_REQUEST['txt_unit'];
        

        if (empty($item_name_up)) {
            $errorMsg = "Please Enter item Name";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE item SET item_name = :item_up, unit =:unit_up WHERE id_item = :id");
                    $update_stmt->bindParam(':item_up', $item_name_up);
					$update_stmt->bindParam(':unit_up', $unit_up);
                   
                    $update_stmt->bindParam(':id', $id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "Record update successfully...";
                        header("refresh:2;item.php");
                    }
                }
            } catch(PDOException $e) {
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
<?php include_once('layout/nav.php'); ?>

    <div class="container">
    <div class="display-3 text-center">Edit Page</div>

    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>

    <form method="post" class="form-horizontal mt-5">
            
            <div class="form-group text-center">
                <div class="row">
                    <label for="item_name" class="col-sm-3 control-label">item name</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_item_name" class="form-control" value="<?php echo $item_name; ?>">
                    </div>
                </div>
				<div class="row">
                    <label for="unit" class="col-sm-3 control-label">หน่วยนับ</label>
                    <div class="col-sm-9">
                       <?php 
                        $select_stmt = $db->prepare("SELECT * FROM unit");
                        $select_stmt->execute();
                        ?>
                        <select name="txt_unit"  class="form-control input-lg" data-live-search="true" >
                            <?php  while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['id']; ?>"> <?php echo $row['unit_name'];?></option>
                            <?php } ?>
                            </select>
                        </select>
                        
                    </div>
                </div>
            </div>
            </div>
            
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="item.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>


    </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>