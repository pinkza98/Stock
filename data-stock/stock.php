<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['save'])) {
      $vendor = $_REQUEST['txt_vendor'];
     
      $item_id = $_REQUEST['txt_item_id'];
      $type_item = $_REQUEST['txt_type_item'];
      $type_catagories = $_REQUEST['txt_type_catagories'];
      
      $cotton_id = $_REQUEST['txt_cotton_id'];
      $nature_id = $_REQUEST['txt_nature_id'];

      $image_file = $_FILES['txt_file']['name'];  
      $type = $_FILES['txt_file']['type'];
      $size = $_FILES['txt_file']['size'];
      $temp = $_FILES['txt_file']['tmp_name'];
      $path = "img_stock/" . $image_file; // set upload folder path
      
    
      if (empty($type_item)) {
          $errorMsg = "Please enter type item";
      }  elseif(empty($cotton_id)) {
        $errorMsg = "Please enter type item cotton";
      } elseif(empty($nature_id)) {
        $errorMsg = "Please enter type item nature";
      } elseif(empty($item_id)) {
        $errorMsg = "รายการนี้ไม่มีอยู่ในระบบ";
      }
      elseif(empty($type_catagories)) {
        $errorMsg = "Please enter type item catagories";
      }elseif (empty($vendor)) {
          $errorMsg = "Please enter vendor ";
      } elseif (!empty($image_file)) {
          if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
              if (!file_exists($path)) { // check file not exist in your upload folder path
                  if ($size < 10000000) { // check file size 5MB
                      move_uploaded_file($temp, 'img_stock/'.$image_file); // move upload file temperory directory to your upload folder
                  } else {
                      $errorMsg = "รองรับขนาดของรูปภาพ ไม่เกิน 5MB"; // error message file size larger than 5mb
                  }
              } else {
                  $errorMsg = "กรุณาเปลี่ยนชื่อรูปภาพของคุณเนื่องมี ในระบบมีชื่อซ้ำในฐานช้อมูล"; // error message file not exists your upload folder path
              }
          } else {
              $errorMsg = "ไฟล์รูปภาพที่ อัพโหลดรองรับเฉพาะนามสกุลไฟล์ JPG,JPEG,PNG และ Git เท่านั้น ";
          }
      } try {
              if (!isset($errorMsg)) {
                  $insert_stock_item = $db->prepare("INSERT INTO stock (vendor,item_id,type_item,type_catagories,img_stock,nature_id,cotton_id) VALUES (:vendor,:item_id,:type_item,:type_catagories,:img_stock,:nature_id,:cotton_id)");
                  $insert_stock_item->bindParam(':vendor', $vendor);
                  $insert_stock_item->bindParam(':item_id', $item_id);
                  $insert_stock_item->bindParam(':type_item', $type_item);
                  $insert_stock_item->bindParam(':type_catagories', $type_catagories);
                  $insert_stock_item->bindParam(':img_stock', $image_file);
                  $insert_stock_item->bindParam(':nature_id', $nature_id);
                  $insert_stock_item->bindParam(':cotton_id', $cotton_id);
                  if ($insert_stock_item->execute() && !isset($errorMsg)) {
                      $insertMsg = "เพิ่มข้อมูล...";
                      header("refresh:1;stock.php");
                  }
              }
          } catch (PDOException $e) {
              echo $e->getMessage();
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
    <!-- Bootstrap CSS -->
    <title>Plus dental clinic</title>
    <?php include('../components/header.php');?>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  </head>
  </head>
  <body>
    
    <?php include('../components/nav_stock.php'); ?>
    <header>
    
      <div class="display-3 text-xl-center mt-3">
        <H2>เพิ่มรายการคลัง</H2>  
      </div>
    </header>
    <hr><br>
    <?php include('../components/content.php')?>
    <div class="container">
    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger mb-2">
            <strong>คำเตือน! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    <?php 
        if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success mb-2">
            <strong><?php echo $insertMsg; ?> สำเร็จ! </strong>
        </div>
    <?php } ?>
      <div class="row">
        <div class="col-md-7">
            <div class="card-header">
                <h4 class="card-title">ค้นหาข้อมูลด้วยรหัสบาร์โค้ด</h4>
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
                      <button  name="check"class="btn btn-primary" value="check" type="submit">ค้นหาข้อมูล</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
        <?php 
        if(empty($code_item_check)){
          $code_item =null;
          $item_name = null;
          $unit_name = null;
          $price_stock = null;
          $code_item_check =null;
          $row = NULL;
        }
          if(isset($_POST['check'])){
            $code_item_check= $_REQUEST['get_code_item'];
            $select_check_stock  = $db->prepare("SELECT * FROM stock inner JOIN item ON stock.item_id = item.item_id WHERE code_item='".$code_item_check."' AND stock.item_id = item.item_id");
            $select_check_stock ->execute();
            if ($select_check_stock ->fetchColumn() != false) {
              $errorcodeMsg = 'รหัสบาร์โค้ดนี้อยู่ใน ถูกนำไปใช้แล้ว ';
            }else{
            
            
            $select_item = $db->prepare("SELECT * FROM item INNER JOIN unit ON item.unit = unit_id WHERE code_item = '".$code_item_check."' ");
            $select_item->execute();
            $row = $select_item->fetch(PDO::FETCH_ASSOC);
            @@extract($row);
            if($code_item_check != $row['code_item']) {
              $errorcodeMsg = 'รหัสบาร์โค้ดนี้อยู่ใน ยังไม่มีในระบบ ';
            }
          }
          }
        ?>
        <div class="col-md-5">
            <form method='post' enctype='multipart/form-data'>
            <?php 
         if (isset($errorcodeMsg)) {
            ?>
                <div class="alert alert-danger mb-2">
                    <strong>คำเตือน! <?php echo $errorcodeMsg; ?></strong>
                </div>
            <?php } ?>
              <div class="card">
                <div class="card-header">
               
                <label for="formGroupExampleInput" class="form-label"><b>รายการ</b></label>
                <div class="mb-3">
                <input type="text" value="<?php echo$row['code_item']?>" class="form-control"placeholder="รหัสบาร์โค้ด" disabled>
                <input type="text" name="txt_item_id" value="<?php echo$row['item_id'];?>"hidden>
              </div>
                <div class="row g-3">
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="txt_item_name" value="<?php echo$item_name?>"placeholder="รายการ" disabled>
                </div>
                <div class="col-sm">
                  <input type="text" class="form-control"  name="txt_price"value="<?php echo$price_stock?>" placeholder="ราคา"  disabled>
                </div>
                <div class="col-sm">
                  <input type="text" class="form-control"   value="<?php echo$unit_name?>" placeholder="ต่อหน่วย" disabled>
                  <input type="text"  name="txt_unit" value="<?php echo$unit_id?>"hidden>
                  
                </div>
              </div>
              
              <label for="formGroupExampleInput" class="form-label">ประเภทรายการ</label>
              <div class="row g-2">
                <div class="col-sm-8">
                <select class="form-select" name="txt_type_item"aria-label="Default select example">
                  <option value="" selected>-- เลือก --</option>
                  <?php   
                    $select_type_name = $db->prepare("SELECT * FROM type_name");
                    $select_type_name->execute();
                    while ($row = $select_type_name->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row['type_id']?>"><?php echo$row['type_name']?></option>
                  <?php }?>
                </select>
                </div>
                <div class="col-sm-4">
                <select class="form-select" name="txt_type_catagories"aria-label="Default select example">
                  <option value="" selected>-- เลือก --</option>
                  <?php   
                    $select_catagories = $db->prepare("SELECT * FROM catagories");
                    $select_catagories->execute();
                    while ($row = $select_catagories->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row['catagories_id']?>"><?php echo$row['catagories_name']?></option>
                  <?php }?>
                </select>
                </div>
              </div>
              <div class="row g-2 mt-2 mb-2">
                <div class="col-sm-6">
                <select class="form-select" name="txt_nature_id"aria-label="Default select example">
                  <option value="" selected>-- เลือก --</option>
                  <?php   
                    $select_nature = $db->prepare("SELECT * FROM nature");
                    $select_nature->execute();
                    while ($row = $select_nature->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row['nature_id']?>"><?php echo$row['nature_name']?></option>
                  <?php }?>
                </select>
                </div>
                <div class="col-sm-6">
                <select class="form-select" name="txt_cotton_id"aria-label="Default select example">
                  <option value="" selected>-- เลือก --</option>
                  <?php   
                    $select_cotton = $db->prepare("SELECT * FROM cotton");
                    $select_cotton->execute();
                    while ($row = $select_cotton->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row['cotton_id']?>"><?php echo$row['cotton_name']?></option>
                  <?php }?>
                </select>
                </div>
              </div>
              
              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">ผู้ขาย</label>
                <select name="txt_vendor"class="form-select" aria-label="Default select example">
                  <option value="" selected>-- เลือก --</option>
                  
                  <?php   
                    $select_vendor = $db->prepare("SELECT * FROM vendor");
                    $select_vendor->execute();
                    while ($row = $select_vendor->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row['vendor_id']?>"><?php echo$row['vendor_name']?></option>
                  <?php }?>
          
                  </option>
                </select>
              </div>
              
                <label class="form-label" for="customFile">รูปภาพประกอบ</label>
                <input type="file"  name='txt_file' class="form-control" id="customFile" multiple  />
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
