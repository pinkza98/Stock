<?php
    include ('../database/db.php'); 
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
    <?php 
    
    if (isset($_REQUEST['code_item_check'])) {

        $code_item_check = $_REQUEST['code_item_check'];
        $bn_id =$_REQUEST['txt_user_bn'];
    
        $select_item =$db->query("SELECT code_item,item_id,item_name FROM item WHERE code_item='$code_item_check'");
        $select_item->execute();
        $row_item = $select_item->fetch(PDO::FETCH_ASSOC);
        @@extract($row_item);
        
    if($row_item['code_item']!= $code_item_check){
     $errorMsg = "รหัสบาร์โค้ดนี้ยังไม่มีในระบบ";
     $item_id = $select_item->fetch();
     }else{
        @@$select_stock =$db->prepare("SELECT bn_name,SUM(branch_stock_log.item_quantity) as sum ,item.item_id,code_item,item_name FROM stock 
        INNER JOIN branch_stock ON stock.stock_id = branch_stock.stock_id
        INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
        INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
        INNER JOIN item ON stock.item_id = item.item_id
        WHERE code_item='$code_item' AND branch_stock.bn_stock ='$bn_id' ");
        $select_stock->execute();
        $row_stock = $select_stock->fetch(PDO::FETCH_ASSOC);
        @@extract($row_stock);
    
       
        

        echo '<script type="text/javascript">';
        echo "var item_name_db = '$item_name';";
        echo "var code_item_db = '$code_item';";
        echo "var item_quantity_db = '$sum';";
        echo "var bn_name = '$bn_name';"; // ส่งค่า $data จาก PHP ไปยังตัวแปร data ของ Javascript
    //     echo "var bn_id = '$bn_id';";
        echo '</script>';
    
    //  }
    //  if(empty($select_stock)){
    //     $errorMsg = "รหัสบาร์โค้ด";
    //  }
    
    }
}
    ?>
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
                <form method="post" name="add_name" id="add_name">
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <?php 
                                        $select_bn = $db->prepare("SELECT * FROM branch ORDER BY bn_id DESC");
                                        $select_bn->execute();
                                        ?>

                                <select class="form-select" name="txt_user_bn" id="bn_name">
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
                                <input class="form-control" type="text" name="code_item_check"
                                    placeholder="Enter your Code item" class="form-control " id="code_item" autofocus>
                            </td>
                            <td>
                             <!-- <button type="submit" name="check" hidden/> -->
                                <button type="button" id="add" class="btn btn-success" hidden>Add More</button>
                            </td>
                        </tr>
                    </table>

                </form>
                <div class="responsive p-6">
                    <table class="table table-bordered" id="dynamic_field">
                        <thead class="table-dark ">
                            <th>ลำดับ</th>
                            <th>รหัสบาร์โค้ด</th>
                            <th>จำนวน</th>
                            <th>ที่มีจำนวน</th>
                            <th>สาขา</th>
                            <th>ลบ</th>
                        </thead>
                        <tr>

                        </tr>
                    </table>
                    <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Add" />
                </div>
            </div>

        </div>
    </div>
</body>

</html>

<script>
$(document).ready(function() {
    var i = 1;
    var qty = 1;
    
    $("#code_item").keypress(function(event) {

        if (event.keyCode === 13) {
            // alert("+++");
            // $('check').click();
            if(!this.value == ""){ 
                $("#add").click();
}
            
            event.preventDefault(event);
        }
    });
    $('#add').click(function(event) {
        i++;

        $('#dynamic_field').append('<tr id="row' + i +
            '" class="dynamic-added"><td><input type="text" value="' + code_item_db+
            '" placeholder="Enter your Name" class="form-control name_list" name="name[]"/></td><td><input type="text" value="' +
            item_name_db +
            '" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" value="' +
            qty +
            '" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" value="' +
            item_quantity_db +
            '" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" value="' +
            bn_name +
            '" placeholder="Enter your Name" class="form-control name_list"/></td><td><button type="button" name="remove" id="' +
            i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            code_item_check = null;
            return(code_item_check);

    });
    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });



    $('#submit').click(function() {
        $.ajax({
            url: "name.php",
            method: "POST",
            data: $('#add_name').serialize(),
            success: function(data) {
                alert(data);
                $('#add_name')[0][0].reset();
            }
        });
    });
});
</script>