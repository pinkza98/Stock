<?php 
    require_once('../database/db.php');
    
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
    <header>
    <div class="container text-center mt-2">
            <h2>ข้อมูลส่วนตัว</h2>
        </div>
    </header>
        <hr>
        <form method="post">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <?php 
                        if($row_session['user_img']==''){
                            ?>
                        <img src="img_user/user_img.png" width="200 " height="200" alt="" />
                        <?php
                        }else{
                            ?>
                        <img src="img_user/<?= $row_session['user_img']?>" width="200 " height="200" />
                        <?php
                        }
                        ?>

                        <hr>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5>
                            ชื่อ-สกุล <?php echo $row_session['prefix_name']; ?>
                            <?php echo $row_session['user_fname']; ?> <?php echo $row_session['user_lname']; ?>
                        </h5>
                        <h6>
                            สาขา : <?php echo $row_session['bn_name'] ?>
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
                    <a href="user_profile_edit.php"></a> <button type="submit" class="btn btn-outline-dark"
                        name="btnAddMore" />Edit Profile</button></a>
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
                                <div class="col">
                                    
                                </div>
                                <div class="col md-12">
                                    <button class="btn btn-info">แก้ไข</button >
                                </div>
                            </div>
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

    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>