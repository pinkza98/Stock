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
    <!-- <==========================================booystrap 5==================================================> -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <==========================================booystrap 5==================================================> -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/bootstrap@4.5.0/dist/css/bootstrap.min.css" > -->
    <script src="https://kit.fontawesome.com/43df76ab35.js" crossorigin="anonymous"></script>
    <script src="../node_modules/jquery/dist/jquery.js"></script>
    <!-- <==========================================data-teble==================================================> -->
    <script src="../node_modules/data-table/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../node_modules/data-table/datatables.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
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
        <div class="display-3 text-xl-center mt-3">
            <H2>ตั้งค่าความถี่ stock สาขา </H2>
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
    <div class="m-4">
    <button class="btn btn-yellow btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    คำอธิบาย
  </button>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
   <p>
    ความถี่stock<br>
      - >สิทธิ์การใช้<a>สำหรับ จัดซื้อและ ตำแหน่งผู้จัดการเขต ขึ้นไปถึงจะสามารถใช้สิทธิ์ หน้านี้ได้  <br>
      - >ความถี่ stock คือ<a> นำข้อมูลจำนวนวันไปใช้ในตาราง pivot สาขาเพื่อแจ้งเตือนรายการสินค้านั้นให้สาขาตรวจเช็ครายการที่เกินกำหนดความถี่ที่กำหนดไว้  <br>
      #หากไม่มีรายการในนี้ให้ตรวจเช็ค ความสมบูรณ์ของ รายการใน master file ก่อน ถ้ารายการสมบูรณ์แล้ว จะปรากฏรายการให้เพิ่มข้อมูล
     

</p>
  </div>
</div>
    </div>
    <div  class="tableFixHead"style ="width:1900; word-wrap: break-word">
        <br>
        <form name="add_name" id="add_name" method="POST">
        <table class="table table-hover text-center m-2 " id="stock_piq">
            <thead class="table-dark">
                <tr style="font-size:12px;">
                    <th class="text-center ">No.</th>
                    <th class="text-center ">รหัส</th>
                    <th class="text-center ">รายการ</th>
                    <th class="text-center ">หน่วย</th>
                    <th class="text-center ">ผู้ขาย</th>
                    <th class="text-center ">ราคา</th>
                    <th class="text-center ">ความถี่/วัน</th>
                    
                </tr>
                </thead>
                <tbody class="table-light">
                <?php 
                $select_pivot_bn = $db->prepare("SELECT
                stock_id,it.code_item,unit_name,item_name,v.vendor_name,price_stock,date_off
                FROM stock s
                INNER JOIN vendor v  on s.vendor_id = v.vendor_id
                INNER JOIN item it  on s.item_id = it.item_id
                INNER JOIN unit u  on it.unit_id = u.unit_id
                GROUP BY it.item_id
                ");
                $select_pivot_bn->execute();
               
                while ($row = $select_pivot_bn->fetch(PDO::FETCH_ASSOC)) {
                ?>
        
                <tr class="table-light " style="font-size:12px;">
                    <td class="text-center"><?php echo $row['stock_id']; ?></td>
                    <td class="text-center"><?php echo $row['code_item'];?></td>
                    <td class="text-left"><?php echo $row['item_name'];?></td>
                    <td class="text-center"><?php echo $row['unit_name'];?></td>
                    <td class="text-center"><?php echo $row['vendor_name'];?></td>
                    <td class="text-center"><?php echo $row['price_stock'];?></td>        
                    <td class="col-1" ><input type="number" class="form-control text-center " name="date_off[]" value="<?php echo $row['date_off']?>"></td>
                    <input type="hidden" name="stock_id[]" value="<?php echo $row['stock_id'];?>"> 
                </tr>
                <?php } ?>
                
                
            </tbody>
        </table>
            <input type="submit"  name="submit" id="submit" class="btn btn-success" value="update" />
            <input type="submit" href="stock_piq.php" class="btn btn-primary"value="Reset"/>
        </form>
</div>
<script type="text/javascript">
$(document).ready(function() {
$('#submit').click(function(e) {
        var data_add = $('#add_name').serialize(); 
        $.ajax({
            url: "stock_piq_db.php",
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
<?php if($row_session['user_lv']==1){?>
    <script>
        var table = $('#stock_piq').DataTable({
            "lengthMenu": true,
            "searching": true,
            "paging": false
        });

    </script>
    <?php }else{?>
        <script>
         
    // Setup - add a text input to each footer cell
    // DataTable
    var table = $('#stock_piq').DataTable({
        dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
          "lengthMenu": true,
          "searching": true,
          "paging": false
    });
    </script>
      <?php }?>
