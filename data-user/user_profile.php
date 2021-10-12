<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['img_up'])) {
        
        $user_id = $_REQUEST['txt_user_id'];
        
        $image_file = $_FILES['txt_file']['name'];  
        $type = $_FILES['txt_file']['type'];
        $size = $_FILES['txt_file']['size'];
        $temp = $_FILES['txt_file']['tmp_name'];
        
            $select_stmt = $db->prepare('SELECT * FROM user WHERE user_id = :id');
            $select_stmt->bindParam(":id", $user_id);
            $select_stmt->execute();
            $row_session1 = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row_session1);

            $path = "img_user/". $image_file; //
            $directory = "img_user/"; 
        if($image_file){
            if (!empty($image_file)) {
                if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
                    if (!file_exists($path)) { // check file not exist in your upload folder path
                        if ($size < 10000000) { 
                            unlink($directory.$row_session1['user_img']);// check file size 5MB
                            move_uploaded_file($temp, 'img_user/'.$image_file); // move upload file temperory directory to your upload folder
                        } else {
                            $errorMsg = "รองรับขนาดของรูปภาพ ไม่เกิน 5MB"; // error message file size larger than 5mb
                        }
                    } else {
                        $errorMsg = "ไฟล์อัพโหลดปลายทาง ไม่มีอยู่จริง! โปรดตรวจสอบ Folder"; // error message file not exists your upload folder path
                    }
                } else {
                    $errorMsg = "ไฟล์รูปภาพที่ อัพโหลดรองรับเฉพาะนามสกุลไฟล์ JPG,JPEG,PNG และ Git เท่านั้น ";
                }
            }
          }else{
            $image_file = $row_session1['user_img'];
          } 
              try {
            if (!isset($errorMsg)) {
                $update_stmt = $db->prepare("UPDATE user SET user_img = :new_user_img  WHERE user_id = :super_user_id");
                $update_stmt->bindParam(':super_user_id', $user_id);
                $update_stmt->bindParam(':new_user_img', $image_file);
                if ($update_stmt->execute()) {
                    $insertMsg = "เพิ่มข้อมูลสำเร็จ.......";
                    header("refresh:1;user_profile.php");
                }
            }
        } catch (PDOException $e) {
             $e->getMessage();
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
    <!------ Include the above in your HEAD tag ---------->
</head>

<body>
    <?php include('../components/nav_user.php'); ?>
    </header>


    <?php include('../components/content.php')?>

    <header>
        <div class="container text-center mt-5">
            <h2>ข้อมูลส่วนตัว</h2>
        </div>
    </header>
    <hr>

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
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-4">
                <div class="container">
                    <?php 
                        if($row_session['user_img']==''){
                            ?>
                    <img class="rounded mx-auto d-block" src="img_user/user_img.png" max-width:100% height="250" />
                    <?php
                        }else{
                            ?>
                    <img class="rounded mx-auto d-block" src="img_user/<?= $row_session['user_img']?>" max-width:100%
                        height="250" />
                    <?php
                        }
                        ?>
                    <hr>
                    <form method="post" enctype='multipart/form-data'>
                        <input type="file" name='txt_file' class="form-control mt-4" id="customFile" multiple />
                        <input type="text" name="txt_user_id" value="<?= $row_session['user_id'];?>> " hidden="true">
                        <button class="control-button btn btn-outline-dark mt-2" name="img_up">เปลี่ยน</button>
                    </form>

                </div>
            </div>
            <div class="col-md-6">
                <div class="tab-content profile-tab" id="myTabContent">
                    <h5>
                        ชื่อ-สกุล 
                        <?php echo $row_session['user_fname']; ?> <?php echo $row_session['user_lname']; ?>
                    </h5>
                    <h6>
                        สาขา : <?php echo $row_session['bn_name'] ?>
                    </h6>
                    <p class="proile-rating">ตำแหน่ง : <span><?php echo $row_session['level_name'] ?> </span></p>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <label class="mb-3 mt-2 text-border-1">ข้อมูลติดต่อ</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>E-mail</label>
                                    </div>
                                    <div class="col-md-4">
                                        <p> <?php echo $row_session['username'] ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>TelePhone</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $row_session['user_tel'] ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>ID Line</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $row_session['user_line'] ?></p>
                                    </div>
                                    <hr>
                                    <div class="row md-6 pt-4">
                                        <button class="btn btn-outline-dark" /><a
                                            href="edit/user_repassword.php ">เปลี่ยนรหัสผ่าน</a></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-dark" /><a
                    href="edit/user_profile_edit.php">แก้ไขข้อมูลติดต่อ</a> </button></a>
            </div>
        </div>

    </div>

    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>