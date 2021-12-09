<?php 
    require_once('../database/db.php');
    if(isset($_POST['bn_id'])){
        $sel_bn =$bn_id_po = $_POST['bn_id'];
        $sel_id = $_POST['bn_id'];
        if($sel_bn == 1){
            $sel_bn = "cn";
        }elseif($sel_bn == 2){
            $sel_bn = "ra";
        }elseif($sel_bn == 3){
            $sel_bn = "ar";
        }elseif($sel_bn == 4){
            $sel_bn = "sa";
        }elseif($sel_bn == 5){
            $sel_bn = "as_1";
        }elseif($sel_bn == 6){
            $sel_bn = "on_1";
        }elseif($sel_bn == 7){
            $sel_bn = "ud";
        }elseif($sel_bn == 8){
            $sel_bn = "nw";
        }elseif($sel_bn == 9){
            $sel_bn = "cw";
        }elseif($sel_bn == 10){
            $sel_bn = "r2";
        }elseif($sel_bn == 11){
            $sel_bn = "lb";
        }elseif($sel_bn == 12){ 
            $sel_bn = "bk";
        }elseif($sel_bn == 13){
            $sel_bn = "hq";
        }

    }else{
        $sel_bn = "cn";
        $bn_id_po = 1;

    }
?>
<link rel="icon" type="image/png" href="../components/images/tooth.png" />
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <title>Plus dental clinic</title>
    <!-- <==========================================booystrap 5==================================================> -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <==========================================booystrap 5==================================================> -->
    <script src="https://kit.fontawesome.com/43df76ab35.js" crossorigin="anonymous"></script>
    <script src="../node_modules/jquery/dist/jquery.js"></script>
    <!-- <==========================================data-teble==================================================> -->
    <script src="../node_modules/data-table/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../node_modules/data-table/datatables.min.js"></script>
    <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <!-- <==========================================data-teble==================================================> -->
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <!-- <==========================================sweetalert2==================================================> -->
    <?php include('../components/header.php');?>
</head>
<body>
    <?php include('../components/nav_stock.php'); ?>
    <header>
        <div class="display-3 text-xl-center">
            <H2>รายการส่งออเดอร์ให้สาขา/แก้ยอดสั่งสาขา </H2>
        </div>
    </header>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col">
            <?php include('../components/nav_stock_slid.php'); ?>
            </div>
        </div>
    </div>
    </header>
    <?php include('../components/content.php')?>
    <form method="post">
        <div class="m-2">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="row g-2">
                                <div class="col-sm-6">
                                <?php 
                                        $select_bn = $db->prepare("SELECT * FROM branch ORDER BY bn_id DESC");
                                        $select_bn->execute();
                                        ?>
                                <select class="form-select mt-1" name="bn_id" id="bn_id">
                                <option value="<?php echo $bn_id_po ?>">เลือกสาขา</option>
                                    <?php  while ($row_bn = $select_bn->fetch(PDO::FETCH_ASSOC)) {?>
                                    <option value="<?php echo$row_bn['bn_id']?>"><?php echo$row_bn['bn_name']?>
                                    </option>
                                    <?php } ?>
                                </select>
                                </div>
                                <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary mt-1" id="btn_search">ค้นหา</button>
                                </div>
                            </div>
                    </div>
                    <br>
        </div>
                </form>
            <div class="display-3 text-xl-center">
                <?php 
                $select_bn= $db->prepare("SELECT * FROM branch WHERE bn_id = $bn_id_po");
                $select_bn->execute();
                $row_bn_po = $select_bn->fetch(PDO::FETCH_ASSOC);
                ?>
        <H2>รายการสั่งซื้อสาขา : <?php echo $row_bn_po['bn_name'] ?>(<?php echo $row_bn_po['bn_acronym'] ?>)</H2>
        </div>
    <div  class="tableFixHead"style ="width:1900; word-wrap: break-word">
        <br>
        <form name="name="add_name" id="add_name" method="POST">
        <table class="table table-hover text-center m-2 " id="stock">
            <thead class="table-dark">
                <tr>
                    <th class="text-center ">No.</th>
                    <th class="text-center ">รหัส</th>
                    <th class="text-center ">รายการ</th>
                    <th class="text-center ">หน่วย</th>
                    <th class="text-center ">ผู้ขาย</th>
                    <th class="text-center ">ราคา</th>
                    <th class="text-center ">จำนวนในคลังสาขา</th>
                    <th class="text-center ">จำนวนที่สั่ง</th>
                    <th class="text-center">มูลค่า</th>
                    <th class="text-center">ปรับยอดสั่ง</th>
                </tr>
            </thead>
            <tbody class="table-light">
                
                <?php
                $select_stock_po = $db->prepare("SELECT stock_po_id,branch_stock.stock_id,code_item,item_name,vendor_name,price_stock,unit_name,$sel_bn,SUM(IF(bn_stock = $bn_id_po, item_quantity, 0)) as sum_bn FROM stock_po 
                INNER JOIN stock ON stock.stock_id = stock_po.stock_po_id
                LEFT JOIN item ON  item.item_id  =stock.item_id
                LEFT JOIN unit ON item.unit_id = unit.unit_id  
                LEFT JOIN nature ON stock.nature_id = nature.nature_id   
                LEFT JOIN type_item ON stock.type_id = type_item.type_id
                LEFT JOIN vendor ON stock.vendor_id = vendor.vendor_id
                LEFT JOIN division ON stock.division_id = division.division_id
                LEFT JOIN marque ON stock.marque_id = marque.marque_id
                LEFT join  branch_stock on branch_stock.stock_id = stock_po.stock_po_id
                INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
                WHERE $sel_bn != 0
                GROUP BY stock_id
                ORDER BY code_item  ASC");
                $select_stock_po->execute();
                $sum_order = 0 ;
                $No = 1;
                while ($row_stock_po = $select_stock_po->fetch(PDO::FETCH_ASSOC)) {
                    $sum_order += $row_stock_po['price_stock']*$row_stock_po[$sel_bn];
                    $sum_po = $row_stock_po['price_stock']*$row_stock_po[$sel_bn];
                   
                ?>
                <tr>
                    <td><?php echo $No++ ?></td>
                    <td><?php echo $row_stock_po['code_item'] ?></td>
                    <td><?php echo $row_stock_po['item_name'] ?></td>
                    <td><?php echo $row_stock_po['unit_name'] ?></td>
                    <td><?php echo $row_stock_po['vendor_name'] ?></td>
                    <td><?php echo number_format($row_stock_po['price_stock']); ?></td>
                    <td style="background-color: #646CC0;color:#131E21"> <?php if($row_stock_po['sum_bn'] != 0){ echo $row_stock_po['sum_bn'];}else{ echo "-";}?></td>
                    <td ><?php echo $row_stock_po[$sel_bn] ?></td>
                    <input type="hidden" name="bn_po[]" value="<?php echo $sel_bn?>">
                    <input type="hidden" name="price[]" value="<?php echo $row_stock_po['price_stock'];?>">
                    <input type="hidden" name="sum_po[]" value="<?php echo $row_stock_po[$sel_bn];?>">
                    <input type="hidden" name="stock_po_id[]" value="<?php echo $row_stock_po['stock_po_id'];?>">
                    <input type="hidden" name="stock_bn[]" value="<?php echo $bn_id_po;?>">
                    <td style="background-color: #82E0AA;color:#21618C"><?php echo number_format($sum_po) ?> ฿</td>
                    <td><button type="button" class="btn btn-success data_id" onclick="submitResult(event)" id=<?php echo $row_stock_po['stock_po_id'] ?>><i class="fas fa-edit fa-1x" style="color:#fff"></i></button></td>
                </tr>
                <?php }?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center "></th>
                    <th class="text-center "></th>
                    <th class="text-center "></th>
                    <th class="text-center "></th>
                    <th class="text-center"></th>
                    <th class="text-center "></th>
                    <th class="text-center"></th>
                    <th class="text-center "></th>
                    <th class="text-center">รวมมูลค่าทั้งหมด</th>
                    <th class="text-center"><?php echo number_format($sum_order); ?> บาท</th>
                </tr>
            </tfoot>
        </table>
        <input type="submit"  name="submit" id="submit" class="btn btn-success" value="เคลียร์ข้อมูลส่งรอโอนย้าย" />
    </div>
   
    </form>

<script type="text/javascript" >
 function submitResult(e) {
        $('.data_id').click(function(){ 
        Swal.fire({
        title: "ปรับยอดรายการ",
        text: "<?PHP echo $row_session['user_fname'].$row_session['user_lname'];; ?>",
        icon:'warning',
        input: 'number',
        inputPlaceholder: 'ใส่ตัวเลขที่ต้องการปรับยอด',
        showCancelButton: true        
        }).then((result) => {
            if (result.value) {
                 new_sum = result.value;
            var stock_id=$(this).attr("id");
            var user_name = "<?php echo $row_session['user_fname'].$row_session['user_lname']; ?>"
            var user_bn = "<?php echo $sel_bn ?>"
            var status = "edit_stock_po";
                $.ajax({
                    url:"pivot_update_bn.php",
                    method:"POST",
                    data:{stock_id:stock_id,new_sum:new_sum,user_name:user_name,user_bn:user_bn,status:status},
                    success:function(data) {
                        if(data != false){
                            Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: data,
                            showConfirmButton: true,
                            timer: false
                            })
                            setTimeout(function(){
                            window.location.reload(1);
                            }, 2800);
                        }else{
                            Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: "มีรายการไม่ถูกต้อง!!",
                            showConfirmButton: false,
                            timer: 2200
                            })
                        }
                    }
                });
            }
        });
    });
}
$('#submit').click(function(e) {
        var data_add = $('#add_name').serialize(); 
        $.ajax({
            url: "stock_po_to_transfer_db.php",
            method: "POST",
            data: data_add,
            success: function(data) {
                if(data != false){
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: data,
                showConfirmButton: true,
                timer: false
                })
                setTimeout(function(){
                window.location.reload(1);
                }, 2800);
            }else{
                Swal.fire({
                position: 'center',
                icon: 'error',
                title: "มีรายการไม่ถูกต้อง!!",
                showConfirmButton: false,
                timer: 2200
                })
            }
            }
        });
        e.preventDefault();
    });
</script>
</body>
</html>
        <script>
    $(document).ready(function() {

        var table = $('#stock').DataTable({
            fixedHeader: {
                header: true
            },
            dom: 'lBfrtip',
            buttons: [
                'excel', 'print'
            ],
            "searching": true,
            "lengthChange": false,
            "paging": false
        });

    });
    </script>

