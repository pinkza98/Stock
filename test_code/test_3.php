
<html>
<head>
    <title>Dynamically Add or Remove input fields in PHP with JQuery</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <br />
        <br />
        <h2>Dynamically Add or Remove input fields in PHP with JQuery</h2>
        <div class="form-group">
            <form method="post">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <input class="form-control" type="text" name="code_item_check"
                                    placeholder="Enter your Code item" class="form-control "  id="code_item" autofocus />
                            </td>
                            <td>
                                <button type="button" name="check" id="check" class="btn btn-success">Add More</button>
                            </td>

                        </tr>
                    </table>
                </div>
            </form>
            <form method="post" name="add_name" id="add_name">
                <div class="responsive p-6">
                    <table class="table table-bordered" id="dynamic_field">
                        <thead class="table-dark ">
                            <!-- <th>รหัสบาร์โค้ด</th> -->
                            <th>ชื่อรายการ</th>
                            <th>จำนวน</th>
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
<?php
include ('../database/db.php'); 
if (isset($_REQUEST['check'])) {

// $code_item_check = $_REQUEST['code_item_check'];

// if(is_null($code_item_check)){
//     $errorMsg = "ไม่พบรหัสบาร์โค้ด";
//  }

// $select_item =$db->query("SELECT code_item,item_id,item_name FROM item WHERE code_item='$code_item_check'");
// $select_item->execute();
// $row_item = $select_item->fetch(PDO::FETCH_ASSOC);
// extract($row_item);
// echo '<script type="text/javascript">';
// echo "var code_item = '$code_item';";
// echo "var item_name = '$item_name';";
// echo '</script>';
$data = 'xxx'; // ตัวแปร PHP

echo '<script type="text/javascript">';
echo "var data = '$data';"; // ส่งค่า $data จาก PHP ไปยังตัวแปร data ของ Javascript
"alter(data);";
echo '</script>';
}
?>
<script type="text/javascript">
$(document).ready(function() {
    var i = 1;

    var qty = 1;
    
    // var x = document.getElementById("code_item").value;
    // document.getElementById("code_item").innerHTML = x;
    $("#code_item").keypress(function(e) {


        if (e.which == 13) {

            //  $("#add").click();
            // alert(code_item);

            // alert("data");
        }
    });


    $("#add").click(function(e) {
        i++;



        $('#dynamic_field').append('<tr id="row' + i +
            '"><td><input type="text" class="form-control" value="' + code_item.value +
            '" id = "' +
            i + '" disabled></td><td><input type="text" name="qty[]" value="' + qty +
            '"class="form-control" id = "' +
            i + '"/></td><td><button type="button" name="remove" id="' + i +
            '" class="btn btn-danger btn_remove">X</button></td></tr>');
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
                $('#add_name')[0].reset();
            }
        });
    });
});
</script>