
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
            
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <div class="items">
                                <td>
                                    <input class="form-control" type="text" placeholder="Enter your Code item"
                                        class="form-control " id="code_item" autofocus />
                                </td>
                                <td>
                                    <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                                </td>
                            </div>
                            
                        </tr>
                    </table>
                    <form method="post" name="add_name" id="add_name">
                    <div class="responsive p-6">
                        <table class="table table-bordered" id="dynamic_field">
                            <thead class="table-dark ">
                                <th>รหัสบาร์โค้ด</th>
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
<script>
$(document).ready(function() {
    var i = 1;
    var qty = 1;
   
    $("#code_item").keypress(function(e) {
        
    
        if (e.which == 13) {
            
            $("#add").click();
           
        }
    });


    $("#add").click(function(e) {
        i++;
        
         $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" value="'+(document.getElementById("code_item").value)+'" class="form-control name_list" /></td><td><input type="text" name="qty[]" value="'+qty+'" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
        // $('#dynamic_field').append('<tr id="row' + i +
        //     '"><td><input type="text" class="form-control" value="' + (document.getElementById("code_item").value) +
        //     '" id = "' +
        //     s + '" ></td><td><input type="text" name="qty[]" value="' + qty +
        //     '"class="form-control" id = "' +
        //     s + '"></td><td><button type="button" name="remove" id="' + i +
        //     '" class="btn btn-danger btn_remove">X</button></td></tr>');
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