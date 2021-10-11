<?php 
    require_once('../../database/db.php');
    if (isset($_REQUEST['update_password'])) {
        $user_id = $_REQUEST['txt_user_id'];
      $password = $_REQUEST['txt_user_password'];
      $password1 = $_REQUEST['txt_user_password1'];
      $password2 = $_REQUEST['txt_user_password2'];
      $select_user_check = $db->prepare("SELECT user_id,password FROM user WHERE user_id = :new_user_id");
      $select_user_check->execute(array(':new_user_id' => $user_id));
      $row = $select_user_check->fetch(PDO::FETCH_ASSOC);
     $password_check=password_verify($password,$row['password']);
     $hashed_password = password_hash($row['password'], PASSWORD_DEFAULT);
     $hashed_password2 = password_hash($row['password'], PASSWORD_BCRYPT);
     var_dump($hashed_password);
     if($password_check==true){
        if(is_null($password1)){
            $errorMsg="รหัสผ่านใหม่ ไม่เป็นค่าว่าง";
          }
          elseif(is_null($password2)){
            $errorMsg = "กรุณากรอกรหัสผ่านยืนยันใหม่ ";
          }elseif($password1 =! $password2){
              $errorMsg = "รหัสผ่านใหม่ทั้งสอง ไม่เหมือนกัน";
          }
          else{
            try {
              if (!isset($errorMsg)) {
                $new_password = $password1;
                $super_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $select_user_profile = $db->prepare("UPDATE user SET  password = :super_new_password WHERE user_id = :new_user_id");
                $select_user_profile->bindParam(':super_new_password', $super_new_password);
                $select_user_profile->bindParam(':new_user_id', $user_id);
                // if ($select_user_profile->execute()) {
                //   $updateMsg = "ข้อมูลถูกอัพเดด...";
                //   header("refresh:2;../user_profile.php");
                  
                // }else{
                //   $errorMsg = "พบข้อผิดพลาดด้าน MYSQL แจ้งฝ่ายไอที";
                // }
              }else{
                $errorMsg = "รหัสผ่านไม่ถูกต้อง";
              }
            } catch(PDOException $e) {
                 echo $e->getMessage();
            }
        }
     }else{
         $errorMsg="รหัสผ่านเดิม ไม่ถูกต้อง";
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
  </head>
  <body>
  <?php include('../../components/nav_edit.php'); ?>
    <header>
      <div class="display-3 text-xl-center mt-5">
        <H2>แก้ไขข้อมูลส่วนตัว</H2>  
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
      <div class="container pt-3">
            <form method='POST' enctype='multipart/form-data'>
              <div class="container col-md-5">
                 
                  <label for="formGroupExampleInput" class="form-label"><b>ข้อมูล</b></label>
                  <div class="row g-4">
                  <div class="mb-2">
                  <input type="text"  value="<?php echo$row_session['username']?>" class="form-control" disabled>
                  <input type="text" name="txt_user_id" value="<?php echo$row_session['user_id']?>" hidden>
                  <div class="col-sm-12"></div>
                  </div>
                  </div>
                  
                  <div class="col-sm-12 mb-2">
                      <label>รหัสผ่านเดิม</label>
                    <input type="password" class="form-control" name="txt_user_password"  placeholder="old password" >
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
                  <a href="../user_profile.php" class="btn btn-outline-danger">Back</a>
                </div>
                </div>
               
              </form>
        </div>   

   <script src="../../node_modules/jquery/dist/jquery.slim.min.js"></script>
   <script src="../../node_modules/jquery/dist/cdn_popper.js"></script>
   <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
