<?php 
include('../database/db.php');
if (!isset($_SESSION['user_login'])) {
                header("location:../login.php");
            }
            $id = $_SESSION['user_login'];
            $select_session = $db->prepare("SELECT * FROM user INNER JOIN level ON user.user_lv = level.level_id  
            INNER JOIN branch ON user.user_bn = branch.bn_id 
             WHERE user_id = :uid");
            $select_session->execute(array(':uid' => $id));
            $row_session = $select_session->fetch(PDO::FETCH_ASSOC);
            extract($row_session);
            if (isset($_SESSION['user_login'])) {
  ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light nav-fixed-top" role="navigation">
    <div class="container-fluid">
            <div class="img-resize"><a href="../index.php"><img class="rounded float-start"
                        src="../components/images/logo.png"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    aria-label="Toggle navigation"></button>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ">
                <li class="nav-item dropdown ms-2">
                        <a class="nav-link" href="../index.php" role="button" aria-expanded="false">
                            หน้าหลัก
                        </a>
                    </li>

                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            จัดการการคลัง
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="../data-stock/pivot_list_stock_all.php">คลังรวม</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../data-stock/list_stock_branch.php">คลังสาขา</a></li>

                  

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../data-stock/list_stock_center.php">คลังส่วนกลาง</a></li>
                            
                        </ul>
                    </li>
                    <?php
if ($row_session['user_lv'] >= 2) {
        ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            จัดการรายการคงคลัง
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if ($row_session['user_lv'] >= 3) {?>
                        <li><a class="dropdown-item" href="../data-stock/stock_main.php">จัดการรายการคลังหลัก</a>
                        </li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="../data-stock/stock.php">จัดการรายการใหม่-2</a></li>
                        <li><a class="dropdown-item" href="../data-stock/item.php">จัดการรายการใหม่-1</a></li>
                        <?php if ($row_session['user_lv'] >= 2) {?>
                        <li>
                            <hr class="dropdown-divider"><a>(กระบวการจัดเตรียมข้อมูล)</a>
                        </li>
                        <?php if ($row_session['user_lv'] >= 4) {?>
                        <li><a class="dropdown-item" href="../data-stock/set_branch.php">จัดรายการ-สาขา</a></li>
                        <li><a class="dropdown-item" href="../data-stock/set_type_item.php">จัดการ-ประเภท</a></li>
                        <li><a class="dropdown-item" href="../data-stock/set_nature.php">จัดการ-ลักษณะ</a></li>
                        <li><a class="dropdown-item" href="../data-stock/set_division.php">จัดการ-แผนก</a></li>
                        <?php }?>
                        <li><a class="dropdown-item" href="../data-stock/vendor.php">จัดการ-ผู้ขาย</a></li>
                        <li><a class="dropdown-item" href="../data-stock/unit.php">จัดการ-หน่วย</a></li>
                        <li><a class="dropdown-item" href="../data-stock/set_marque.php">จัดการ-ยี่ห้อ</a></li>
                        
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

                            <li><a class="dropdown-item" href="../data-user/user_center.php">สมาชิกศูนย์</a></li>
                            <li><a class="dropdown-item" href="../data-user/user_bn.php">สมาชิกสาขา</a></li>
                            <?php if ($row_session['user_lv'] >= 2) {?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../data-user/register.php">เพิ่มผู้ใช้งาน</a></li>
                            <?php if($row_session['user_lv'] >= 5){?>
                            <li><a class="dropdown-item" href="../data-user/resetpassword.php">รีเซ็ตรหัสผ่าน</a></li>
                            <?php } ?>
                            <?php }?>
                        </ul>
                    </li>

                    <li class="nav-item-end dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">ตั้งค่า</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="../data-user/user_profile.php">แก้ไขข้อมูลส่วนตัว</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="nav-item me-2 ">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">คุณ :
                    <?php echo $row_session['user_fname']; ?> <?php echo $row_session['user_lname']; ?> |
                    สถานะ :
                    <?php echo $row_session['level_name']; ?> สาขา :
                    <?php echo $row_session['bn_name'];} ?></a>
            </div>
            <div class="nav-item fixed-relative">
            <button type="button" class="btn btn-danger"><a  href="../logout.php" class="text-light">Logout</a></button>
            </div>
        </nav>
