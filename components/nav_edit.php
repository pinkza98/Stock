<?php include_once('../../database/db.php')  ;
      if (!isset($_SESSION['user_login'])) {
        header("location:login.php");
    }
    $id = $_SESSION['user_login'];

    $select_stmt = $db->prepare("SELECT * FROM user INNER JOIN level ON user.user_lv = level.level_id  INNER JOIN branch ON user.user_bn = branch.bn_id  WHERE user_id = :uid");
    $select_stmt->execute(array(':uid' => $id));
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
    if (isset($_SESSION['user_login'])) {
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <div class="img-resize"><a class="navbar-brand" href="#"><img src="../../components/images/logo.png" ></a></div>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../../index.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              จัดการการคลัง
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">คลังรวม</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="data-stock/stock_branch.php">คลังสาขา</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">คลังศูนย์</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            จัดการรายการคงคลัง
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="../stock.php">จัดรายการ คลัง</a></li>
              <li><a class="dropdown-item" href="data-stock/set_branch.php">จัดรายการ สาขา</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="../item.php">จัดการรายชื่อรายการ</a></li>
              <li><a class="dropdown-item" href="../vendor.php">จัดการvendor</a></li>
              <li><a class="dropdown-item" href="../unit.php">จัดการหน่วยสินค้า</a></li>
            </ul>
          </li>
          
          <li class="nav-item" >
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">ระบบ คลัง</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              ตั้งค่าสมาชิก
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">สมาชิกศูนย์</a></li>
              <li><a class="dropdown-item" href="#">สมาชิกสาขา</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="../../data-user/register.php">เพิ่มผู้ใช้งาน</a></li>
            </ul>
          </li>
          <li class="nav-item" >
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">|</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              ตั้งค่า
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">แก้ไขข้อมูลส่วนตัว</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">ออกจากระบบ</a></li>
            </ul>
          </li>
          <li class="nav-item" >
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">คุณ <?php echo $row['user_fname']; ?>  <?php echo $row['user_lname'];?> | สถานะ : <?php echo $row['level_name']; ?> สาขา : <?php echo $row['bn_name']; }?></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <br>