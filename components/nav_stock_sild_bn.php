<!-- หน้ากำหนดเมนูเข้าคลังสาขา -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="collapse navbar-collapse " id="navbarTogglerDemo03">
        <ul class="navbar-nav nav-table-striped">
            <li class="nav-item">
                <a class="nav-link " href="stock_center">
                    <button class="btn btn-success">สต๊อก/เบิก คลังสาขา
                    </button>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="reconcile">
                    <button class="btn btn-warning">
                        ปรับยอด 
                    </button>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="stock_branch_pivot">
                    <button class="btn btn-primary">
                        รายการ PIVOT สาขา
                    </button>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="list_stock_branch">
                    <button class="btn btn-primary">
                        รายการรวม
                    </button>
                </a>
            </li> -->
            <li class="nav-item ">
                <a class="nav-link" href="sub_list_stock_branch">
                    <button class="btn btn-primary">
                        รายการแยกส่วน
                    </button>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="list_pick_up_branch">
                    <button class="btn btn-primary">
                        รายการเบิกคลังสาขา 
                    </button>
                </a>
            </li>
            <?php if($row_session['user_lv']>=2){?>
            <li class="nav-item ">
                <a class="nav-link" href="bn_min_max">
                    <button class="btn btn-primary">
                        ตั้งค่า min-max สาขา 
                    </button>
                </a>
            </li>
            <?php } ?>
            <li class="nav-item ">
                <a class="nav-link" href="stock_bn_po">
                    <button class="btn btn-primary">
                        เพิ่มรายการเบิก
                    </button>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="https://www.youtube.com/watch?v=JwtyWYWe-PQ&ab_channel=PlusProgrammer1">
                    <button class="btn btn-danger">
                        วิธีใช้งานขอสั่ง Po
                    </button>
                </a>
            </li>
        </ul>
    </div>
</nav>