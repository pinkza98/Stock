<!-- หน้ากำหนดเมนูในการโอนย้ายสินค้าคลัง -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="collapse navbar-collapse " id="navbarTogglerDemo03">
        <ul class="navbar-nav nav-table-striped">
        <li class="nav-item">
                <a class="nav-link " href="transfer">
                    <button class="btn btn-success">โอนย้ายของไปยังสาขาอื่น
                    </button>
                </a>
            </li>
            <!-- กำหนดเฉพาะ ผู้จัดการสาขาขึ้นไปในการเข้ามาใช้งาน อนุมัติรายการสินค้าตาม เครดิตและสาขาของตัวเอง -->
           <?php  if($row_session['user_lv']>=2){ ?> 
           <li class="nav-item">
                <a class="nav-link " href="transfer_status">
                    <button class="btn btn-info">รายการรอ อนุมัติ
                    </button>
                </a>
            </li>
            <?php }?>
            <li class="nav-item ">
                <a class="nav-link" href="transfer_carry">
                    <button class="btn btn-warning">
                        รายการขนส่ง
                    </button>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="transfer_inventory_check">
                    <button class="btn btn-primary">
                        รายการรับโอน
                    </button>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="transfer_success">
                    <button class="btn btn-dark">
                        รายการโอนย้ายที่สำเร็จ
                    </button>
                </a>
            </li>
        </ul>
    </div>
</nav>