<!-- หน้ากำหนดเมนูใหญ่ จาก data-user ให้เข้าเมนู อื่นๆ ได้ถูกต้อง -->
<?php 
include_once('../database/db.php'); //เชื่อมต่อไฟล์ ฐานข้อมูล
if (!isset($_SESSION['user_login'])) { //ถ้าไม่เท่ากับไฟล์ user_login ไม่มีค่าสมาชิกจะไปหน้า login
                header("location:../login");
            }

            $id = $_SESSION['user_login']; //เก็บค่าตัวแปรจาก user_login ไว้ในตัวแปร $id

            $select_session = $db->prepare("SELECT * FROM user INNER JOIN level ON user.user_lv = level.level_id  INNER JOIN branch ON user.user_bn = branch.bn_id WHERE user_id = :uid");
            $select_session->execute(array(':uid' => $id)); // ทำการดึงค่า id ออกมาจากตาราง user เพื่อเช็คว่ามีค่าอยู่ในตาราง user หรือไม่
            $row_session = $select_session->fetch(PDO::FETCH_ASSOC);
            extract($row_session);
            if (isset($_SESSION['user_login'])) { //ถ้า user_login เป็นจริง ให้เข้ามาทำงานในส่วน tag เมนู ด้านล่าง
  ?>


<nav class="navbar navbar-expand-lg navbar-light bg-light nav-fixed-top" role="navigation">
    <div class="container-fluid">
            <div class="img-resize "><a href="../index"><img class="rounded float-start"
                        src="../components/images/logo.png"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    aria-label="Toggle navigation"></button>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ">
                    <li class="nav-item dropdown ms-2">
                            <a class="nav-link" href="../index" role="button" aria-expanded="false">
                                หน้าหลัก
                            </a>
                    </li>

                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            จัดการการคลัง
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="../data-stock/pivot_list_stock_all">คลังรวม</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../data-stock/stock_branch_pivot">คลังสาขา</a></li>

    
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../data-stock/pivot_pick_up_stock_all">คลังส่วนกลาง</a></li>
                           
                        </ul>
                    </li>
                    <?php
if ($row_session['user_lv'] >= 2) { //กำหนดสิทธิ์การเข้าหน้าจัดการสินค้า โดยที่ user bn >= ขึ้นไป
        ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            จัดการรายการคงคลัง
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <!-- รายการจัดการรายการคงคลัง ให้ user AM ขึ้นไปเข้ามาใช้งานในส่วนนี้  -->
                        <?php if ($row_session['user_lv'] >= 3) {?> 
                        <li><a class="dropdown-item" href="../data-stock/stock_main">จัดการรายการคลังหลัก</a>
                        </li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="../data-stock/stock">จัดการรายการใหม่-2</a></li>
                        <li><a class="dropdown-item" href="../data-stock/item">จัดการรายการใหม่-1</a></li>
                                   <!-- รายการจัดการรายการคงคลัง ให้ user bm ขึ้นไปเข้ามาใช้งานในส่วนนี้  -->
                        <?php if ($row_session['user_lv'] >= 2) {?>
                        <li>
                            <hr class="dropdown-divider"><a>(กระบวการจัดเตรียมข้อมูล)</a>
                        </li>
                                   <!-- รายการจัดการรายการคงคลัง ให้ user CEO or Admin ขึ้นไปเข้ามาใช้งานในส่วนนี้  -->
                        <?php if ($row_session['user_lv'] >= 4) {?>
                        <li><a class="dropdown-item" href="../data-stock/set_branch">จัดรายการ-สาขา</a></li>
                        <li><a class="dropdown-item" href="../data-stock/set_type_item">จัดการ-ประเภท</a></li>
                        <li><a class="dropdown-item" href="../data-stock/set_nature">จัดการ-ลักษณะ</a></li>
                        <li><a class="dropdown-item" href="../data-stock/set_division">จัดการ-แผนก</a></li>
                        <?php }?>
                        <li><a class="dropdown-item" href="../data-stock/vendor">จัดการ-ผู้ขาย</a></li>
                        <li><a class="dropdown-item" href="../data-stock/unit">จัดการ-หน่วย</a></li>
                        <li><a class="dropdown-item" href="../data-stock/set_marque">จัดการ-ยี่ห้อ</a></li>
                        
                        <?php }?>
                    </ul>
                    </li>
                    <?php }?>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">ระบบ คลัง</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">|</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            ตั้งค่าสมาชิก
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <li><a class="dropdown-item" href="../data-user/user_center">สมาชิกศูนย์</a></li>
                            <li><a class="dropdown-item" href="../data-user/user_bn">สมาชิกสาขา</a></li>
                                       <!-- รายการจัดการรายการคงคลัง ให้ user admin ขึ้นไปเข้ามาใช้งานในส่วนนี้  -->
                            <?php if($row_session['user_lv'] >= 5){?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../data-user/register">เพิ่มผู้ใช้งาน</a></li>
                            <li><a class="dropdown-item" href="../data-user/resetpassword">รีเซ็ตรหัสผ่าน</a></li>
                            <li><a class="dropdown-item" href="../data-user/ui_run_scrip">Run Script</a></li>
                            <li><a class="dropdown-item" href="../data-user/set_meber">ตั้งค่าสมาชิก</a></li>
                            <?php }?>
                        </ul>
                    </li>

                    <li class="nav-item-end dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">ตั้งค่า</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="../data-user/user_profile">แก้ไขข้อมูลส่วนตัว</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="nav-item me-6 ">
<!-- การแสดงข้อมูลส่วนตัว ใน tab menu แสดง ชื่อ สถานะ สาขา และเครดิตที่มี  -->
            <a class="nav-link disabled" 
                aria-disabled="true">คุณ :
                <?php echo $row_session['user_fname']; ?> <?php echo $row_session['user_lname']; ?> |
                สถานะ :
                <?php echo $row_session['level_name']; ?> สาขา :
                <?php echo $row_session['bn_name'];  ?>
                | เครดิต :
                <?php echo number_format($row_session['credit']);}?></a>
        </div>
            <div class="nav-item fixed-relative">
            <button type="button" class="btn btn-danger"><a  href="../logout" class="text-light">Logout</a></button>
            </div>
        </nav>
   