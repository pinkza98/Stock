<?php 
    require_once('../../database/db.php');
    if (isset($_REQUEST['update_id'])) {
        try {
            $stock_id = $_REQUEST['update_id'];
            $select_stock = $db->prepare("SELECT * FROM stock 
            LEFT JOIN item ON stock.item_id = item.item_id
            RIGHT JOIN unit ON item.unit_id = unit.unit_id
            LEFT JOIN vendor ON stock.vendor_id = vendor.vendor_id
            LEFT JOIN type_item ON stock.type_id = type_item.type_id
            LEFT JOIN division ON stock.division_id = division.division_id
            LEFT JOIN nature ON stock.nature_id = nature.nature_id
            LEFT JOIN marque ON stock.marque_id = 	marque.marque_id
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
        $nature_id = $_REQUEST['txt_nature_id'];
        $division_id = $_REQUEST['txt_division_id'];
        $marque_id = $_REQUEST['txt_marque_id'];
        $vendor_id = $_REQUEST['txt_vendor_id'];
        $img_stock_true = $_REQUEST['txt_img_stock'];
        
        $image_file = $_FILES['txt_file']['name'];  
        $type = $_FILES['txt_file']['type'];
        $size = $_FILES['txt_file']['size'];
        $temp = $_FILES['txt_file']['tmp_name'];
        $path = "../img_stock/".$image_file; //
        $directory = "../img_stock/"; 
        
        $path = "../img_stock/". $image_file; //
        $directory = "../img_stock/"; 
      if(is_null($marque_id)){
        $marque_id = null;
      }
      elseif($image_file){
        if (!empty($image_file)) {
            if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
                if (!file_exists($path)) { // check file not exist in your upload folder path
                    if ($size < 10000000) { 
                        unlink($directory.$img_stock);// check file size 5MB
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
        $image_file = $img_stock_true;
      } 
            try {
                if (!isset($errorMsg)) {

                    $update_stock = $db->prepare("UPDATE stock SET 	type_id = :type_id , nature_id = :nature_id , division_id = :division_id	,marque_id = :marque_id ,vendor_id = :vendor_id ,img_stock = :new_image_file	WHERE stock_id = '".$stock_id_new."'");
                    $update_stock->bindParam(':new_image_file', $image_file);
                    $update_stock->bindParam(':type_id', $type_id);
                    $update_stock->bindParam(':division_id', $division_id);
                    $update_stock->bindParam(':nature_id', $nature_id);
                    $update_stock->bindParam(':marque_id', $marque_id);
                    $update_stock->bindParam(':vendor_id', $vendor_id);

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
    <!-- <==========================================fancybox==================================================> -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
    <!-- <==========================================fancybox==================================================> -->
    <!-- <==========================================booystrap 5==================================================> -->
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <==========================================booystrap 5==================================================> -->
    
  </head>
  <body>
  <?php include('../../components/nav_edit.php'); ?>
    <header>
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
                  <?php if($exd_date == null) {?>
                <input type="text"  value="อายุ ไม่ได้กำหนด" class="form-control"placeholder="จำนวนวันหมดอายุคงที่"  disabled >
                <?php }else{ ?>
                  <input type="text"  value="อายุ <?php echo $exd_date ?> วัน" class="form-control"placeholder="จำนวนวันหมดอายุคงที่"  disabled >
                  <?php } ?>
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
                  <option value="<?php echo$type_id ?>" selected>---ประเภท----</option>
                  <?php   
                    $select_type = $db->prepare("SELECT * FROM type_item");
                    $select_type->execute();
                    while ($row1 = $select_type->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row1['type_id']?>"><?php echo$row1['type_name']?></option>
                  <?php }?>
                </select>
                </div>
                <div class="col-sm-4">
                <select class="form-select" name="txt_nature_id"aria-label="Default select example">
                  <option value="<?php echo$nature_id ?>" selected>---ลักษณะ---</option>
                  <?php   
                    $select_nature = $db->prepare("SELECT * FROM nature");
                    $select_nature->execute();
                    while ($row2 = $select_nature->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row2['nature_id']?>"><?php echo$row2['nature_name']?></option>
                  <?php }?>
                </select>
                </div>
               
                <div class="col-sm-6" mt-2>
                <select class="form-select" name="txt_division_id"aria-label="Default select example">
                  <option value="<?php echo$division_id ?>" selected>---แผนก----</option>
                  <?php   
                    $select_division = $db->prepare("SELECT * FROM division");
                    $select_division->execute();
                    while ($row4 = $select_division->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row4['division_id'];?>"><?php echo$row4['division_name'];?></option>
                  <?php }?>
                </select>
                </div>
                <div class="col-sm-6">
                <select class="form-select" name="txt_marque_id"aria-label="Default select example">
                  <option value="<?=$marque_id?>" selected>---ยี่ห้อ---</option>
                  <?php   
                    $select_marque = $db->prepare("SELECT * FROM marque");
                    $select_marque->execute();
                    while ($row5 = $select_marque->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo$row5['marque_id']?>"><?php echo$row5['marque_name']?></option>
                  <?php }?>
                </select>
                </div>
              </div>
              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">ผู้ขาย</label>
                <select name="txt_vendor_id"class="form-select" aria-label="Default select example">
                  <option value="<?php echo $vendor_id ?>" selected>---ผู้ขาย---</option>
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
                <button data-src="../img_stock/<?php echo $row_stock['img_stock']?>" className="button button-secondary"><img src="../img_stock/<?php echo $row_stock['img_stock'] ?>"/></button>
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
  </body>
</html>
