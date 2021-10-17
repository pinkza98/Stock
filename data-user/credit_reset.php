<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['update_credit'])) {
        if(!empty($_REQUEST['txt_user_email'])){
            $user_email = $_REQUEST['txt_user_email'];
            $credit = $_REQUEST['txt_user_credit'];
            $user_email = trim($user_email);
            $select_user_check = $db->prepare("SELECT user_id,username,credit FROM user WHERE username = '$user_email'");
            $select_user_check->execute();
            $row = $select_user_check->fetch(PDO::FETCH_ASSOC);
            $credit = $credit + $row['credit'];
            if(empty($credit)){
                $errorMsg="กรุณากรอกเครดิต";
              }
              elseif(is_null($user_email) or $row['username']==null ){
                  $errorMsg="ไม่พบ e-mail ในระบบ";
              }else{
                try {
                    if (!isset($errorMsg)) {
                      $select_user_profile = $db->prepare("UPDATE user SET  credit = :new_credit WHERE user_id = :new_user_id");
                      $select_user_profile->bindParam(':new_credit', $credit);
                      $select_user_profile->bindParam(':new_user_id', $row['user_id']);
                      if ($select_user_profile->execute()) {
                        $updateMsg = "ข้อมูลถูกอัพเดด..";
                        header("refresh:2;credit_reset.php");
                      }else{
                        $errorMsg = "พบข้อผิดพลาดด้าน MYSQL";
                      }
                    }
                  } catch(PDOException $e) {
                       echo $e->getMessage();
                  }
              }
           
        }else{
            $user_lv = $_REQUEST['txt_user_lv'];
            $credit = $_REQUEST['txt_user_credit'];
            if(is_null($credit)){
                $errorMsg = "เครดิตเป็นค่าว่าง";
            }else{
            try {
                  $select_user_profile = $db->prepare("UPDATE user SET  credit = :new_credit WHERE user_lv = $user_lv");
                  $select_user_profile->bindParam(':new_credit', $credit);
                  if ($select_user_profile->execute()) {
                    $updateMsg = "ข้อมูลถูกอัพเดด..";
                    header("refresh:2;credit_reset.php");
                  }else{
                    $errorMsg = "พบข้อผิดพลาดด้าน MYSQL";
                  }
              } catch(PDOException $e) {
                   echo $e->getMessage();
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
        <H2>Reset Password</H2>  
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
                  <label>หรือ</label>
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
                  <label>เครดิต</label>
                    <input type="number" class="form-control" name="txt_user_credit"  placeholder="เครดิตที่ต้องการเพิ่ม" >
                  
                
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
