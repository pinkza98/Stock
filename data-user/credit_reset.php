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
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../node_modules/jquery/dist/jquery.js"></script>
    <!-- <==========================================booystrap 5==================================================> -->
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <!-- <==========================================data-teble==================================================> -->
    <?php include('../components/header.php');?>
    <style>
        .btn-info {
            color: #FFF;
        }
        .btn-warning {
            color: #FFF; 
        }
    </style>
</head>
<body>
    <?php include('../components/nav_stock.php'); ?>
    <header>

       
    </header>
    <hr><br>
    <?php include('../components/content.php')?>
    <div class="container">
        <div class="row">
            <div class="col">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-header">
                    <h4 class="card-title">ปรับปรุงเครดิตสมาชิก</h4>
                </div>
                <form id="list_item" name="list_item">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-select mb-2 mt-2" name="status" id="status" >
                                    <option value="all">ทั้งหมด</option>
                                    <option value="one">รายบุคคล</option>
                                </select>
                                <div class="row g-2">
                            </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </form>
                <div class="row">
                        <div class="col-md-9">
                            <div class="form.group">
                                <input type="text" name="user_email" id="user_email" class="form-control"
                                    placeholder="E-mail" required autofocus>
                            </div>
                        </div>
                </div>
                <br>
                <form name="add_name" id="add_name">
                    <div class="responsive p-6">
                        <table class="table table-bordered" id="dynamic_field">
                            <thead class="table-dark text-center">
                                <th class="col-md-2">รหัสสมาชิก</th>
                                <th class="col-md-4">สาขา</th>
                                <th class="col-md-1">ตำแหน่ง</th>
                                <th class="col-md-1">เพิ่มเครดิต</th>
                                <th class="col-md-2">เครดิตที่มี</th>
                                <th class="col">ลบ</th>
                            </thead>
                            <tr>
                            <!-- <tr><input type="text" class="form-control" placeholder="หมายเหตุถ้ามี!"name="note"id="note"/></tr> -->
                            
                            </tr>
                        </table>
                        <input type="submit" name="submit" id="submit" class="btn btn-success" value="Add" />
                        <input type="submit" href="transfer.php" class="btn btn-primary"value="Reset"/>
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
    $("#user_email").keypress(function(event) {
        if (event.keyCode === 13) {
            if (!this.value == "") {

                event.preventDefault(event);
                $.ajax({
                    url: 'select_user/user_load.php',
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
                        var status = result.status;
                        var bn_id2 = result.bn_id2;
                        var bn_name2 = result.bn_name2;
                        var bn_acronym = result.bn_acronym;
                        var bn2_acronym = result.bn2_acronym;
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
                            bn_id2 + '" name="bn_id2[]"/><input type="hidden" value="' +
                            user_name +
                            '" name="user_name[]"/><input type="hidden" value="' +
                            price_stock +
                            '" name="price_stock[]"/><input type="hidden" value="' +
                            exd_date +
                            '" name="exd_date[]"/><input type="hidden" value="' +
                            status +
                            '" name="status[]"/><input type="hidden" value="' +
                            bn_acronym +
                            '" name="bn_acronym[]"/><input type="hidden" value="' +
                            bn2_acronym +
                            '" name="bn2_acronym[]"/><input type="hidden" value="' +
                            sum_item +
                            '" name="sum[]"/><td><input type="text" value="' +
                            sum_item +
                            '" class=" form-control  text-center"/disabled></td><td><input type="text" value="' +
                            bn_name +
                            '" class=" form-control text-center"/disabled></td><td><input type="text" value="' +
                            bn_name2 +
                            '" class=" form-control text-center"/disabled></td><td><input type="button" name="view" value="view" class="btn btn-info view_data" id="'+stock_id+'"/></td><td><button type="button" name="remove" id="' +
                            i +
                            '" class="btn btn-danger btn_remove">X</button></td></tr>'
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
    $('#submit').click(function(e) {
        var data_add = $('#add_name').serialize(); 
        $.ajax({
            url: "stock_center_db.php",
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
