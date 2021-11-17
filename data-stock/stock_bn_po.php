<?php 
    include('../database/db.php');
   
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
    <?php include('../components/header.php');?>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../node_modules/jquery/dist/jquery.js"></script>
   <!-- <==========================================booystrap 5==================================================> -->
   <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
   <!-- <==========================================data-teble==================================================> -->
 <script type="text/javascript" src="../node_modules/data-table/jquery-table-2.min.js"></script>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">     -->
   <!-- <link rel="stylesheet" href="../node_modules/data-table/dataTables.bootstrap.min.css" />  -->
  <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<!-- <==========================================data-teble==================================================> -->
</head>
<body>
    <?php include('../components/nav_stock.php'); ?>
    <header>
        <div class="display-3 text-xl-center mt-3">
            <H2>เพิ่มรายการสั่งซื้อของสาขา</H2>
        </div>
    </header>
    <hr><br>
    <?php include('../components/content.php')?>
    <div class="container">
        <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger mb-2">
            <strong>คำเตือน! <?php echo $errorMsg; ?></strong>
        </div>
        <?php } ?>
        <?php 
        if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success mb-2">
            <strong>เยี่ยม! <?php echo $insertMsg; ?></strong>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
            <div class="card text-white bg-secondary mb-3" style="max-width: 29rem;">
                <div class="card-header">
                    <h4 class="card-title">update สั่งซื้อ PO ของสาขา :  <?php echo $row_session['bn_name'] ?></h4>
                </div>
            </div>
                <form id="list_item" name="list_item">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-select mb-2 mt-2" name="status" id="status"  hidden>
                                    <option value="add_po">update เพิ่มรายการสั่งซื้อ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                </form>
                <?php 
                if($row_session['bn_id']==1){
                    $bn_id = "cn";
                }elseif($row_session['bn_id']==2){
                    $bn_id = "ra";
                }elseif($row_session['bn_id']==3){
                    $bn_id = "ar";
                }elseif($row_session['bn_id']==4){
                    $bn_id = "sa";
                }elseif($row_session['bn_id']==5){
                    $bn_id = "as_1";
                }elseif($row_session['bn_id']==6){
                    $bn_id = "on_1";
                }elseif($row_session['bn_id']==7){
                    $bn_id = "ud";
                }elseif($row_session['bn_id']==8){
                    $bn_id = "nw";
                }elseif($row_session['bn_id']==9){
                    $bn_id = "cw";
                }elseif($row_session['bn_id']==10){
                    $bn_id = "r2";
                }elseif($row_session['bn_id']==11){
                    $bn_id = "lb";
                }elseif($row_session['bn_id']==12){
                    $bn_id = "bk";
                }elseif($row_session['bn_id']==13){
                    $bn_id = "hq";
                }
                ?>
                <form name="add_name" id="add_name" method="POST">
                    <div class="responsive p-6">
                        <table class="table table-bordered" id="stock_po">
                            <thead class="table-dark text-center">
                                <th class="col-md-1">รหัสบาร์โค้ด</th>
                                <th class="col-md-4">ชื่อรายการ</th>
                                <th class="col-md-1">จำนวนในคลัง</th>
                                <th class="col-md-1">จำนวนที่เบิกสั่งแล้ว</th>
                                <th class="col-md-1">view</th>
                                <th class="col-md-1">update จำนวนรายการ</th>
                            </thead>
                            <?php  $select_stock_po = $db->prepare("SELECT stock_po_id,stock_id,$bn_id as sum_bn,vendor_name,stock.stock_id,code_item ,item_name,unit_name FROM stock_po 
                            INNER JOIN stock ON stock.stock_id = stock_po.stock_po_id
                            LEFT JOIN item ON  item.item_id  =stock.item_id
                            LEFT JOIN unit ON item.unit_id = unit.unit_id 
                            LEFT JOIN vendor ON stock.vendor_id = vendor.vendor_id
                            ORDER BY code_item ASC");
                                $select_stock_po->execute();
                                $i_row=1;
                                while ($row_stock_po = $select_stock_po->fetch(PDO::FETCH_ASSOC)) {
                                    $select_total_stock = $db->prepare("SELECT COALESCE(SUM(item_quantity),0) as sum_item ,bn_stock FROM branch_stock INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log WHERE stock_id = ".$row_stock_po['stock_id']." AND bn_stock = ".$row_session['user_bn']."  ");
                                    $select_total_stock->execute();
                                    $row_sum_bn = $select_total_stock->fetch(PDO::FETCH_ASSOC);
                                ?> 
                            <form name="update_id" method="POST">
                            <tr>
                            <td><?php echo $row_stock_po["code_item"]; ?></td>
                            <td><?php echo $row_stock_po["item_name"]; ?> (<?php echo $row_stock_po['unit_name'] ?>)</td>
                            <td class="text-center"><?php echo $row_sum_bn["sum_item"]; ?></td>
                            <td ><input type="number" class="form-control text-center" name="sum[]" value="<?php echo $row_stock_po["sum_bn"];?>"></td>
                            <input type="hidden" class="form-control text-center" name="stock_id[]" value="<?php echo $row_stock_po["stock_id"];?>">
                            <input type="hidden" class="form-control text-center" name="bn_stock[]" value="<?php echo $row_session['user_bn'] ?>">
                            <td><input type="button" name="view" value="view" class="btn btn-info view_data" id="<?php echo $row_stock_po["stock_id"]; ?>"/></td>
                            <td><input type="button" name="update" value="update" class="btn btn-info update_data" id="<?php echo $row_stock_po["stock_id"]; ?>"/></td>
                            </tr>
                            </form>
                            <?php } ?>
                            
                        </table>
                        <input type="submit"  name="submit" id="submit" class="btn btn-success" value="update all" />
                        <input type="submit" href="stock_bn_po.php" class="btn btn-primary"value="Reset"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php require ('viewmodal.php');?>
<?php require ('vieweditpo.php');?>
<script type="text/javascript">
$(document).ready(function() {
    $('.view_data').click(function(){
        var uid=$(this).attr("id");
        $.ajax({
        url:"select_stock.php",
        method:"POST",
        data:{uid},
        success:function(data) {
        $('#detail').html(data);
        $('#dataModal').modal('show');
        }
    });
});
$('.update_data').click(function(){
        var uid=$(this).attr("id");
        var bn_id="<?php echo $bn_id ?>";
        $.ajax({
        url:"select_inset_modal_stock_po.php",
        method:"POST",
        data:{uid,bn_id},
        success:function(data) {
        $('#detail_po').html(data);
        $('#dataModal_po').modal('show');
        }
    });
});
$('#submit').click(function(e) {
        var data_add = $('#add_name').serialize(); 
        $.ajax({
            url: "stock_po_db.php",
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
<?php if($row_session['user_lv']==1){?>
    <script>
    $(document).ready(function() {

        $('#stock_po').DataTable({
            "lengthMenu":false
        });
    });
    </script>
    <?php }else{?>
        <script>
         $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#stock_po tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#stock_po').DataTable({
        dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
          "lengthMenu":false
    });
 
} );
    </script>
      <?php }?>
      
