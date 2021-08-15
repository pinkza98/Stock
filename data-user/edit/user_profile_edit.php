<?php 
    require_once('../../database/db.php');
    if (isset($_REQUEST['update_user'])) {

      $user_id = $_REQUEST['txt_user_id'];
      $user_tel = $_REQUEST['txt_user_tel'];
      $user_line = $_REQUEST['txt_user_line'];
      
      if(empty($user_id)){
        $errorMsg="มีข้อผิดพลาดของ User โปรดแจ้งฝ่ายไอที";
      }
      elseif(empty($user_tel)){
        $errorMsg="เบอร์โทรไม่สามารถเป็นค่าว่างได้";
      }
      elseif(empty($user_line)){
        $errorMsg = "กรุณากรอกข้อมูล line id ";
      }else{
        try {
            $select_user_profile = $db->prepare("UPDATE user SET  user_tel = :new_user_tel ,user_line = :new_user_line WHERE user_id = :new_user_id");
            $select_user_profile->bindParam(':new_user_id', $user_id);
            $select_user_profile->bindParam(':new_user_tel', $user_tel);
            $select_user_profile->bindParam(':new_user_line', $user_line);
            $select_user_profile->execute();
            if ($select_user_profile->execute()) {
              $updateMsg = "ข้อมูลถูกอัพเดด...";
              header("refresh:2;../user_profile.php");
              
            }else{
              $errorMsg = "พบข้อผิดพลาดด้าน MYSQL";
            }
          
        } catch(PDOException $e) {
             echo $e->getMessage();
        }
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
              <div class="card">
                  <div class="card-header">
                  <label for="formGroupExampleInput" class="form-label"><b>ข้อมูล</b></label>
                  <div class="mb-3">
                  <input type="text"  value="<?php echo$row_session['username']?>" class="form-control" disabled>
                  <input type="text" name="txt_user_id" value="<?php echo$row_session['user_id']?>" hidden>
                  </div>
                  <div class="row g-3">
                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="txt_user_tel" value="<?php echo$row_session['user_tel']?>" placeholder="TelePhone" >
                  </div>
                  <div class="col-sm">
                    <input type="text" class="form-control" name="txt_user_line" value="<?=$row_session['user_line']?>" placeholder="Line ID" >
                  </div>
                </div>
                <div class="mb-3 mt-3 mb-2">    
                  <input type="submit" name="update_user" class="btn btn-outline-success" value="Update">
                  <a href="../user_profile.php" class="btn btn-outline-danger">Back</a>
                </div>
                </div>
                </div>
              </form>
        </div>   

   <script src="../../node_modules/jquery/dist/jquery.slim.min.js"></script>
   <script src="../../node_modules/jquery/dist/cdn_popper.js"></script>
   <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
