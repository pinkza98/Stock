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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
</head>

<body>

    <?php include('../components/nav_stock.php'); ?>
    <header>

        <div class="display-3 text-xl-center mt-3">
            <H2>นับสต๊อกของคลังสาขา</H2>
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
                <div class="card-header">
                    <h4 class="card-title">ค้นหาข้อมูลด้วยรหัสบาร์โค้ด</h4>
                </div>
                <form id="list_item" name="list_item">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php 
                                    if($row_session['user_lv']>=3){
                                        ?>
                                    <?php 
                                        $select_bn = $db->prepare("SELECT * FROM branch ORDER BY bn_id DESC");
                                        $select_bn->execute();
                                        ?>

                                    <select class="form-select mt-3" name="bn_id" id="bn_id">
                                        <option value="<?php echo$row_session['user_bn']?>">สาขาปัจจุบันที่สังกัด
                                        </option>
                                        <?php  while ($row_bn = $select_bn->fetch(PDO::FETCH_ASSOC)) {?>
                                        <option value="<?php echo$row_bn['bn_id']?>"><?php echo$row_bn['bn_name']?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <?php
                                    }else{
                                    ?>
                                    <select class="form-select mt-3" name="bn_id" id="bn_id">
                                        <option value="<?php echo$row_session['user_bn']?>">สาขาปัจจุบันที่สังกัด
                                        </option>
                                    </select>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form.group">
                                    <input type="text" name="code_item" id="code_item" class="form-control"
                                        placeholder=" รหัสบาร์โค้ด" required autofocus>
                                        <?php $user_name = $row_session['user_fname'].$row_session['user_lname'] ?>
                                        <input type="text" name="user_name" id="user_name" value="<?php echo $user_name?>" hidden>
                                </div>
                            </div>
                        </div> 
                    </form>
                    <form name="add_name" id="add_name">
                    <div class="responsive p-6">
                        <table class="table table-bordered" id="dynamic_field">
                            <thead class="table-dark text-center">
                                <th class="col-md-1">รหัสบาร์โค้ด</th>
                                <th class="col-md-4">ชื่อรายการ</th>
                                <th class="col-md-1">จำนวน</th>
                                <th class="col-md-1">ที่มีจำนวน</th>
                                <th class="col-md-2">สาขา</th>
                                <th class="col-md-1">ลบ</th>
                            </thead>
                            <tr>


                            </tr>
                        </table>
                        <input type="submit" name="submit" id="submit" class="btn btn-success" value="Add" />
                    </div>
                </form>
                </div>
            </div>
        </div>
 
</body>
</html>
<script type="text/javascript">
$(document).ready(function() {
    var i = 1;
    var qty = 1;
    // var Data = newFormData();
    $("#code_item").keypress(function(event) {

        if (event.keyCode === 13) {
            if (!this.value == "") {

                event.preventDefault(event);
                $.ajax({
                    url: 'stock_center_load.php',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#list_item').serialize(),
                    success: function(result) {
                        var item_name = result.item_name;
                        var code_item = result.code_item;
                        var sum_item = result.sum_item;
                        var bn_name = result.bn_name;
                        var bn_id = result.bn_id;
                        var stock_id = result.stock_id;
                        var exd_date = result.exd_date;
                        var price_stock = result.price_stock;
                        var user_name = result.user_name;
                        // 
                        i++;
                        $('#dynamic_field').append('<tr id="row' + i +
                            '" class="dynamic-added"><td><input type="text" value="' +
                            code_item +
                            '" class=" form-control text-center" /disabled></td><td><input type="text" value="' +
                            item_name +
                            '" class=" form-control text-center"/disabled></td><td><input type="number" value="' +
                            qty +
                            '" class=" form-control  text-center" name="qty[]"/></td><input type="hidden" value="' +
                            stock_id +
                            '" name="stock_id[]"/><input type="hidden" value="' +
                            bn_id + '" name="bn_id[]"/><input type="hidden" value="' +
                            user_name + '" name="user_name[]"/><input type="hidden" value="' +
                            price_stock +
                            '" name="price_stock[]"/><input type="hidden" value="' +
                            exd_date +
                            '" name="exd_date[]"/><td><input type="text" value="' +
                            sum_item +
                            '" class=" form-control  text-center"/disabled></td><td><input type="text" value="' +
                            bn_name +
                            '" class=" form-control text-center"/disabled></td><td><button type="button" name="remove" id="' +
                            i +
                            '" class="btn btn-danger btn_remove  text-center">X</button></td></tr>'
                            );
                        event.currentTarget.value = "";
                    }
                });
            }
        }
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });
    $('#submit').click(function() {
        $.ajax({
            url: "stock_center_db.php",
            method: "POST",
            data: $('#add_name').serialize(),
            success: function(data) {
                alert("เพิ่มข้อมูลสำเร็จ");
                $('#add_name')[0][0].reset();
            },
            fail: function(data){
                alert(data);
            }
        });
    });
});
</script>