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
        <h2 align="center">Dynamically Add or Remove input fields in PHP with JQuery</h2>
        <div class="form-group">
            <form name="add_name" id="add_name">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td><input class="form-control" name="text" name="name[]" placeholder="Enter your Code item"
                                    class="form-control name_list" id="s" autofocus /></td>
                            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                        </tr>
                    </table>
                    <form name="add_name" id="add_name">  
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
            </form>

        </div>
    </div>
</body>
<!-- <?php
    $phpArray = array(
        0 => "Mon", 
        1 => "Tue", 
        2 => "Wed", 
        3 => "Thu",
        4 => "Fri", 
        5 => "Sat",
        6 => "Sun",
    )
?>

<script type="text/javascript">

    var jArray = <?php echo json_encode($phpArray); ?>;

    for(var i=0; i<jArray.length; i++){
        alert(jArray[i]);
    }

 </script> -->

</html>
<script>
$(document).ready(function() {
    var i = 1;
    var s = 1;
    var qty = 1;
    var name_list = [];
    $("#s").keypress(function(e) {
        if (e.which == 13) {
            $("#add").click();

        }
    });

    $("#add").click(function(e) {
        i++;
        s++;
        $('#dynamic_field').append('<tr id="row' + i +
            '"><td><input type="text" name="name[]"  class="form-control" id = "' +
            s + '"/></td><td><input type="text" qty="qty[]" value="' + qty + '"class="form-control" id = "' +
            s + '"/></td><td><button type="button" name="remove" id="' + i +
            '" class="btn btn-danger btn_remove">X</button></td></tr>');
    });
    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });


    //   $('#add').click(function(){  
    //        i++;  
    //        $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
    //   });  
    //   $(document).on('click', '.btn_remove', function(){  
    //        var button_id = $(this).attr("id");   
    //        $('#row'+button_id+'').remove();  
    //   });  
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