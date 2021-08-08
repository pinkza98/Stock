<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['register'])) {
      $email = $_REQUEST['txt_email'];
      $password1 = $_REQUEST['txt_password1'];
      $password2 = $_REQUEST['txt_password2'];
      $prefix = $_REQUEST['txt_prefix'];
      $fname = $_REQUEST['txt_fname'];
      $lname = $_REQUEST['txt_lname'];
      $user_bn = $_REQUEST['txt_user_bn'];
      $user_lv = $_REQUEST['txt_user_lv'];
      $tel = $_REQUEST['txt_tel'];
      $line = $_REQUEST['txt_line'];
      $select_stmt = $db->prepare("SELECT * FROM user WHERE username = :username");
      $select_stmt->bindParam(':username', $email);
      $select_stmt->execute();
      if ($select_stmt->fetchColumn() > 0){
        $errorMsg = 'E-mail นี้ถูกใช้งานแล้ว!!!';
      }
      elseif(empty($email)) {
        $errorMsg = "กรุณาเพิ่ม E-mail";
      }
      elseif(empty($password1)) {
        $errorMsg = "กรุณากรอกรหัสผ่าน!";
      }
      elseif(empty($password2)) {
        $errorMsg = "กรุณากรอกรหัสผ่านยืนยัน!";
      }
      elseif($password1 != $password2){
        $errorMsg = "รหัสผ่านทั้ง2 ไม่ตรงกัน!";
        } 
      else if (strlen($password1) < 6) {
        $errorMsg[] = "Password ของท่านต้องมีมากกว่า 6 ตัวอักษร";
      }
      elseif (empty($prefix)) {
        $errorMsg = "กรุณาเลือกคำนำหน้า!";
      } 
      elseif(empty($fname)) {
        $errorMsg = "กรุณาเพิ่ม ชื่อ!";
      }elseif (empty($lname)) {
          $errorMsg = "กรุณาเพิ่ม นามสกุล ";
      }elseif (empty($user_bn)) {
        $errorMsg = "กรุณาเลือก สาขาของท่าน ";
      }elseif (empty($user_lv)) {
      $errorMsg = "กรุณาเลือกระดับเจ้าหน้าที่ของท่าน";
      }
      else {
          try {
              if (!isset($errorMsg)) {
                  $password = $password1;
                  $new_password = password_hash($password, PASSWORD_DEFAULT);
                  $insert_stmt = $db->prepare("INSERT INTO user (username,password,user_prefix,user_fname,user_lname,user_bn,user_lv,user_line,user_tel) 
                  VALUES (:username,:password,:user_prefix,:user_fname,:user_lname,:user_bn,:user_lv,:user_line,:user_tel)");
                  $insert_stmt->bindParam(':username', $email);
                  $insert_stmt->bindParam(':password', $new_password);
                  $insert_stmt->bindParam(':user_prefix', $prefix);
                  $insert_stmt->bindParam(':user_fname', $fname);
                  $insert_stmt->bindParam(':user_lname', $lname);
                  $insert_stmt->bindParam(':user_bn', $user_bn);
                  $insert_stmt->bindParam(':user_lv', $user_lv);
                  $insert_stmt->bindParam(':user_line', $line);
                  $insert_stmt->bindParam(':user_tel', $tel);
                  if ($insert_stmt->execute()) {
                      $insertMsg = "เพิ่มข้อมูลสำเร็จ.......";
                      header("refresh:1;register.php");
                  }
              }
          } catch (PDOException $e) {
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
      <div class="display-3 text-xl-center">
        <H2>Register</H2>  
      </div>
    </header>
    <hr><br>
    <?php include('../components/content.php')?>
    <div class="container " >
    <div class="container col-sm-8" >
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
      <div class="row ">
        <div class="col-md-12">
            <form method='post' enctype='multipart/form-data'>
              <div class="card bg-dark text-light">
                <div class="card-header">
                <label for="formGroupExampleInput" class="form-label"><b>สมัคร</b></label>
                <div class="row g-3">
                <div class="col-sm-4">
                <input type="text" name="txt_email"  class="form-control"placeholder="E-mail" id='email' required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}">
                </div>
                <div class="col-sm-4">
                <input type="password" name="txt_password1"  class="form-control"placeholder="Password 6 อักษรขึ้นไป" >
              </div>
              <div class="col-sm-4">
                <input type="password" name="txt_password2"  class="form-control"placeholder="Confirm Password" >
              </div>
              <div class="row g-2">
              <label for="formGroupExampleInput" class="form-label"><b>ชื่อ-นามสกุล</b></label>
                <div class="col-sm-2">
                <select name="txt_prefix" class="form-select">
                    <option value=""  class="text-wrap"selected hidden> คำนำหน้า</option>
                    <?php 
                      $select_prefix = $db->prepare("SELECT * FROM prefix ORDER BY prefix_id DESC");
                      $select_prefix->execute();
                      while ($row = $select_prefix->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <option value="<?php echo $row['prefix_id'];?>"  class="text-wrap"><?php echo $row['prefix_name'];?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="col-sm-5">
                <input type="text" name="txt_fname" value="" class="form-control"placeholder="ชื่อ" >
                </div>
                <div class="col-sm-5">
                <input type="text" name="txt_lname" value="" class="form-control"placeholder="นามสกุล" >
                </div>
              </div>
                <div class="row g-2">
                <label for="formGroupExampleInput" class="form-label"><b>สิทธิ์-ข้อมูล </b></label>
                  <div class="col-sm-3">
                  <select name="txt_user_bn" id="user_bn"class="form-select ">
                  <option value=""  class="text-wrap"selected hidden>-------- สาขา --------</option>
                  <?php if($row_session['user_bn'] ==1){
                    $select_stmt = $db->prepare("SELECT * FROM branch  ORDER BY bn_id DESC");
                  }else{
                    $select_stmt = $db->prepare("SELECT * FROM branch  WHERE bn_id = '".$row_session["user_bn"]."' ORDER BY bn_id DESC");
                  }
                    $select_stmt->execute();
                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <option value="<?php echo $row['bn_id'];?>"  class="text-wrap"><?php echo $row['bn_name'];?></option>
                  <?php } ?>
                  </select>
                  </div>
                  <div class="col-sm-3">
                  <select name="txt_user_lv" id="user_lv"class="form-select ">
                    <option value=""  class="text-wrap"selected hidden>----- ระดับผู้ใช้งาน --------</option>
                    <?php 
                    if($row_session['user_lv']>=2){
                     ?>
                    <option value="1"  class="text-wrap">พนักงาน(Plus Dental Clinic)</option>
                   <?php } ?>
                   <?php 
                    if($row_session['user_lv']>=3){
                     ?>
                    <option value="2"  class="text-wrap">ผู้จัดการสาขา</option>
                    <?php } ?>
                    <?php 
                    if($row_session['user_lv']>=4){
                     ?>
                    <option value="3"  class="text-wrap">ผู้จัดการเขต</option>
                    <option value="4"  class="text-wrap">แอดมิน</option>
                    <?php } ?>
                    
                    
                  </select>
                  </div>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"  name="txt_tel" value="" placeholder="เบอร์โทร">
                  </div>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="txt_line"  value="" placeholder="ID Line">
                  </div>
                  <div class="col-sm-6 ">
                  <label class="form-label" for="customFile">รูปภาพ</label>
                <input type="file"  name='files[]' class="form-control" id="customFile" multiple  />
                </div>
              </div>
              <div class="mb-4  g-4 text-center">    
                <input type="submit" name="register" class="btn btn-outline-success" value="Register">
                <a href="register.php" class="btn btn-outline-danger">Reset</a>
              </div>
                </div>
              </div>
              </div>
              </form>
            </div>
          </div>
        </div>
        </div>   
<?php include('../components/footer.php')?>
<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
