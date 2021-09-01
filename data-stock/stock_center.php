<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['save'])) {
      $stock_user_id = $_REQUEST['txt_user_id'];
      $stock_bn_stock= $_REQUEST['txt_user_bn'];
      $stock_id = $_REQUEST['txt_stock_id'];
      $stock_quantity = $_REQUEST['txt_quantity'];
      $price_stock = $_REQUEST['txt_price_stock'];
      $exd_date_set = $_REQUEST['txt_exd_date'];
    
    
    if (empty($exd_date_set )){
        $exd_date_set  = 1000;
    }

      
      $date=date_create();
      @@$exd_date_set2=date_modify($date,"+$exd_date_set days");

      @@$exd_date=date_format($exd_date_set2 ,"Y-m-d" );
      $exp_date = $now = date_create()->format('Y-m-d');
      

      if (empty($stock_quantity)) {
        $errorMsg = "ไม่พบจำนวน สินค้าที่เพิ่มสต๊อก!!";
      } 
     else {
         try {
              if (!isset($errorMsg)) {
                  $insert_full_stock = $db->prepare("INSERT INTO branch_stock (user_id,stock_id,bn_stock) VALUES (:user_id,:stock_id,:bn_stock)");
                  
                  $insert_full_stock->bindParam(':user_id', $stock_user_id);
                  $insert_full_stock->bindParam(':stock_id', $stock_id);
                  $insert_full_stock->bindParam(':bn_stock', $stock_bn_stock);


                  $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_id_log,exp_date_log,item_quantity,exd_date_log,full_stock_id_log,price_stock_log) VALUES (:user_id_log,NOW(),:item_quantity,:new_exd_date_log,LAST_INSERT_ID(),:new_price)");
                  $insert_full_stock_log->bindParam(':user_id_log', $stock_user_id);
                  $insert_full_stock_log->bindParam(':item_quantity', $stock_quantity);
                  $insert_full_stock_log->bindParam(':new_exd_date_log', $exd_date);
                  $insert_full_stock_log->bindParam(':new_price', $price_stock);
                  


                  if ($insert_full_stock->execute()) {
                      if($insert_full_stock_log->execute()){
                        $insertMsg = "เพิ่มข้อมูลสำเร็จ...";
                        // header("refresh:1;stock_center.php");
                      }else{
                        $insertMsg = "ตารางที่ Logมีปัญหา...";
                      }
                  }
                  else {
                    $errorMsg="การส่งข้อมูลเกิด เหตุขัดข้อง";
                  }
                }
                else {
                    $errorMsg="มีบ้างอย่าง error โปรดแจ้ง แอดมิน";
                }
             }
           catch (PDOException $e) {
              echo $e->getMessage();
            
          }
        }
      
  }
?>
<link rel="icon" type="image/png" href="../components/images/tooth.png" />
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
            <H2>นับสต๊อกของส่วนกลาง</H2>
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
            <strong>เยี่ยม! <?php echo $insertMsg; ?></strong>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-7">
                <div class="card-header">
                    <h4 class="card-title">ค้นหาข้อมูลด้วยรหัสบาร์โค้ด</h4>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form.group">
                                    <?php 
                                    if($row_session['user_lv']>=3){
                                        ?>
                                    <?php 
                                        $select_bn = $db->prepare("SELECT * FROM branch ORDER BY bn_id DESC");
                                        $select_bn->execute();
                                        ?>

                                    <select class="form-select" name="txt_user_bn">
                                        <option value="<?php echo$row_session['user_bn']?>">สาขาปัจจุบันที่สังกัด
                                        </option>
                                        <?php  while ($row_bn = $select_bn->fetch(PDO::FETCH_ASSOC)) {?>
                                        <option value="<?php echo$row_bn['bn_id']?>"><?php echo$row_bn['bn_name']?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <?php
                                    }else{
                                    ?>
                                    <select class="form-select" name="txt_user_bn">
                                        <option value="<?php echo$row_session['user_bn']?>">สาขาปัจจุบันที่สังกัด
                                        </option>
                                    </select>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form.group">
                                    <input type="text" name="get_code_item" class="form-control"
                                        placeholder=" รหัสบาร์โค้ด" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">

                                <button name="check" class="btn btn-primary" type="submit" autofocus>ค้นหาข้อมูล</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php 
         
          if(empty($code_item)){
            $code_item =null;
            $item_name = null;
            $unit_name = null;
            $stock_id = null;
            $item_id = null;
            $price_stock =null;
            $unit = null;
            $vendor = null;
            $type_catagories = null;
            $type_item = null;
            $exd_date = null;
            $type_name = null;
            $catagories_name = null;
            $vendor_name = null;
            $item_quantity = null; 
            $sum = null;
            
          }
          if(isset($_POST['check'])){
            $code_item_check= $_REQUEST['get_code_item'];
            $user_bn = $_REQUEST['txt_user_bn'];

           
            $select_check  = $db->prepare("SELECT unit,item_name,price_stock,item_id,code_item FROM item WHERE code_item = '".$code_item_check."'");
            $select_check ->execute();
            $row_item = $select_check->fetch(PDO::FETCH_ASSOC);
            @@extract($row_item);
            if ($select_check->fetchAll() < 1) {
                $errorMsg_item = 'ไม่มีรายการรหัสบาร์โค้ดนี้ในระบบ!!!';
              }elseif ($code_item_check != $code_item ) {
                $errorMsg_item = 'ไม่มีรายการรหัสบาร์โค้ดนี้ในระบบ!!!';
              }
              else{
                $select_stock = $db->prepare("SELECT stock.stock_id,stock.item_id,img_stock,item.exd_date,code_item,item_name,price_stock,unit_name,type_name,catagories_name,vendor_name FROM stock
                INNER JOIN item ON stock.item_id = item.item_id
                INNER JOIN unit ON item.unit = unit.unit_id
                INNER JOIN type_name ON stock.type_item = type_name.type_id
                INNER JOIN catagories ON stock.type_catagories = catagories.catagories_id
                INNER JOIN vendor ON stock.vendor = vendor.vendor_id
              
                 WHERE stock.item_id='".$item_id."'");
                $select_stock->execute();
                $row_stock = $select_stock->fetch(PDO::FETCH_ASSOC);
                @@extract($row_stock);

                $select_stock_bn = $db->prepare("SELECT SUM(item_quantity) as sum FROM branch_stock 
                INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
                WHERE stock_id = '".$stock_id."' AND bn_stock = '".$user_bn."'");
                $select_stock_bn->execute();
                $row_stock_log = $select_stock_bn->fetch(PDO::FETCH_ASSOC);
                @@extract($row_stock_log);
                
              }

            }
        ?>
            <div class="col-md-5">
                <form method='post' enctype='multipart/form-data'>
                <?php 
                if (isset($errorMsg_item)) {
                ?>
                <div class="alert alert-danger mb-2">
                    <strong>คำเตือน! <?php echo $errorMsg_item; ?></strong>
                </div>
                <?php } ?>
                    <div class="card">
                        <div class="card-header">
                            <label for="formGroupExampleInput" class="form-label"><b>รายการ</b></label>
                            <div class="mb-3">
                                <input type="text" name="text_code_new" value="<?php echo$code_item?>"
                                    class="form-control" placeholder="รหัสบาร์โค้ด" aria-label="รหัสบาร์โค้ด" disabled>
                                <input type="text" name="txt_code_item" value="" hidden>
                            </div>
                            <div class="row g-3">
                            <div class="col-sm-8">
                                    <input type="text" class="form-control" name="txt_item_name"
                                        value="<?php echo$item_name?>" placeholder="รายการ" aria-label="รายการ"
                                        disabled>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" 
                                        value="<?php echo$exd_date?>" placeholder="อายุการใช้งาน" aria-label="อายุการใช้งาน"
                                        disabled>
                                        <input type="number" name="txt_exd_date" value="<?php echo$exd_date?>" hidden> 
                                </div>
                                
                                <div class="col-sm">
                                    <input type="text" class="form-control" 
                                        value="<?php echo$price_stock?>" placeholder="ราคา" aria-label="ราคา" disabled>
                                        <input type="text" class="form-control" name="txt_price_stock"
                                        value="<?php echo$price_stock?>" hidden>
                                </div>
                                <div class="col-sm">
                            
                                    <input type="text" class="form-control" value="<?php echo$unit_name?>"
                                        placeholder="ต่อหน่วย" aria-label="หน่วย" disabled>

                                </div>
                            </div>
                            <div class="row g-2">
                                <label for="formGroupExampleInput"
                                    class="form-label">ประเภทรายการ</label>
                                <div class="col-sm-6">


                                    <input type="text" placeholder="type" class="form-control"
                                        value="<?php echo$type_name?>" placeholder="type" aria-label="หน่วย" disabled>

                                </div>

                                <div class="col-sm-6">

                                    <input type="text" class="form-control" value="<?php echo$catagories_name?>"
                                        placeholder="Catagories" aria-label="หน่วย" disabled>

                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="formGroupExampleInput2" class="form-label">ผู้ขาย</label>

                                <input type="text" class="form-control" value="<?php echo$vendor_name?>"
                                    placeholder="ผู้ขาย" aria-label="หน่วย" disabled>

                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput2" class="form-label">สินค้าที่มีอยู่</label>

                                <input type="text" class="form-control" value="<?php  echo $sum?>"
                                    placeholder="จำนวนในคลัง" disabled>

                            </div>
                            <div class="row">
                            <label class="form-label " for="customFile">ข้อมูลเพิ่มเติม</label>
                            <div class="col-md-6">
                                <div class="form.group">
                                    <input type="text" name="txt_quantity" value="" class="form-control"
                                        placeholder="จำนวน">
                                </div>
                            </div>
                            
                        </div>
                            <div class="row g-3 mt-3">
                                <div class="col-sm-4">
                                    <label class="form-label " for="customFile">รูปภาพประกอบ</label><br>
                                </div>
                                <div class="col-sm-4">
                                    <?php if(empty($img_stock)){
                                        $img_stock = "box1.png";
                                        ?>
                                    <img class="me-3" src="img_stock/<?=$img_stock?>" style="" width="200" height="200">
                                    <?php
                                         }else{?>
                                    <img class="me-3" src="img_stock/<?=$img_stock?>" style="" width="200" height="200">
                                    <?php      
                                         }
                                        ?>
                                </div>
                                <input type="text" name="txt_stock_id" value="<?php echo$stock_id?>" hidden>
                                <input type="text" name="txt_user_bn" value="<?php echo$user_bn?>" hidden>
                                <input type="text" name="txt_user_id" value="<?php echo$row_session['user_id'] ?>" hidden>
                               

                                <br>
                                <div class="col-sm-4">

                                </div>

                        </div>
                            <div class="btn-block mt-2">
                            <input type="submit" name="save" class="btn btn-outline-success" value="Insert">
                            <?php if($row_session['user_bn'] ==1){?>
                            <a href="stock_center.php" class="btn btn-outline-primary">reset</a>
                            <?php }else{ ?>
                                <a href="stock_branch.php" class="btn btn-outline-primary">Back</a>
                                <?php } ?>
                        </div>
                        </div>
                </form>
            </div>
        </div>
    </div>




    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/jquery/dist/cdn_popper.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>