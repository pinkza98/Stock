<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['update_password'])) {
      $user_email = $_REQUEST['txt_user_email'];
      $password1 = $_REQUEST['txt_user_password1'];
      $password2 = $_REQUEST['txt_user_password2'];
      $user_email = trim($user_email);
      $select_user_check = $db->prepare("SELECT user_id,username FROM user WHERE username = :new_user_email");
      $select_user_check->execute(array(':new_user_email' => $user_email));
      $row = $select_user_check->fetch(PDO::FETCH_ASSOC);

    if(empty($password1) && empty($password2)){
      $errorMsg="กรุณากรอกรหัสผ่าน";
    }
    elseif(is_null($user_email) or $row['username']==null ){
        $errorMsg="ไม่พบ e-mail ในระบบ";
    }
     else if (strlen($password1) < 6 && strlen($password2) < 6) {
      $errorMsg = "Password ของท่านต้องมีมากกว่า 6 ตัวอักษร";
    }
    elseif($password1 != $password2){
        $errorMsg = "ยืนยันรหัสผ่านไม่ถูกต้อง";
    }
    else{
            try {
              if (!isset($errorMsg)) {
                $super_new_password = password_hash($password1, PASSWORD_DEFAULT);
                $select_user_profile = $db->prepare("UPDATE user SET  password = :super_new_password WHERE user_id = :new_user_id");
                $select_user_profile->bindParam(':super_new_password', $super_new_password);
                $select_user_profile->bindParam(':new_user_id', $row['user_id']);
                if ($select_user_profile->execute()) {
                  $updateMsg = "ข้อมูลถูกอัพเดด..";
                  header("refresh:2;../index.php");
                }else{
                  $errorMsg = "พบข้อผิดพลาดด้าน MYSQL";
                }
              }
            } catch(PDOException $e) {
                 echo $e->getMessage();
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
                  <input type="text"  name="txt_user_email" class="form-control" placeholder="E-mail ที่ต้องการแก้รหัสผ่าน" >
                  <div class="col-sm-12"></div>
                  </div>
                  </div>
                  <div class="col-sm-12 mb-2">
                  <label>รหัสผ่านใหม่</label>
                    <input type="password" class="form-control" name="txt_user_password1"  placeholder="New Password" >
                  </div>
                  <div class="col-sm-12 mb-2">
                  <label>รหัสผ่านใหม่ยืนยัน</label>
                    <input type="password" class="form-control" name="txt_user_password2"  placeholder="confirm Password" >
                  </div>
                
                <div class="mb-3 mt-3 mb-2">    
                  <input type="submit" name="update_password" class="btn btn-outline-success" value="Update">
                  <a href="../index.php" class="btn btn-outline-danger">Back</a>
                </div>
                </div>
               
              </form>
        </div>   

   <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
   <script src="../node_modules/jquery/dist/cdn_popper.js"></script>
   <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
