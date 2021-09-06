    <?php
    include_once ('../database/db.php'); 
    ?>
    <html>

    <head>
        <title>ประยุกต์</title>
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
        <!-- <==========================================booystrap 5==================================================> -->
        <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <!-- <========================================== jquery ==================================================> -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- <==========================================data-teble==================================================> -->

    </head>

    <body>

        <div class="container">
            <br />
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
            <br />
            <h2>นับสต๊อก </h2>
            <div class="form-group">
                <div class="table-responsive">
                    <form id="list_item" name="list_item">
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    <?php 
                                        $select_bn = $db->prepare("SELECT * FROM branch ORDER BY bn_id DESC");
                                        $select_bn->execute();
                                        ?>

                                    <select class="form-select" name="bn_id" id="bn_id">
                                        <!-- <?php echo$row_session['user_bn']?> -->
                                        <option value="1">สาขาปัจจุบันที่สังกัด
                                        </option>
                                        <?php  while ($row_bn = $select_bn->fetch(PDO::FETCH_ASSOC)) {?>
                                        <option value="<?php echo$row_bn['bn_id']?>"><?php echo$row_bn['bn_name']?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="code_item"
                                        placeholder="Enter your Code item" class="form-control " id="code_item">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php 
                    if (isset($errorMsg)) {
                ?>
                                    <div class="alert alert-danger mb-2">
                                        <strong>คำเตือน! <?php echo $errorMsg; ?></strong>
                                    </div>
                                    <?php } ?>
                    <form name="add_name" id="add_name">
                        <div class="responsive p-6">

                            <table class="table table-bordered" id="dynamic_field">
                                <thead class="table-dark text-center">
                                    <th class="col-md-1">รหัสบาร์โค้ด</th>
                                    <th class="col-md-4">ชื่อรายการ</th>
                                    <th class="col-md-1">จำนวน</th>
                                    <th class="col-md-1">ที่มีจำนวน</th>
                                    <th class="col-md-2">สาขา</th>
                                    <th class="col-md-1 btn-center">view</th>
                                    <th class="col-md-1">ลบ</th>
                                </thead>
                                <tr>
                                   

                                </tr>
                            </table>
                            <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Add" />
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
                    url: 'data-php.php',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#list_item').serialize(),
                    success: function(result) {
                        var item_id = result.item_id;
                        var item_name = result.item_name;
                        var code_item = result.code_item;
                        var sum_item = result.sum_item;
                        var bn_name = result.bn_name;
                        var bn_id = result.bn_id;
                        var stock_id = result.stock_id;
                        var exd_date = result.exd_date;
                        var price_stock = result.price_stock;
// 
                        i++;
                        $('#dynamic_field').append('<tr id="row' + i +
                            '" class="dynamic-added"><td><input type="text" value="' +
                            code_item +
                            '" class=" form-control  text-center" /></td><td><input type="text" value="' +
                            item_name +
                            '" class=" form-control  text-center"/disabled></td><td><input type="number" value="' +
                            qty +
                            '" class=" form-control  text-center" name="qty[]"/><input type="text" value="'+stock_id+'" name="stock_id[]" hidden></td><td><input type="text" value="' +
                            sum_item +
                            '" class=" form-control  text-center"/disabled></td><td><input type="text" value="' +
                            bn_name +
                            '" class=" form-control text-center"/disabled></td><td><button type="button" name="view" id="' +
                            stock_id +
                            '" class="btn btn-info  text-center">View</button></td><td><button type="button" name="remove" id="' +
                            i +
                            '" class="btn btn-danger btn_remove  text-center">X</button></td></tr>');
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
            url: "name.php",
            method: "POST",
            data: $('#add_name').serialize(),
            success: function(data) {
                $('#add_name')[0][0].reset();
            }
        });
    });
});
    </script>