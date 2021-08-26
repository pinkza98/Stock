<?php 
    require_once('../../database/db.php');
    if (isset($_REQUEST['update_id'])) {
        try {
            $stock_id = $_REQUEST['update_id'];
            $select_stock = $db->prepare("SELECT * FROM stock 
            INNER JOIN item ON stock.item_id = item.item_id
            INNER JOIN unit ON item.unit = unit.unit_id
            INNER JOIN vendor ON stock.vendor = vendor.vendor_id
            INNER JOIN type_name ON stock.type_item = type_name.type_id
            INNER JOIN catagories ON stock.type_catagories = catagories.catagories_id
            INNER JOIN nature ON stock.nature_id = nature.nature_id
            INNER JOIN cotton ON stock.cotton_id = cotton.cotton_id
            WHERE stock_id = '".$stock_id."'");
            $select_stock->execute();
            $row_stock = $select_stock->fetch(PDO::FETCH_ASSOC);
            extract($row_stock);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }
    if (isset($_REQUEST['Update'])) {
        $stock_id_new = $_REQUEST['txt_stock_id'];
        $type_id = $_REQUEST['txt_type_id'];
        $catagories_id = $_REQUEST['txt_catagories_id'];
        $vendor = $_REQUEST['txt_vendor_id'];
        $nature_id = $_REQUEST['txt_nature_id'];
        $cotton_id = $_REQUEST['txt_cotton_id'];
        $img_stock_ture = $_REQUEST['txt_img_stock'];
        
        $image_file = $_FILES['txt_file']['name'];  
        $type = $_FILES['txt_file']['type'];
        $size = $_FILES['txt_file']['size'];
        $temp = $_FILES['txt_file']['tmp_name'];
        $path = "../img_stock/".$image_file; //
        $directory = "../img_stock/"; 
        
        $path = "../img_stock/". $image_file; //
        $directory = "../img_stock/"; 
    if($image_file){
        if (!empty($image_file)) {
            if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
                if (!file_exists($path)) { // check file not exist in your upload folder path
                    if ($size < 10000000) { 
                        @@unlink($directory.$img_stock_ture);// check file size 5MB
                        move_uploaded_file($temp, '../img_stock/'.$image_file); // move upload file temperory directory to your upload folder
                    } else {
                        $errorMsg = "รองรับขนาดของรูปภาพ ไม่เกิน 5MB"; // error message file size larger than 5mb
                    }
                } else {
                    $errorMsg = "ไฟล์อัพโหลดปลายทาง ไม่มีอยู่จริง! โปรดตรวจสอบ Folder"; // error message file not exists your upload folder path
                }
            } else {
                $errorMsg = "ไฟล์รูปภาพที่ อัพโหลดรองรับเฉพาะนามสกุลไฟล์ JPG,JPEG,PNG และ Git เท่านั้น ";
            }
        }
      }else{
        $image_file = $img_stock_ture;
      } 
            try {
                if (!isset($errorMsg)) {
                  if(is_null($image_file)){
                    $update_stock = $db->prepare("UPDATE stock SET 	type_item = :type_id , type_catagories = :catagories_id ,vendor = :vendor ,nature_id=:nature_id,cotton_id=:cotton_id   WHERE stock_id = '".$stock_id_new."'");
                  }else{
                    $update_stock = $db->prepare("UPDATE stock SET 	type_item = :type_id , type_catagories = :catagories_id , img_stock = :new_image_file ,vendor = :vendor  ,nature_id=:nature_id,cotton_id=:cotton_id WHERE stock_id = '".$stock_id_new."'");
                    $update_stock->bindParam(':new_image_file', $image_file);
                  }
                    
                    $update_stock->bindParam(':type_id', $type_id);
                    $update_stock->bindParam(':catagories_id', $catagories_id);
                    $update_stock->bindParam(':nature_id', $nature_id);
                    $update_stock->bindParam(':cotton_id', $cotton_id);
                    $update_stock->bindParam(':vendor', $vendor);
                    
                    
                    if ($update_stock->execute()) {
                        $updateMsg = "ข้อมูลกำลังถูกอัพเดด....";
                        header("refresh:1;../stock_main.php");
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
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
    <?php include('../../components/header.php');?>
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    
  </head>
  <body>
  <?php include('../../components/nav_edit.php'); ?>
    <header>
      <div class="display-3 text-xl-center mt-4">
        <H2>แก้ไขรายการคงคลัง</H2>  
      </div>
    </header>
    <hr><br>
    <?php include('../../components/content.php')?>
    <div class="container">
    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger mb-2">
            <strong>คำเตือน! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    <?php 
        if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success mb-2">
            <strong>สำเร็จ! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>
    <?php 
    ?>
    
      <div class="container">
        <div class="container">
        <form method="post" enctype='multipart/form-data'>
              <div class="card">
                <div class="card-header">
                <label for="formGroupExampleInput" class="form-label"><b>รายการ</b></label>
                <div class="row g-2 mb-3">
                <div class="col-sm-7">
                <input type="text"  value="<?php echo$code_item?>" class="form-control"placeholder="รหัสบาร์โค้ด" aria-label="รหัสบาร์โค้ด" disabled >
                </div>
                <div class="col-sm-5">
                <input type="text"  value="อายุ <?php echo$exd_date?> วัน" class="form-control"placeholder="จำนวนวันหมดอายุคงที่"  disabled >
                </div>
              </div>
                <div class="row g-3">
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="" value="<?php echo$item_name?>" placeholder="รายการ" aria-label="รายการ"disabled>
                </div>
                <div class="col-sm">
                  <input type="text" class="form-control" value="<?php echo$price_stock?>" placeholder="ราคา" aria-label="ราคา" disabled>
                </div>
                <div class="col-sm">
                  <input type="text" class="form-control"   value="<?php echo$unit_name ?>" placeholder="ต่อหน่วย" aria-label="หน่วย" disabled>
                  
                </div>
              </div>
              <div class="row g-2 mt-2">
              <label for="formGroupExampleInput" class="form-label">ประเภทรายการ</label>
                <div class="col-sm-8">
                <select class="form-select" name="txt_type_id"aria-label="Default select example">
                  <option value="<?php echo$type_item ?>" selected>---เลือกใหม่----ค่าเดิม >(<?php echo $type_name ?>)</option>
                  <?php   
                    $select_type = $db->prepare("SELECT * FROM type_name");
                    $select_type->execute();
                    while ($row1 = $select_type->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row1['type_id']?>"><?php echo$row1['type_name']?></option>
                  <?php }?>
                </select>
                </div>
                <div class="col-sm-4">
                <select class="form-select" name="txt_catagories_id"aria-label="Default select example">
                  <option value="<?php echo$type_catagories ?>" selected>---เลือกใหม่---ค่าเดิม >(<?php echo $catagories_name?>)</option>
                  <?php   
                    $select_catagories = $db->prepare("SELECT * FROM catagories");
                    $select_catagories->execute();
                    while ($row2 = $select_catagories->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row2['catagories_id']?>"><?php echo$row2['catagories_name']?></option>
                  <?php }?>
                </select>
                </div>
               
                <div class="col-sm-6" mt-2>
                <select class="form-select" name="txt_nature_id"aria-label="Default select example">
                  <option value="<?php echo$nature_id ?>" selected>---เลือกใหม่----ค่าเดิม >(<?php echo $nature_name ?>)</option>
                  <?php   
                    $select_nature = $db->prepare("SELECT * FROM nature");
                    $select_nature->execute();
                    while ($row4 = $select_nature->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row4['nature_id'];?>"><?php echo$row4['nature_name'];?></option>
                  <?php }?>
                </select>
                </div>
                <div class="col-sm-6">
                <select class="form-select" name="txt_cotton_id"aria-label="Default select example">
                  <option value="<?php echo$cotton_id ?>" selected>---เลือกใหม่---ค่าเดิม >(<?php echo $cotton_name?>)</option>
                  <?php   
                    $select_cotton = $db->prepare("SELECT * FROM cotton");
                    $select_cotton->execute();
                    while ($row5 = $select_cotton->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row5['cotton_id']?>"><?php echo$row5['cotton_name']?></option>
                  <?php }?>
                </select>
                </div>
              </div>
              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">ผู้ขาย</label>
                <select name="txt_vendor_id"class="form-select" aria-label="Default select example">
                  <option value="<?php echo$row_stock['vendor_id']?>" selected>---เลือกใหม่---ค่าเดิม >(<?php echo $row_stock['vendor_name']?>)</option>
                  <?php   
                    $select_vendor = $db->prepare("SELECT * FROM vendor");
                    $select_vendor->execute();
                    while ($row3 = $select_vendor->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row3['vendor_id']?>"><?php echo$row3['vendor_name']?></option>
                  <?php }?>
                  </option>
                </select>
                <div class=" mt-4">
                <input type="text" name="txt_stock_id"  value="<?php echo$stock_id?>" hidden>
                <input type="text" name="txt_img_stock"  value="<?php echo$img_stock?>" hidden>
                <img src="../img_stock/<?php echo $row_stock['img_stock']?>" width="200" height="200"></img>  
                </div> 
                <div class="mt-3">
                <input type="file" name='txt_file' class="form-control mt-4" id="customFile" multiple />
                </div>    
              <div class="mb-3  mt-3">    
                <input type="submit" name="Update" class="btn btn-outline-success" value="Update">
                <a href="../stock_main.php" class="btn btn-outline-danger">Back</a>
              </div>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>   
   
   <script>
      function Fancybox(props) {
      const delegate = props.delegate || "[data-fancybox]";

      useEffect(() => {
        NativeFancybox.assign(delegate, props.options || {});

        return () => {
          NativeFancybox.trash(delegate);

          NativeFancybox.close(true);
        };
      }, []);

      return <>{props.children}</>;
    }

    export default Fancybox;
    </script>
   <!-- <==========================================fancybox==================================================> -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
  <!-- <==========================================fancybox==================================================> -->
  <!-- <==========================================booystrap 5==================================================> -->
  <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <==========================================booystrap 5==================================================> -->
  </body>
</html>
