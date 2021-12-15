<?php 
    require_once('../database/db.php');
    date_default_timezone_set("Asia/Bangkok");
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
    <!-- library ที่ใช้งาน ตามคาดหัวไว้ -->
    <!-- <==========================================booystrap 5==================================================> -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <==========================================fontawesome==================================================> -->
    <script src="https://kit.fontawesome.com/43df76ab35.js" crossorigin="anonymous"></script>
    <script src="../node_modules/jquery/dist/jquery.js"></script>
    <!-- <==========================================data-teble==================================================> -->
    <script src="../node_modules/data-table/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../node_modules/data-table/datatables.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
    <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <!-- <==========================================sweetalert2==================================================> -->
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <!-- <==========================================sweetalert2==================================================> -->

<!-- ดึงข้อมูลมาจาก header ที่ตั้งค่า css แล้ว -->
    <?php include('../components/header.php');?> 
    
</head>
<body>
    <!-- ดึงข้อมูลมาจาก header ที่ตั้งค่า css แล้ว -->
    <?php include('../components/nav_stock.php'); ?>
    
    <header>
        <div class="display-3 text-xl-center mt-3">
            <!-- ดึงข้อมูล session userมาใช้งาน แสดงชื่อสาขา -->
            <H2>ตั้งค่า min-max สาขา : <?php echo $row_session['bn_name']; ?> </H2>
        </div>
    </header>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col">
                <!-- ดึงเมนูสาขามาแแสดงใช้งาน -->
            <?php include('../components/nav_stock_sild_bn.php'); ?>
            </div>
        </div>
    </div>
    </header>
    <!-- ดึงเมนูคอนเทน มาใช้งาน -->
    <?php include('../components/content.php')?>
    <div class="m-4">
        <!-- ใช้งาน bootstrap ในฟังชั่น collapse เพื่อเพิ่มปุ่มแสดงข้อมูลตาม tag -->
    <button class="btn btn-yellow btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    คำอธิบาย
  </button>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
   <p>
    ค่า min-max<br>
      - <a  style="color:#00A00F">ค่า min<a> คือจำนวนขั้นต่ำที่มีไว้ใน stock สาขา  <br>
      - <a  style="color:blue">ค่า max<a> คือจำนวนสูงสุดที่ stock สาขา จะเก็บได้  <br>
      #รายการจะมีให้เพิ่มตามที่คลังสาขาเคยมีอยู่แล้ว ถ้าไม่มีรายการให้ไปสต๊อกคลังเพิ่มไว้ถึงจะมีรายการให้ เพิ่มค่า min-max ได้

</p>
  </div>
</div>
    </div>
    <!-- fix หัวเมนูให้ขยับตามเมาส์ ontop -->
    <div  class="tableFixHead"style ="width:1900; word-wrap: break-word">
        <br>
        <!-- ตั้งค่า id post ฟอร์ม ข้อมูลส่งออก -->
        <form name="add_name" id="add_name" method="POST"> 
            <!-- ตั้งค่า ข้อมูลตารางที่จะแสดงข้อมูล พร้อมกำหนดตำแหน่ง id ให้ data table เข้ามาทำงานในตารางถูกต้อง-->
        <table class="table table-hover text-center m-2 " id="stock_po">
            <thead class="table-dark">
                <tr style="font-size:12px;">
                    <th class="text-center ">No.</th>
                    <th class="text-center ">รหัส</th>
                    <th class="text-center ">รายการ</th>
                    <th class="text-center ">หน่วย</th>
                    <th class="text-center ">ผู้ขาย</th>
                    <th class="text-center ">ราคา</th>
                    <th class="text-center">คลัง</th>
                    <th class="text-center">ค่า min</th>
                    <th class="text-center">ค่า max</th>
                    
                </tr>
                </thead>
                <tbody class="table-light">
                <?php 
                //ดึงข้อมูลจากฐานข้อมูล BN_stock ตามuser สาขา
                $select_pivot_bn = $db->prepare("SELECT
                bn.stock_id,it.code_item,unit_name,item_name,v.vendor_name,price_stock,transaction_update,quantity_update,name_update,datetime_update,transfer_date,transfer_status,transfer_quantity,stock_min,stock_max,bn_stock,
                SUM(IF(bn_stock = ".$row_session['user_bn'].", item_quantity, 0)) AS BN_stock
                FROM branch_stock bn
                INNER JOIN stock s  on bn.stock_id = s.stock_id
                INNER JOIN vendor v  on s.vendor_id = v.vendor_id
                INNER JOIN item it  on s.item_id = it.item_id
                INNER JOIN unit u  on it.unit_id = u.unit_id
                INNER JOIN  branch_stock_log bsl  on bn.full_stock_id = bsl.full_stock_id_log
                WHERE bn.bn_stock = ".$row_session['user_bn']."
                GROUP BY it.item_id
                ");
                $select_pivot_bn->execute();
                //set ค่า no นับจำนวนรายการ
                $No = 1;
                //ลูปข้อมูลทั้งหมดที่ได้จากฐานข้อมูล
                while ($row = $select_pivot_bn->fetch(PDO::FETCH_ASSOC)) {
                ?>
        
                <tr class="table-light " style="font-size:12px;">
                    <td class="text-center"><?php echo $No ?></td>
                    <td class="text-center"><?php echo $row['code_item'];?></td>
                    <td class="text-left"><?php echo $row['item_name'];?></td>
                    <td class="text-center"><?php echo $row['unit_name'];?></td>
                    <td class="text-center"><?php echo $row['vendor_name'];?></td>
                    <td class="text-center"><?php echo $row['price_stock'];?></td>        
                    <td class="text-center"><?php echo $row['BN_stock'];?></td>   
                    <td class="col-1" ><input type="number" class="form-control text-center " name="sum_min[]" value="<?php echo $row['stock_min'] ?>"></td>
                    <td class="col-1" ><input type="number" class="form-control text-center " name="sum_max[]" value="<?php echo $row['stock_max'] ?>"></td>
                    <input type="hidden" name="stock_id[]" value="<?php echo $row['stock_id'];?>"> 
                    <input type="hidden" name="bn_stock[]" value="<?php echo $row['bn_stock'];?>"> 
                </tr>
                <?php $No++; } ?>
                
                
            </tbody>
        </table>
        <!-- ส่งข้อมูลถ้า กดปุ่มไปทำงานใน script -->
            <input type="submit"  name="submit" id="submit" class="btn btn-success" value="update" /> 
            <input type="submit" href="bn_min_max.php" class="btn btn-primary"value="Reset"/>
        </form>
</div>

    
<!-- รับข้อมูล จาก submit postส่งไปยังไฟล์คำนวน bn_min_max_db.php -->
<script type="text/javascript">
$(document).ready(function() {
$('#submit').click(function(e) {
        var data_add = $('#add_name').serialize(); 
        $.ajax({
            url: "bn_min_max_db.php",
            method: "POST",
            data: data_add,
            success: function(data) {
                // alert(data);
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
});
</script>
</body>
</html>
<!-- script เงือนไขการแสดงของ ตารางข้อมูลตาม script เงือนไข -->
<?php if($row_session['user_lv']==1){?>
    <script>
        var table = $('#stock_po').DataTable({
            "lengthMenu": [ [10,25, 50,100, -1], [10, 25, 50,100, "All"] ],
            "searching": true,
            "paging": false
        });

    </script>
    <?php }else{?>
        <script>
    var table = $('#stock_po').DataTable({
        dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
        ],
        "lengthMenu": [ [10,25, 50,100, -1], [10, 25, 50,100, "All"] ],
        "searching": true,
        "paging": false
    });
    </script>
      <?php }?>
