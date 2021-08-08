<?php 
    require_once('../database/db.php');
    
    if (isset($_REQUEST['save'])) {
      $unit_name = $_REQUEST['txt_unit_name'];
    
      $select_stmt = $db->prepare("SELECT * FROM unit WHERE unit_name = :unit_name");
      $select_stmt->bindParam(':unit_name', $unit_name);
      $select_stmt->execute();
      if ($select_stmt->fetchColumn() > 0){
        $errorMsg = 'รายการ ไอเท็มซ้ำ!!!';
      }
     else {
          try {
              if (!isset($errorMsg)) {
                  $insert_stmt = $db->prepare("INSERT INTO unit (unit_name) VALUES (:unit_name)");
                  $insert_stmt->bindParam(':unit_name', $unit_name);
                 

                  if ($insert_stmt->execute()) {
                      $insertMsg = "Insert Successfully...";
                      header("refresh:1;unit.php");
                  }
              }
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
      }
  }

  
?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <title>Plus dental clinic</title>

    <?php include('../components/header.php');?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../components/images/tooth.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        id="bootstrap-css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.6/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <link href="bootstap_profile/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include('../components/nav_user.php'); ?>
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
    <div class="container emp-profile">
        <div class="container text-center">
            <h2>ข้อมูลส่วนตัว</h2>
        </div>
        <hr>
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog"
                            alt="" />
                        <hr>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5>
                         ชื่อ-สกุล   <?php echo $row_session['prefix_name']; ?>  <?php echo $row_session['user_fname']; ?> <?php echo $row_session['user_lname']; ?>
                        </h5>
                        <h6>
                         สาขา :  <?php echo $row_session['bn_name'] ?>
                        </h6>
                        <p class="proile-rating">ตำแหน่ง : <span><?php echo $row_session['level_name'] ?> </span></p>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">ข้อมูลติดต่อ</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <p>Plus Dental Clinic</p>
                        
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>E-mail</label>
                                </div>
                                <div class="col-md-4">
                                    <p> <?php echo $row_session['username'] ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>TelePhone</label>
                                </div>
                                <div class="col-md-6">
                                    <p><?php echo $row_session['user_tel'] ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>ID Line</label>
                                </div>
                                <div class="col-md-6">
                                    <p><?php echo $row_session['user_line'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/jquery/dist/cdn_popper.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>