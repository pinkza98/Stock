<?php 
    require_once('../database/db.php');
    
   

    if (isset($_REQUEST['save'])) {
      $vendor = $_REQUEST['txt_vendor'];
      $unit = $_REQUEST['txt_unit'];
      $code_item = $_REQUEST['txt_code_item'];
      $type_item = $_REQUEST['txt_type_item'];
      $type_catagories = $_REQUEST['txt_type_catagories'];
      
      $select_stmt = $db->prepare("SELECT * FROM stock WHERE code_item = :code_item_row");
      $select_stmt->bindParam(':code_item_row', $code_item);
      $select_stmt->execute();
      if ($select_stmt->fetchColumn() > 0){
        $errorMsg = 'รหัสบาร์โค้ดมีรายการซ้ำ!!!';
      }
      if (empty($type_item)) {
          $errorMsg = "Please enter type item";
      } 
      elseif(empty($type_catagories)) {
        $errorMsg = "Please enter type item catagories";
      }elseif (empty($vendor)) {
          $errorMsg = "Please enter vendor ";
      }else {
          try {
              if (!isset($errorMsg)) {
                  $insert_stmt = $db->prepare("INSERT INTO stock (vendor,unit,code_item,type_item,type_catagories) VALUES (:vendor,:unit,:code_item,:type_item,:type_catagories)");
                  $insert_stmt->bindParam(':vendor', $vendor);
                  $insert_stmt->bindParam(':unit', $unit);
                  $insert_stmt->bindParam(':code_item', $code_item);
                  $insert_stmt->bindParam(':type_item', $type_item);
                  $insert_stmt->bindParam(':type_catagories', $type_catagories);

                  if ($insert_stmt->execute()) {
                      $insertMsg = "Insert Successfully...";
                      header("refresh:1;stock.php");
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
    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger mb-2">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success mb-2">
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>


    <?php 
        $code_item =null;
        $item_name = null;
        $unit_name = null;
        $price_stock = null;
        if(isset($_POST['fetch_btn'])){
          $id = $_POST['get_code_item'];
          $select_stmt = $db->prepare("SELECT * FROM item INNER JOIN unit ON item.unit = unit_id WHERE code_item = $id ");
          $select_stmt->bindParam(':id', $code_item);
          $select_stmt->execute();
          $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
          extract($row);
        }
        ?>

    <div class="container " >
    <div class="container col-sm-8" >
      <div class="row ">
        <div class="col-md-12">
            <form method='post' enctype='multipart/form-data'>
              <div class="card bg-transparent text-light" style="background-image: url('../components/images/a6ZcNv.jpg');opacity: 0.9;"  >
                <div class="card-header">
                <label for="formGroupExampleInput" class="form-label"><b>สมัคร</b></label>
                <div class="row g-3">
                <div class="col-sm-4">
                <input type="text" name="txt_code_item" value="" class="form-control"placeholder="E-mail" >
                </div>
                <div class="col-sm-4">
                <input type="password" name="txt_code_item" value="" class="form-control"placeholder="Password" >
              </div>
              <div class="col-sm-4">
                <input type="password" name="txt_code_item" value="" class="form-control"placeholder="Confirm Password" >
              </div>
              
              <div class="row g-2">
              <label for="formGroupExampleInput" class="form-label"><b>ชื่อ-นามสกุล</b></label>
                <div class="col-sm-2">
                <select name="txt_unit" id="unit_name"class="form-select ">
                    <option value=""  class="text-wrap"selected hidden> คำนำหน้า</option>
                    <option value=""  class="text-wrap" > นาย</option>
                    <option value=""  class="text-wrap" > นาง</option>
                    <option value=""  class="text-wrap" > นางสาว</option>
                  </select>
                </div>
                <div class="col-sm-5">
                <input type="password" name="txt_code_item" value="" class="form-control"placeholder="ชื่อ" >
                </div>
                <div class="col-sm-5">
                <input type="password" name="txt_code_item" value="" class="form-control"placeholder="นามสกุล" >
                </div>
              </div>
              
                <div class="row g-2">
                <label for="formGroupExampleInput" class="form-label"><b>สิทธิ์-ข้อมูล </b></label>
                  <div class="col-sm-3">
                  <select name="txt_unit" id="unit_name"class="form-select ">
                    <option value=""  class="text-wrap"selected hidden>-------- สาขา --------</option>
                  </select>
                  </div>
                  <div class="col-sm-3">
                  <select name="txt_unit" id="unit_name"class="form-select ">
                    <option value=""  class="text-wrap"selected hidden>----- ระดับผู้ใช้งาน --------</option>
                  </select>
                  </div>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"   value="" placeholder="เบอร์โทร"  >
                  </div>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"   value="" placeholder="ID Line"  >
                  </div>
              </div>
              
              <div class="mb-4  g-4 text-center">    
                <input type="submit" name="register" class="btn btn-success" value="Register">
                <a href="register.php" class="btn btn-danger">Reset</a>
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

   
   <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
   <script src="../node_modules/jquery/dist/cdn_popper.js"></script>
   <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
