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
        <h2>system function multiRow </h2>
        <div class="form-group">

            <div class="table-responsive">
                <form method="post" id="list_item" name="list_item">
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
                                    id="code_item"  />
                            </td>
                           
                        </tr>
                    </table>
                </form>
                <form name="add_name" id="add_name">
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


        // var code= document.getElementById("code_item").value;
        // var bn= document.getElementById("bn_id").value;
       

        if (event.keyCode === 13) {
            if(!this.value == ""){ 
                
                event.preventDefault(event);
           $.ajax({
            url:'data-php.php',
            type:'post',
            dataType:'json',
            data:$('#list_item').serialize(event),
            success:function(result) {
                
                var item_id = result.item_id;
                var item_name = result.item_name;
                var code_item = result.code_item;
                var sum_item = result.sum_item;
                var bn_name = result.bn_name;
                i++;
                
                $('#dynamic_field').append('<tr id="row' + i +
            '" class="dynamic-added"><td><input type="text" value="' + code_item+
            '" placeholder="Enter your Name" class="form-control " name="name[]"/disabled></td><td><input type="text" value="' +
            item_name +
            '" placeholder="Enter your Name" class="form-control"/disabled></td><td><input type="text" value="' +
            qty +
            '" placeholder="Enter your Name" class="form-control "/></td><td><input type="text" value="' +
            sum_item +
            '" placeholder="Enter your Name" class="form-control "/disabled></td><td><input type="text" value="' +
            bn_name +
            '" placeholder="Enter your Name" class="form-control "/disabled></td><td><button type="button" name="remove" id="' +
            i + '" class="btn btn-danger btn_remove">X</button></td></tr>'
            );
            
            

            $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();

        });
               
               }
               
           }
           );
        }
        }
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