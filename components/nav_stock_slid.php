<!-- หน้ากำหนดเมนูเข้าส่วนกลาง -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="collapse navbar-collapse " id="navbarTogglerDemo03">
        <ul class="navbar-nav nav-table-striped">
            <!-- <li class="nav-item">
                <a class="nav-link " href="stock_center.php">
                    <button class="btn btn-success">สต๊อก/เบิก คลังสาขา
                    </button>
                </a>
            </li> -->
            <!-- <li class="nav-item ">
                <a class="nav-link" href="reconcile.php">
                    <button class="btn btn-warning">
                        ปรับยอด 
                    </button>
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="list_stock_center.php">
                    <button class="btn btn-primary">
                        รายการรวม
                    </button>
                </a>
            </li> -->
            <!-- <li class="nav-item ">
                <a class="nav-link" href="sub_list_stock_center.php">
                    <button class="btn btn-primary">
                        รายการแยกส่วน
                    </button>
                </a>
            </li> -->
            <!-- <li class="nav-item ">
                <a class="nav-link" href="list_pick_up_center.php">
                    <button class="btn btn-primary">
                        รายการเบิกคลังส่วนกลาง 
                    </button>
                </a>
            </li> -->
            <li class="nav-item ">
                <a class="nav-link" href="pivot_pick_up_stock_all">
                    <button class="btn btn-primary">
                        รายการ Pivot เบิกรวม 
                    </button>
                </a>
            </li>
            <?php if($row_session['user_lv'] >=3|| $row_session['user_bn'] == 1){?>
            <li class="nav-item ">
                <a class="nav-link" href="stock_piq">
                    <button class="btn btn-primary">
                        ตั้งค่าความถี่ stock
                    </button>
                </a>
            </li>
            <?php } ?>
            <li class="nav-item ">
                <a class="nav-link" href="stock_po_center">
                    <button class="btn btn-primary">
                        รายการสั่งซื้อ
                    </button>
                </a>
            </li>
            <?php if($row_session['user_lv'] >=3){ ?>
            <li class="nav-item ">
                <a class="nav-link" href="https://youtu.be/DmRuT9S9EN0">
                    <button class="btn btn-danger">
                        คลิปสอนใช้งานปรับยอดสั่งซื้อ(สำหรับAM) 
                    </button>
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
</nav>