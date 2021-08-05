<?php 
    require_once('../../database/db.php');

    if (isset($_REQUEST['update_id'])) {
        try {
            $item_id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM item WHERE item_id = :id");
            $select_stmt->bindParam(':id', $item_id);
            
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            
            
        
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $item_name_new = $_REQUEST['txt_item_name'];
        

        if (empty($item_name_new)) {
            $errorMsg = "Please Enter item Name";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE item SET item_name = :barnch_name_up  WHERE item_id = :item_id");
                    $update_stmt->bindParam(':barnch_name_up', $item_name_new);
                    $update_stmt->bindParam(':item_id', $item_id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "Record update successfully...";
                        header("refresh:2;../item.php");
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
   

   

  
?>
<link rel="icon" type="image/png" href="../../components/images/tooth.png"/>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <title>Plus dental clinic</title>
   
    
    <?php include('../../components/header.php');?>
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    	<!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    
    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  </head>


    
  </head>
  <body>
    
  <?php include('../../components/nav_edit.php'); ?>

    <header>
    
      <div class="display-3 text-xl-center">
        <H2>เพิ่มรายการใหม่</H2>  
      </div>

    </header>
    <hr><br>

    <?php include('../../components/content.php')?>
    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger mb-2">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($updateMsg)) {
    ?>
    <div class="alert alert-success mb-2">
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>
    <div class="container px-4">
   <form method="post">
   <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">ชื่อรายการ</label>
      <input type="text" class="form-control" name="txt_item_name" id="formGroupExampleInput" value="<?php echo $item_name,$unit?>" require>
      </div>
      <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">รหัสบาร์โค้ด</label>
      <input type="number" class="form-control" value="<?php echo $code_item?>" name="txt_code_item" min="10000000" max="99999999" onKeyUp="if(this.value>99999999){this.value='99999999';}else if(this.value<0){this.value='0';}"id="yourid">
      </div>
      <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">หน่วยนับ</label>
            
      <select name="txt_unit" id="unit_name"class="form-control form-control-lg select2">
            <option value="<?php echo $unit?>" selected>--- ค่าเดิม ---</option>
            <?php 
              $query = "SELECT * FROM unit ORDER BY unit_id ";
              $result = $db->query($query);
            ?>
            <?php
            foreach($result as $row)
            {
              echo '<option value="'.$row['unit_id'].'">'.$row['unit_name'].'</option>';
            }
            ?>
      </select>
      
      </div>
      <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">ราคา</label>
      <input type="number"value="<?php echo $price_stock?>" class="form-control" name="txt_price" min="0.01" step="0.01" onKeyUp="if(this.value>500000.00){this.value='500000.00';}else if(this.value<0.00){this.value='0.00';}"id="yourid">
      </div>
      <div class="mb-4">
      <input type="submit" name="btn_update" class="btn btn-outline-success" value="update">
                    <a href="../item.php" class="btn btn-outline-danger">reset</a>
    </div>
    </form>
   </div>

      
   
   <?php include('../../components/footer.php')?>
   
   <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
<script>

  $(document).ready(function(){

      $('.select2').select2({
        placeholder:'--- เลือก ---',
        theme:'bootstrap4',
        tags:true,
      }).on('select2:close', function(){
        var element = $(this);
        var new_unit_name = $.trim(element.val());

        if(new_unit_name != '')
        {
          $.ajax({
            url:"",
            method:"POST",
            data:{unit_name:new_unit_name},
            success:function(data)
            {
              if(data == 'yes')
              {
                element.append('<option value="'+new_unit_name+'">'+new_unit_name+'</option>').val(new_unit_name);
              }
            }
          })
        }

      });

  });

</script>
