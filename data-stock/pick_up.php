<?php 
    include('../database/db.php');
    if (isset($_REQUEST['save'])) {//function ถ้ามีการกดปุ่ม save ให้ทำงานตรงนี้ ฟังชั่นใน การเบิกสินค้า รับตัวแปร แล้วเข้าสู่การคำนวน
        $sum = $_REQUEST['txt_sum'];
        $quantity = $_REQUEST['txt_quantity'];
        $user_id = $_REQUEST['txt_user_id'];
        $bn_id = $_REQUEST['txt_bn_id'];
        $stock_id = $_REQUEST['txt_stock_id'];
        $price_stock_log = $_REQUEST['txt_stock_price'];
        $item_name = $_REQUEST['txt_item_name'];
        $result = $quantity;
        $sum_new = $sum;
        $quantity_new = $quantity;
        $answer;
        if ($quantity > $sum) {
        $errorMsg = "จำนวนสินค้ามีไม่เพียงพอในคลัง!!";
        }elseif (is_null($quantity) or $quantity ==0) {
            $errorMsg = "กรุณาใส่กรองจำนวนที่ต้องการเบิกคลัง!!";
        }else{
                try{
                    $select_rowCount = $db->query("SELECT *  FROM branch_stock_log  
                    INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
                    WHERE branch_stock.bn_stock = '$bn_id' AND branch_stock.stock_id = '$stock_id'  ");
                    $row_count = $select_rowCount->rowCount();
                    $i=1;
                    $stop_row = 0;
                            $select_stock_full_log = $db->prepare("SELECT *  FROM branch_stock_log  
                    INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
                    WHERE branch_stock.bn_stock = '$bn_id' AND branch_stock.stock_id = '$stock_id' ORDER BY exd_date_log ASC");
                    if ($select_stock_full_log->execute()) {
                    while ($row = $select_stock_full_log->fetch(PDO::FETCH_ASSOC)AND  $stop_row != 1){
                        if($i > $row_count){
                        if ($row['item_quantity']< $quantity) {
                            $quantity = $quantity- $row['item_quantity'];
                                $del_stock_log = $db->prepare("DELETE FROM branch_stock_log WHERE full_stock_id_log  = '".$row['stock_log_id']."'");
                                if($del_stock_log->execute()){
                                    $del_bn_stock = $db->prepare("DELETE FROM branch_stock WHERE full_stock_id  = '".$row['full_stock_id']."'");
                                    $del_bn_stock->execute();
                                    $i++;
                                }
                            }
                        }elseif($i <= $row_count){
                        if ($row['item_quantity']> $quantity){
                            $quantity_as = $row['item_quantity']-$quantity;
                            $answer = $sum - $quantity_new;
                            $update_stock_log = $db->prepare("UPDATE branch_stock_log SET item_quantity = '$quantity_as'  WHERE stock_log_id = '". $row['stock_log_id']."'");
                            $insert_cut_stock = $db->prepare("INSERT INTO cut_stock_log( user_id, quantity, date, stock_id, bn_id,price_cut_stock) VALUES('$user_id','.$result.',NOW(),'.$stock_id.','.$bn_id.','.$price_stock_log.')");
                            if ( $insert_cut_stock->execute()) {
                                if($update_stock_log->execute()){
                                    $insertMsg = "เบิกรายการ (".$item_name.") เบิกออก ".$quantity_new." คงเหลือ = ".$answer;
                                    $stop_row++;
                                }
                        }else{
                            $errorMsg = "อัพเดดข้อมูลผิดพลาด!!";
                        }
                        }elseif($row['item_quantity'] < $quantity){
                            $quantity = $quantity- $row['item_quantity'];
                            $del_stock_log = $db->prepare("DELETE FROM branch_stock_log WHERE full_stock_id_log  = '".$row['stock_log_id']."'");
                                if($del_stock_log->execute()){
                                    $del_bn_stock = $db->prepare("DELETE FROM branch_stock WHERE full_stock_id  = '".$row['full_stock_id']."'");
                                    $del_bn_stock->execute();
                                }
                        }else{
                            $quantity = $quantity- $row['item_quantity'];
                            $del_stock_log = $db->prepare("DELETE FROM branch_stock_log WHERE full_stock_id_log  = '".$row['stock_log_id']."'");
                            if($del_stock_log->execute()){
                                $del_bn_stock = $db->prepare("DELETE FROM branch_stock WHERE full_stock_id  = '".$row['full_stock_id']."'");
                                $del_bn_stock->execute();
                            }
                        }
                    }
                    }
                    $insertMsg;
                
            }
            
            }catch (PDOException $e) {
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
            <H2>เบิกรายการคลัง</H2>
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
        <?php  unset($insertMsg);} ?>
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

                                <button name="check" class="btn btn-primary" type="submit">ค้นหาข้อมูล</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php 
         
          if(empty($code_item)){ //ปรับยอดรายการ โดยการสร้างตัวแปร แรกที่มีการกำหนดค่า
            $code_item =null;
            $item_name = null;
            $unit_name = null;
            $stock_id = null;
            $item_id = null;
            $price_stock =null;
            $unit = null;
            $vendor = null;
            $type_item = null;
            $exd_date = null;
            $sum = null;
            $user_bn = null;
            $sum = null;
            $exp_date_log = null; 
            $item_quantity = null;
            $full_stock_id = null;
            $item_id = null;
            $type_name = null;
            $vendor_name = null;
            $bn_name = null;
            $full_stock_id_log  = null;
            $price_stock_log = null;
            $nature_name= null;
            $division_name = null;
          }
          if(isset($_POST['check'])){
            $code_item_check = $_REQUEST['get_code_item'];
            $user_bn = $_REQUEST['txt_user_bn'];

            $select_check  = $db->prepare("SELECT code_item FROM item WHERE code_item = '".$code_item_check."'");
            $select_check ->execute();
            $row_item = $select_check->fetch(PDO::FETCH_ASSOC);
            @@extract($row_item);
            if ($select_check->fetchAll() < 1) {
                $errorMsg_item = 'ไม่มีรายการรหัสบาร์โค้ดนี้ในระบบ!!!';
              }elseif ($unit > 1 && $unit != null) {
                $errorMsg_item = 'ไม่มีรายการรหัสบาร์โค้ดนี้ในระบบ!!!';
              }
              else{
            $select_stock_full = $db->prepare("SELECT division_name,nature_name,price_stock_log,branch_stock.stock_id,full_stock_id_log,type_name,full_stock_id, code_item ,item_name, bn_name,bn_id, SUM(branch_stock_log.item_quantity) as sum,unit_name, type_name, stock.img_stock,exp_date_log,exd_date_log FROM branch_stock  
            INNER JOIN stock ON branch_stock.stock_id = stock.stock_id
            INNER JOIN item ON stock.item_id = item.item_id
            INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
            INNER JOIN unit ON item.unit_id = unit.unit_id
            INNER JOIN type_item ON stock.type_id = type_item.type_id
            INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
            INNER JOIN vendor ON stock.vendor_id = vendor.vendor_id
            INNER JOIN nature ON stock.nature_id = nature.nature_id
            INNER JOIN division ON stock.division_id = division.division_id
            WHERE bn_stock = '".$user_bn."' AND code_item = '".$code_item."' ");
            $select_stock_full->execute();
            $row_stock_full = $select_stock_full->fetch(PDO::FETCH_ASSOC);
            @@extract($row_stock_full);
            if ($select_stock_full ->fetchAll () < 1){
                $errorMsg_item = 'ไมพบรายการนี้ในคลัง!!!';
        }   elseif($select_stock_full ->fetchColumn () > 1){
                $errorMsg_item = 'ไมพบรายการนี้ในคลัง!!!';
        }   elseif($sum < 1 and $sum == null){
            $errorMsg_item = 'ยังไม่มีรายการนี้ในคลังสินค้าสาขานี้ หรือ สินค้าในคลังหมดแล้ว!!!';
        }
        
            
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
                            <label for="formGroupExampleInput" class="form-label"><b>รายการ
                                </b></label>
                            <div class="row g-3">
                                <div class="col-sm-8 mb-3 ">
                                    <input type="text" name="text_code_new" value="<?php echo$code_item?>"
                                        class="form-control" placeholder="รหัสบาร์โค้ด" aria-label="รหัสบาร์โค้ด"
                                        disabled>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <input type="text" name="text_code_new" value="<?php echo$bn_name?>"
                                        class="form-control" placeholder="สาขา" disabled>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="txt_item_name"
                                        value="<?php echo$item_name?>" placeholder="รายการ" aria-label="รายการ"
                                        disabled>
                                    <input type="text" name="txt_item_name" value="<?php echo$item_name?>" hidden>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="<?php echo$sum,$unit_name ?>"
                                        placeholder="จำนวนคงเหลือ" disabled>
                                </div>
                            </div>

                            <div class="row g-2">
                                <label for="formGroupExampleInput" class="form-label mt-3">ประเภทรายการ</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="ประเภท" class="form-control"
                                        value="<?php echo$type_name?>" disabled>
                                </div>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="ลักษณะ" class="form-control"
                                        value="<?php echo$nature_name?>" disabled>
                                </div>
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col-sm-6">
                                    <input type="text" placeholder="แผนก" class="form-control"
                                        value="<?php echo$division_name?>" disabled>
                                </div>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="ยี่ห้อ" class="form-control" value="" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <label class="form-label mt-2" for="customFile">จำนวนที่ต้องการเบิก</label>
                                <div class="col-md-6">
                                    <div class="form.group">
                                        <input type="text" name="txt_quantity" value="" class="form-control"
                                            placeholder="จำนวน" required>
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
                                        }else{ $img_stock = "box1.png";?>
                                    <img class="me-3" src="img_stock/<?=$img_stock?>" style="" width="200" height="200">
                                    <?php      
                                        }
                                        ?>
                                </div>
                                <input type="text" name="txt_stock_id" value="<?php echo$stock_id?>" hidden>
                                <input type="text" name="txt_bn_id" value="<?php echo$bn_id?>" hidden>
                                <?php $user_name = $row_session['user_fname'].$row_session['user_lname'];?>
                                <input type="text" name="txt_user_id" value="<?php echo$user_name;?>" hidden>
                                <input type="text" name="txt_stock_price" value="<?php echo$price_stock_log?>"
                                    class="form-control" hidden>

                                <input type="text" name="txt_sum" value="<?php echo$sum ?>" hidden>
                                <br>
                                <div class="col-sm-4">
                                </div>

                            </div>
                            <div class="btn-block mt-2">
                                <input type="submit" name="save" class="btn btn-outline-success" value="Insert">
                                <?php if($row_session['user_bn'] ==1){?>
                                <a href="pick_up.php" class="btn btn-outline-primary">reset</a>
                                <?php }else{ ?>
                                <a href="pick_up.php" class="btn btn-outline-primary">reset</a>
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