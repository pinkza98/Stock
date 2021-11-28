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
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> --> 
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
            <H2>PIVOT สต๊อกคลังสาขา : <?php echo $row_session['bn_name']; ?> </H2>
        </div>
    </header>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col">
            <?php include('../components/nav_stock_sild_bn.php'); ?>
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
     สีของรายการ<br>
      - <a  style="color:#00A00F">สีเขียวคือ<a> รายการมีการอัพเดทภายใน 15 วัน <br>
      - <a  style="color:#ECD532">สีเหลืองคือ<a> รายการมีการอัพเดทผ่านมาแล้ว 15 วัน <br>
      - <a  style="color:#BB3711">สีแดงคือ<a> เมื่อมีรายการส่ง-รับ โอนล่าสุดให้ตรวจเช็คยอดในคลังให้ถูกต้อง หรือ รายการไม่มีการตรวจใช้นานแล้ว <br>
      #หมายเหตุการปรับยอดจะนับจำนวนที่มีจากเดิมก่อนหน้านี้เพิ่มเก็บลงประวัติจำนวนล่าสุด
    </ฟ>
  </div>
</div>
    </div>
    <div  class="tableFixHead"style ="width:1900; word-wrap: break-word">
        <br>
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
                    <th class="text-center">ธุระกรรม</th>
                    <th class="text-center">จำนวน</th>
                    <th class="text-center">ผู้ดำเนินการ</th>
                    <th class="text-center">วันที่อัพเดท</th>
                    <th class="text-center">สถานะ</th>
                    <th class="text-center">จำนวน</th>
                    <th class="text-center">เวลาส่ง/รับ(โอน)</th>
                    <th class="text-center">ปรับยอด</th>
                    
                </tr>
                </thead>
                <tbody class="table-light">
                <?php 
                $select_pivot_bn = $db->prepare("SELECT
                bn.stock_id,it.code_item,unit_name,item_name,v.vendor_name,price_stock,transaction_update,quantity_update,name_update,datetime_update,transfer_date,transfer_status,transfer_quantity,
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
                $today = date('Y-m-d H:i:s');
                $tomorrow = strtotime($today);
                $No = 1;
                while ($row = $select_pivot_bn->fetch(PDO::FETCH_ASSOC)) {
                    $date_stock = strtotime($row['datetime_update']." +15 day");
                    $date_transfer = strtotime($row['transfer_date']);
                    $date_stock_update = strtotime($row['datetime_update']);
                ?>
                
                <tr class="table-light" style="font-size:12px;">
                    <td class="text-center"><?php echo $No ?></td>
                    <td class="text-center"><?php echo $row['code_item'];?></td>
                    <td class="text-left"><?php echo $row['item_name'];?></td>
                    <td class="text-center"><?php echo $row['unit_name'];?></td>
                    <td class="text-center"><?php echo $row['vendor_name'];?></td>
                    <td class="text-center"><?php echo $row['price_stock'];?></td>
                    <?php 
                    if($date_transfer >= $date_stock_update ){?>
                    <td class="text-center" style="background-color: #BB3711;color:#fff"><?php echo $row['BN_stock'];?></td>
                    <?php if($row['transaction_update']!=null){?>
                    <td class="text-center"><?php echo $row['transaction_update'];?></td>
                    <td class="text-center"><?php echo $row['quantity_update'];?></td>
                    <td class="text-center"><?php echo $row['name_update'];?></td>
                    <td class="text-center"><?php echo DateThai($row['datetime_update']);?></td>
                    <?php }else{ ?>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <?php } ?>
                    <?php if($row['transfer_status']!=null) {?>
                    <td class="text-center"><?php echo $row['transfer_status'];?></td>
                    <td class="text-center"><?php echo $row['transfer_quantity'];?></td>
                    <td class="text-center"><?php echo DateThai($row['transfer_date']);?></td>
                    <?php }else{ ?>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <?php } ?>
                    <td><button type="submit" class="btn btn-success data_id" onclick="submitResult(event)" id=<?php echo $row['stock_id'] ?>><i class="fas fa-edit fa-1x" style="color:#fff"></i></button></td>
                   <?php }else{ 
                    if($date_stock >= $tomorrow and $row['quantity_update'] !=null){?>
                    <td class="text-center" style="background-color: #00A00F;color:#fff"><?php echo $row['BN_stock'];?></td>
                    <td class="text-center"><?php echo $row['transaction_update'];?></td>
                    <td class="text-center"><?php echo $row['quantity_update'];?></td>
                    <td class="text-center"><?php echo $row['name_update'];?></td>
                    <td class="text-center"><?php echo DateThai($row['datetime_update']);?></td>
                    <?php if($row['transfer_status']!=null) {?>
                    <td class="text-center"><?php echo $row['transfer_status'];?></td>
                    <td class="text-center"><?php echo $row['transfer_quantity'];?></td>
                    <td class="text-center"><?php echo DateThai($row['transfer_date']);?></td>
                    <?php }else{ ?>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <?PHP } ?>
                    <td><button type="submit" class="btn btn-success data_id" onclick="submitResult(event)" id=<?php echo $row['stock_id'] ?>><i class="fas fa-edit fa-1x" style="color:#fff"></i></button></td>
                
                    <?php }else{?>
                        <td class="text-center" style="background-color: #ECD532;color:#090909"><?php echo $row['BN_stock'];?></td>
                    <td class="text-center"><?php echo $row['transaction_update'];?></td>
                    <td class="text-center" ><?php echo $row['quantity_update'];?></td>
                    <td class="text-center" ><?php echo $row['name_update'];?></td>
                    <td class="text-center"><?php echo DateThai($row['datetime_update']);?></td>
                    <?php if($row['transfer_status']!=null) {?>
                    <td class="text-center"><?php echo $row['transfer_status'];?></td>
                    <td class="text-center"><?php echo $row['transfer_quantity'];?></td>
                    <td class="text-center"><?php echo DateThai($row['transfer_date']);?></td>
                    <?php }else{ ?>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <?PHP } ?>
                    <td><button type="submit" class="btn btn-warning data_id" onclick="submitResult(event)" id=<?php echo $row['stock_id'] ?>><i class="fas fa-edit fa-1x" style="color:#fff"></i></button></td>
                    <?php } ?>
                   <?php  } ?>
                   
                </tr>
                <?php $No++; } ?>
            </tbody>
        </table>
    </div>
<?php $user_name = $row_session['user_fname'].$row_session['user_lname']; 
    $user_bn = $row_session['user_bn'];

?>
<script type="text/javascript" >
 function submitResult(e) {
        $('.data_id').click(function(){ 
        Swal.fire({
        title: "ปรับยอดรายการ",
        text: "<?PHP echo $user_name; ?>",
        icon:'warning',
        input: 'number',
        inputPlaceholder: 'ใส่ตัวเลขที่ต้องการปรับยอด',
        showCancelButton: true        
        }).then((result) => {
            if (result.value) {
                 new_sum = result.value;
            var stock_id=$(this).attr("id");
            var user_name = "<?php echo $user_name ?>"
            var user_bn = "<?php echo $user_bn ?>"
            
                $.ajax({
                    url:"pivot_update_bn.php",
                    method:"POST",
                    data:{stock_id:stock_id,new_sum:new_sum,user_name:user_name,user_bn:user_bn},
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

</script>
</body>
</html>

<?php if($row_session['user_lv']==1){?>
    <script>
    

        var table = $('#stock_po').DataTable({
            "lengthMenu": false,
            "searching": true,
            "paging": false
        });

    </script>
    <?php }else{?>
        <script>
         
    // Setup - add a text input to each footer cell
    // DataTable
    var table = $('#stock_po').DataTable({
        dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
          "lengthMenu": false,
          "searching": true,
          "paging": false
    });
    </script>
      <?php }?>
      <?php 
function DateThai($strDate)
{
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));
    $strHour= date("H",strtotime($strDate));
    $strMinute= date("i",strtotime($strDate));
    $strSeconds= date("s",strtotime($strDate));
    
    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}
?>