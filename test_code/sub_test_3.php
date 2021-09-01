<?php
include ('../database/db.php'); 
if (isset($_REQUEST['check'])) {

$code_item_check = $_REQUEST['code_item_check'];
$bn_id =$_REQUEST['txt_user_bn'];

$select_item =$db->query("SELECT code_item,item_id,item_name FROM item WHERE code_item='$code_item_check'");
$select_item->execute();
$row_item = $select_item->fetch(PDO::FETCH_ASSOC);
@@extract($row_item);

if($row_item['code_item']!= $code_item_check){
 $errorMsg = "รหัสบาร์โค้ดนี้ยังไม่มีในระบบ";
//  $item_id = $select_item->fetch();
 }else{
    @@$select_stock =$db->prepare("SELECT * FROM stock 
    INNER JOIN branch_stock ON stock.stock_id = branch_stock.stock_id
    INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
    INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
    WHERE item_id='$item_id' AND branch_stock.bn_stock ='$bn_id' ");
    $select_stock->execute();
    $row_stock = $select_stock->fetch(PDO::FETCH_ASSOC);
    @@extract($row_stock);

    
     
    echo '<script type="text/javascript">';
    
    echo "var item_name = '$item_name';";
    echo "var item_id = '$item_id';";
    echo "var item_quantity = '$item_quantity';";
    echo "var bn_name = '$bn_name';"; // ส่งค่า $data จาก PHP ไปยังตัวแปร data ของ Javascript
    echo "var bn_id = '$bn_id';";
    echo '</script>';

 }
 if(empty($select_stock)){
    $errorMsg = "รหัสบาร์โค้ด";
 }

}


?>
<html>
<head>
    <title>ประยุกต์</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- <==========================================booystrap 5==================================================> -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <========================================== jquery ==================================================> -->
    <script src="../node_modules/jquery/dist/jquery.js"></script>
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
        <h2>system function multiRow </h2>
        <div class="form-group">

            <div class="table-responsive">
                <form method="post">
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <?php 
                                        $select_bn = $db->prepare("SELECT * FROM branch ORDER BY bn_id DESC");
                                        $select_bn->execute();
                                        ?>

                                <select class="form-select" name="txt_user_bn">
                                    <option value="<?php echo$row_session['user_bn']?>">สาขาปัจจุบันที่สังกัด
                                    </option>
                                    <?php  while ($row_bn = $select_bn->fetch(PDO::FETCH_ASSOC)) {?>
                                    <option value="<?php echo$row_bn['bn_id']?>"><?php echo$row_bn['bn_name']?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" type="text" name="code_item_check"
                                    placeholder="Enter your Code item" class="form-control " id="code_item" autofocus />
                            </td>
                            <td>
                                <button type="submit" name="check" id="add" class="btn btn-success" hidden>Add
                                    More</button>
                            </td>
                        </tr>
                </form>

                </table>
                <form method="post" name="add_name" id="add_name">
                    <div class="responsive p-6">
                        <table class="table table-bordered" id="dynamic_field">
                            <thead class="table-dark ">
                                <th>รหัสบาร์โค้ด</th>
                                <th>ชื่อรายการ</th>
                                <th>จำนวน</th>
                                <th>ที่มีจำนวน</th>
                                <th>สาขา</th>
                                <th>ลบ</th>
                            </thead>
                            <tr>

                            </tr>
                        </table>
                        <input type="button" name="submit" id="submit" class="btn btn-primary" value="Add" />
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

    $("#code_item").keypress(function(e) {

        if (e.which == 13) {
            alert(item_name);
          
            
        //    $("#add").click();
        }
    });
    $("#add").click(function() {
                i++;

                $('#dynamic_field').append('<tr id="row' + i +
                    '"><td><input type="text" value="' + code_item +
                    '" class="form-control name_list" /></td><td><input type="text"  value="' +
                    item_name +
                    '" class="form-control name_list" /></td><td><input type="text" name="qty[]" value="' +
                    qty +
                    '" class="form-control name_list" /></td><td><input type="text" value="' +
                    item_quantity +
                    '" class="form-control name_list" /></td><td><input type="text" value="' +
                    bn_name +
                    '" class="form-control name_list" /></td><td><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove">X</button></td></tr>');

            });
            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });



    // $('#submit').click(function() {
    //     $.ajax({
    //         url: "name.php",
    //         method: "POST",
    //         data: $('#add_name').serialize(),
    //         success: function(data) {
    //             alert(data);
    //             $('#add_name')[0][0].reset();
    //         }
    //     });
    // });
});
</script>