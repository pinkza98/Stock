<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['update_credit'])) {

        $user_email = $_REQUEST['txt_user_email'];
        $user_lv = $_REQUEST['txt_user_lv'];
        $user_bn = $_REQUEST['txt_user_bn'];

        $select_user_check = $db->prepare("SELECT username FROM user WHERE username = '$user_email'");
        $select_user_check->execute();
        $row = $select_user_check->fetch(PDO::FETCH_ASSOC);
        if(empty($user_email) or $user_email != $row['username']){
            $errorMsg = "ไม่พบข้อมูล emil user";
        }else{
            if(empty($user_lv)){
                $update_user = $db->prepare("UPDATE user SET  user_bn = '$user_bn' WHERE username = '$user_email'");
                $update_user->execute();
                $updateMsg = "อัพเดพสาขาใหม่สำเร็จ";
            }elseif(empty($user_bn)){

                $update_user = $db->prepare("UPDATE user SET user_lv = '$user_lv' WHERE username = '$user_email'");
                $update_user->execute();
                $updateMsg = "อัพเดพระดับใช้งานใหม่สำเร็จ";
            }else{
                try{
                    $update_user = $db->prepare("UPDATE user SET user_lv = '$user_lv', user_bn = '$user_bn' WHERE username = '$user_email'");
                    $update_user->execute();
                    $updateMsg = "อัพเดพระดับใช้งานใหม่สำเร็จ";
                }catch(PDOException $ex){
                    echo $ex->getMessage();
                }
            }
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
  <?php include('../components/nav_user.php'); ?>
    <header>
      <div class="display-3 text-xl-center mt-5">
        <H2>แก้ไขข้อมูลสมาชิก</H2>  
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
        if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success mb-2">
            <strong>สำเร็จ! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>
    <?php 
    ?>
      <div class="container pt-3">
            <form method='POST' enctype='multipart/form-data'>
              <div class="container col-md-5">
                 
                  <label for="formGroupExampleInput" class="form-label"><b>ข้อมูล</b></label>
                  <div class="row g-4">
                  <div class="mb-2">
                  <input type="text"  name="txt_user_email" class="form-control" placeholder="E-mail " >
                  <div class="col-sm-12"></div>
                  </div>
                  </div>
                  <label>ระดับการใช้งาน</label>
                  <div class="col-sm-12 mb-2 mt-2">
                  <div class="col-sm-6">
                  <select name="txt_user_lv" class="form-select ">
                    <option value=""  class="text-wrap"selected hidden>----- ระดับผู้ใช้งาน --------</option>
                    <option value="1"  class="text-wrap">พนักงาน(Plus Dental Clinic)</option>
                    <option value="2"  class="text-wrap">ผู้จัดการสาขา</option>
                    <option value="3"  class="text-wrap">ผู้จัดการเขต</option>
                    <option value="4"  class="text-wrap">CEO</option>
                    <option value="5"  class="text-wrap">Admin</option>
                  </select>
                  </div>
                  </div>
                  <label>สาขา</label>
                  <select name="txt_user_bn" class="form-select ">
                    <option value=""  class="text-wrap"selected hidden>----- เลือกสาขา --------</option>
                    <option value="1"  class="text-wrap">ส่วนกลาง</option>
                    <option value="2"  class="text-wrap">รามคำแหง</option>
                    <option value="3"  class="text-wrap">อารีย์</option>
                    <option value="4"  class="text-wrap">อโศก</option>
                    <option value="5"  class="text-wrap">อ่อนนุช</option>
                    <option value="6"  class="text-wrap">รามคำแหง</option>
                    <option value="7"  class="text-wrap">อุดมสุข</option>
                    <option value="8"  class="text-wrap">งามวงค์วาน</option>
                    <option value="9"  class="text-wrap">แจ้งวัฒนะ</option>
                    <option value="10"  class="text-wrap">พระราม2</option>
                    <option value="11"  class="text-wrap">ลาดกระบัง</option>
                    <option value="12"  class="text-wrap">บางแค</option>
                    <option value="13"  class="text-wrap">Office</option>
                  </select>
                <div class="mb-3 mt-3 mb-2">    
                  <input type="submit" name="update_credit" class="btn btn-outline-success" value="Update">
                  <a href="../index.php" class="btn btn-outline-danger">Back</a>
                </div>
                </div>
                </div>
              </form>
        </div>    
   <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
   <script src="../node_modules/jquery/dist/cdn_popper.js"></script>
   <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
