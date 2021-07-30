<?php 
 
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Dynamic Dependent Searchable Select Box with PHP Ajax jQuery</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
  </head>
  <body>
  <?php include_once('layout/nav.php'); ?>
    <br />
    <div class="container">
      <h3 align="center">Dynamic Dependent Searchable Select Box with PHP Ajax jQuery</h3>
      <br />
      <form method="post" action="test_add">
      <div class="panel panel-default">
        <div class="panel-heading">Select Data</div>
        <div class="panel-body">

          <div class="form-group">
            <label>หน่วยนับ</label>
            <select name="category_item" id="category_item" class="form-control input-lg" data-live-search="true" title="Select Category">
            </select>
          </div>

          <div class="form-group">
            <label>ชื่อสินค้า</label>
            <select name="sub_category_item" id="sub_category_item" class="form-control input-lg" data-live-search="true" title="Select Sub Category">
            </select>
          </div>

          <div class="form-group">
            <label>ราคาต่อหน่วย</label>
            <input type="number" name="price" class="form-control input-lg">
          </div>

          <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="save" class="btn btn-success" value="Insert">
                    <a href="item.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </div>
      </div>
    </div>
    </form>
  </body>
</html>

<script>
$(document).ready(function(){

  $('#category_item').selectpicker();

  $('#sub_category_item').selectpicker();

  load_data('category_data');

  function load_data(type, category_id = '')
  {
    $.ajax({
      url:"load_data.php",
      method:"POST",
      data:{type:type, category_id:category_id},
      dataType:"json",
      success:function(data)
      {
        var html = '';
        for(var count = 0; count < data.length; count++)
        {
          html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
        }
        if(type == 'category_data')
        {
          $('#category_item').html(html);
          $('#category_item').selectpicker('refresh');
        }
        else
        {
          $('#sub_category_item').html(html);
          $('#sub_category_item').selectpicker('refresh');
        }
      }
    })
  }

  $(document).on('change', '#category_item', function(){
    var category_id = $('#category_item').val();
    load_data('sub_category_data', category_id);
  });
  
});
</script>
<script src="js/slim.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.js"></script>
