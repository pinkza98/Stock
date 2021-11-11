<?php 
    require_once('../database/db.php');
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
</head>
<body>
    <?php include('../components/nav_stock.php'); ?>
    <header>
        <div class="display-3 text-xl-center mt-3">
            <H2>เพิ่มรายการสั่งซื้อของสาขา : <?php echo $row_session['bn_name'] ?></H2>
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
                    <h4 class="card-title">update รายการสั่งซื้อ PO ของสาขา :  <?php echo $row_session['bn_name'] ?></h4>
                </div>
            </div>
                <form id="list_item" name="list_item">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-select mb-2 mt-2" name="status" id="status" required="true" >
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
                    $bn_id = "sa_1";
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
                <form name="add_name" id="add_name">
                    <div class="responsive p-6">
                        <table class="table table-bordered" id="dynamic_field">
                            <thead class="table-dark text-center">
                                <th class="col-md-1">รหัสบาร์โค้ด</th>
                                <th class="col-md-4">ชื่อรายการ</th>
                                <th class="col-md-1">ที่มีจำนวน</th>
                                <th class="col-md-1">จำนวนเบิกสั่ง</th>
                                <th class="col-md-1">view</th>
                                <th class="col-md-1">update</th>
                            </thead>
                            <?php  $select_stock_po = $db->prepare("SELECT $bn_id as sum_bn,price_stock,stock.marque_id,marque_name,division_name,vendor_name,stock.stock_id,code_item ,item_name,unit_name,type_name,item.exd_date,nature_name FROM stock_po 
                            INNER JOIN stock ON stock.stock_id = stock_po.stock_po_id
                            LEFT JOIN item ON  item.item_id  =stock.item_id
                            LEFT JOIN unit ON item.unit_id = unit.unit_id  
                            LEFT JOIN nature ON stock.nature_id = nature.nature_id   
                            LEFT JOIN type_item ON stock.type_id = type_item.type_id
                            LEFT JOIN vendor ON stock.vendor_id = vendor.vendor_id
                            LEFT JOIN division ON stock.division_id = division.division_id
                            LEFT JOIN marque ON stock.marque_id = marque.marque_id
                            INNER JOIN branch_stock ON stock.stock_id = branch_stock.stock_id
                            INNER JOIN branch_stock_log ON branch_stock.full_stock_id=branch_stock_log.full_stock_id_log
                            WHERE bn_stock = ".$row_session['user_bn']."
                            ORDER BY code_item ASC 
                                                ");
                                                $select_stock_po->execute();

                                                while ($row_stock_po = $select_stock_po->fetch(PDO::FETCH_ASSOC)) {
                                                ?> 
                            <tr>
                            <td><?php echo $row_stock_po["code_item"]; ?></td>
                            <td><?php echo $row_stock_po["item_name"]; ?> (<?php echo $row_stock_po['unit_name'] ?>)</td>
                            <td><?php echo $row_stock_po["item_quantity"]; ?></td>
                            <td><input type="number" name="" value="<?php echo $row_stock_po["sum_bn"]; ?>"/></td>
                            <td><input type="button" name="view" value="view" class="btn btn-info view_data" id="<?php echo $row_stock_po["stock_id"]; ?>"/></td>
                            <td><input type="button" name="view" value="update" class="btn btn-info view_data" id=""/></td>
                            <?php } ?>
                            </tr>
                        </table>
                        <input type="submit"  name="submit" id="submit" class="btn btn-success" value="update all" />
                        <input type="submit" href="stock_bn_min-max.php" class="btn btn-primary"value="Reset"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php require ('viewmodal.php');?>
<script type="text/javascript">
$(document).ready(function() {
    $(document).on('click', '.view_data', function() {
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
});
</script>
