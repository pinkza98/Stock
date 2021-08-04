<?php 
    require_once('../database/db.php');
    
   

    if (isset($_REQUEST['save'])) {
      $vendor = $_REQUEST['txt_vendor'];
      $unit = $_REQUEST['txt_unit'];
      $code_item = $_REQUEST['txt_code_item'];
      $type_item = $_REQUEST['txt_type_item'];
      $type_catagories = $_REQUEST['txt_type_catagories'];
      
      $select_stmt = $db->prepare("SELECT * FROM stock WHERE code_item = :code_item_row");
      $select_stmt->bindParam(':code_item_row', $code_item);
      $select_stmt->execute();
      if ($select_stmt->fetchColumn() > 0){
        $errorMsg = 'รหัสบาร์โค้ดมีรายการซ้ำ!!!';
      }
      if (empty($type_item)) {
          $errorMsg = "Please enter type item";
      } 
      elseif(empty($type_catagories)) {
        $errorMsg = "Please enter type item catagories";
      }elseif (empty($vendor)) {
          $errorMsg = "Please enter vendor ";
      }else {
          try {
              if (!isset($errorMsg)) {
                  $insert_stmt = $db->prepare("INSERT INTO stock (vendor,unit,code_item,type_item,type_catagories) VALUES (:vendor,:unit,:code_item,:type_item,:type_catagories)");
                  $insert_stmt->bindParam(':vendor', $vendor);
                  $insert_stmt->bindParam(':unit', $unit);
                  $insert_stmt->bindParam(':code_item', $code_item);
                  $insert_stmt->bindParam(':type_item', $type_item);
                  $insert_stmt->bindParam(':type_catagories', $type_catagories);

                  if ($insert_stmt->execute()) {
                      $insertMsg = "Insert Successfully...";
                      header("refresh:1;stock.php");
                  }
              }
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
      }
  }

  
?>
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
  </head>


    
  </head>
  <body>
    
    <?php include('../components/nav_stock.php'); ?>

    <header>
    
      <div class="display-3 text-xl-center">
        <H2>เพิ่มรายการคลัง</H2>  
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




    <div class="container">
      <div class="row">
        <div class="col-md-7">
            <div class="card-header">
                <h4 class="card-title">ค้นหาข้อมูล โดย รหัสบาร์โค้ด</h4>
            </div>
            <div class="card-body">
                <form  method="post" enctype="multipart/form">
                    <div class="row">

                    <div class="col-md-6">
                      <div class="form.group">
                        <input type="text" name="get_code_item" class="form-control" placeholder=" Enter Code Item" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <button  name="fetch_btn"class="btn btn-primary" type="submit">ค้นหาข้อมูล</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
        <?php 
        $code_item =null;
        $item_name = null;
        $unit_name = null;
        $price_stock = null;
        if(isset($_POST['fetch_btn'])){
          $id = $_POST['get_code_item'];
          $select_stmt = $db->prepare("SELECT * FROM item INNER JOIN unit ON item.unit = unit_id WHERE code_item = $id ");
          $select_stmt->bindParam(':id', $code_item);
          $select_stmt->execute();
          $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
          extract($row);
        }
        ?>
        
        <div class="col-md-5">
            <form method='post' enctype='multipart/form-data'>
              <div class="card">
                <div class="card-header">
                <label for="formGroupExampleInput" class="form-label"><b>รายการ</b></label>
                
                <div class="mb-3">
                <input type="text" name="txt_code_item" value="<?php echo$code_item?>" class="form-control"placeholder="รหัสบาร์โค้ด" aria-label="รหัสบาร์โค้ด" >
                
              </div>
                <div class="row g-3">
                <div class="col-sm-7">
                  <input type="text" class="form-control" value="<?php echo$item_name?>"placeholder="รายการ" aria-label="รายการ">
                </div>
                <div class="col-sm">
                  <input type="text" class="form-control"  value="<?php echo$price_stock?>" placeholder="ราคา" aria-label="ราคา" >
                </div>
                <div class="col-sm">
                  <input type="text" class="form-control"   value="<?php echo$unit_name?>" placeholder="ต่อหน่วย" aria-label="หน่วย" >
                  <input type="text"  name="txt_unit" value="<?php echo$unit_id?>"  hidden>
                </div>
              </div>
              
              
              <div class="row g-2">
              <label for="formGroupExampleInput" class="form-label">ประเภทรายการ</label>
                <div class="col-sm-8">
                <select class="form-select" name="txt_type_item"aria-label="Default select example">
                  <option value="" selected>-- เลือก --</option>
                  <?php   
                    $select_stmt = $db->prepare("SELECT * FROM type_name");
                    $select_stmt->execute();
                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row['type_id']?>"><?php echo$row['type_name']?></option>
                  <?php }?>
                </select>
                </div>
                <div class="col-sm-4">
                <select class="form-select" name="txt_type_catagories"aria-label="Default select example">
                  <option value="" selected>-- เลือก --</option>
                  <?php   
                    $select_stmt = $db->prepare("SELECT * FROM catagories");
                    $select_stmt->execute();
                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row['catagories_id']?>"><?php echo$row['catagories_name']?></option>
                  <?php }?>
                </select>
                </div>
              </div>
              
              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">ผู้ขาย</label>
                <select name="txt_vendor"class="form-select" aria-label="Default select example">
                  <option value="" selected>-- เลือก --</option>
                  
                  <?php   
                    $select_stmt = $db->prepare("SELECT * FROM vendor");
                    $select_stmt->execute();
                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row['vendor_id']?>"><?php echo$row['vendor_name']?></option>
                  <?php }?>
          
                  </option>
                </select>
              </div>
              
                <label class="form-label" for="customFile">รูปภาพประกอบ</label>
                <input type="file"  name='files[]' class="form-control" id="customFile" multiple  />
                <br>
              <div class="mb-3">    
                <input type="submit" name="save" class="btn btn-outline-success" value="Insert">
                <a href="stock.php" class="btn btn-outline-danger">reset</a>
              </div>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>   
    
   <?php include('../components/footer.php')?>

   
   <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
   <script src="../node_modules/jquery/dist/cdn_popper.js"></script>
   <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
