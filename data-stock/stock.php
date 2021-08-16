<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['save'])) {
      $vendor = $_REQUEST['txt_vendor'];
      $check_code = $_REQUEST['text_code_new'];
      $unit = $_REQUEST['txt_unit'];
      $code_item = $_REQUEST['txt_code_item'];
      $type_item = $_REQUEST['txt_type_item'];
      $type_catagories = $_REQUEST['txt_type_catagories'];
      $item_name = $_REQUEST['txt_item_name'];
      $price = $_REQUEST['txt_price'];
      $exd_date = $_REQUEST['txt_exd_date'];

      $image_file = $_FILES['txt_file']['name'];  
      $type = $_FILES['txt_file']['type'];
      $size = $_FILES['txt_file']['size'];
      $temp = $_FILES['txt_file']['tmp_name'];
      $path = "img_stock/" . $image_file; // set upload folder path
      
      $select_stmt = $db->prepare("SELECT * FROM stock WHERE item_id = :code_item_row");
      $select_stmt->bindParam(':code_item_row', $code_item);
      $select_stmt->execute();

      if ($select_stmt->fetchColumn() > 0){
        $errorMsg = 'รหัสบาร์โค้ดมีรายการซ้ำ!!!';
      }
      elseif (empty($type_item)) {
          $errorMsg = "Please enter type item";
      } 
      elseif(empty($unit)){
        $errorMsg = "รหัสบาร์โค้ดนี้ ไม่มีอยู่จริง!";
      }
      elseif(empty($item_name)){
        $errorMsg = "รหัสบาร์โค้ดนี้ ไม่มีอยู่จริง!";
      }
      elseif(empty($price)){
        $errorMsg = "รหัสบาร์โค้ดนี้ ไม่มีอยู่จริง!";
      }
      elseif(empty($type_catagories)) {
        $errorMsg = "Please enter type item catagories";
      }elseif (empty($vendor)) {
          $errorMsg = "Please enter vendor ";
      }elseif ($unit==0) {
        $errorMsg = "รหัสบาร์โค้ดนี้ ไม่มีอยู่จริง!";
      } elseif (!empty($image_file)) {
          if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
              if (!file_exists($path)) { // check file not exist in your upload folder path
                  if ($size < 10000000) { // check file size 5MB
                      move_uploaded_file($temp, 'img_stock/'.$image_file); // move upload file temperory directory to your upload folder
                  } else {
                      $errorMsg = "รองรับขนาดของรูปภาพ ไม่เกิน 5MB"; // error message file size larger than 5mb
                  }
              } else {
                  $errorMsg = "ไฟล์อัพโหลดปลายทาง ไม่มีอยู่จริง! โปรดตรวจสอบ Folder"; // error message file not exists your upload folder path
              }
          } else {
              $errorMsg = "ไฟล์รูปภาพที่ อัพโหลดรองรับเฉพาะนามสกุลไฟล์ JPG,JPEG,PNG และ Git เท่านั้น ";
          }
      } try {
              if (!isset($errorMsg)) {
                  $insert_stmt = $db->prepare("INSERT INTO stock (vendor,unit,item_id,type_item,type_catagories,img_stock,exd_date) VALUES (:vendor,:unit,:code_item,:type_item,:type_catagories,:img_stock,:new_exd_date)");
                  $insert_stmt->bindParam(':vendor', $vendor);
                  $insert_stmt->bindParam(':unit', $unit);
                  $insert_stmt->bindParam(':code_item', $code_item);
                  $insert_stmt->bindParam(':type_item', $type_item);
                  $insert_stmt->bindParam(':type_catagories', $type_catagories);
                  $insert_stmt->bindParam(':img_stock', $image_file);
                  $insert_stmt->bindParam(':new_exd_date', $exd_date);
                  if ($insert_stmt->execute()) {
                      $insertMsg = "Insert Successfully...";
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
    
      <div class="display-3 text-xl-center">
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
            <strong>Success! <?php echo $insertMsg; ?></strong>
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
          $code_item =null;
          $item_name = null;
          $unit_name = null;
          $price_stock = null;
          if(isset($_POST['check'])){
            $code_item = $_REQUEST['get_code_item'];
            $select_check  = $db->prepare("SELECT * FROM item WHERE code_item = :code_item_row");
            $select_check ->bindParam(':code_item_row', $code_item);
            $select_check ->execute();
            if ($select_check ->fetchColumn() == 0){
              $errorMsg = 'รหัสบาร์โค้ดนี้ไม่มีอยู่จริง!!!';
            }else{
            $select_stmt = $db->prepare("SELECT * FROM item INNER JOIN unit ON item.unit = unit_id WHERE code_item = $code_item ");
            $select_stmt->bindParam(':id', $code_item);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            }
          }
        ?>
        <div class="col-md-5">
            <form method='post' enctype='multipart/form-data'>
              <div class="card">
                <div class="card-header">
                <label for="formGroupExampleInput" class="form-label"><b>รายการ</b></label>
                <div class="mb-3">
                <input type="text"  name="text_code_new"value="<?php echo$code_item?>" class="form-control"placeholder="รหัสบาร์โค้ด" aria-label="รหัสบาร์โค้ด" >
                <input type="text"  name="txt_code_item" value="<?php echo$item_id?>"hidden>
              </div>
                <div class="row g-3">
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="txt_item_name" value="<?php echo$item_name?>"placeholder="รายการ" aria-label="รายการ">
                </div>
                <div class="col-sm">
                  <input type="text" class="form-control"  name="txt_price"value="<?php echo$price_stock?>" placeholder="ราคา" aria-label="ราคา" >
                </div>
                <div class="col-sm">
                  <input type="text" class="form-control"   value="<?php echo$unit_name?>" placeholder="ต่อหน่วย" aria-label="หน่วย" >
                  <input type="text"  name="txt_unit" value="<?php echo$unit_id?>"hidden>
                  <input type="text"  name="txt_exd_date" value="<?php echo$exd_date?>"hidden>
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
