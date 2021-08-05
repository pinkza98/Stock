<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['delete_id'])) {
      $item_id = $_REQUEST['delete_id'];

      $select_stmt = $db->prepare("SELECT * FROM item WHERE item_id = :item_id");
      $select_stmt->bindParam(':item_id', $item_id);
      $select_stmt->execute();
      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

      // Delete an original record from db
      $delete_stmt = $db->prepare('DELETE FROM item WHERE item_id = :item_id');
      $delete_stmt->bindParam(':item_id', $item_id);
      $delete_stmt->execute();

        header('Location:item.php');
    }
   

    if (isset($_REQUEST['save'])) {
      $item_name = $_REQUEST['txt_item_name'];
      $code_item = $_REQUEST['txt_code_item'];
      $unit = $_REQUEST['txt_unit'];
      $price_stock = $_REQUEST['txt_price'];

      $select_item = $db->prepare("SELECT * FROM item WHERE code_item = :code_item_row");
      $select_item->bindParam(':code_item_row', $code_item);
      $select_item->execute();
      if ($select_item->fetchColumn() > 0){
        $errorMsg = 'รหัสบาร์โค้ดมีรายการซ้ำ!!!';
      }
      elseif (empty($item_name)) {
          $errorMsg = "Please enter item name";
      } else {
          try {
              if (!isset($errorMsg)) {
                  $insert_stmt = $db->prepare("INSERT INTO item (item_name,code_item,unit,price_stock) VALUES (:item_name,:code_item,:unit,:price_stock)");
                  $insert_stmt->bindParam(':item_name', $item_name);
                  $insert_stmt->bindParam(':code_item', $code_item);
                  $insert_stmt->bindParam(':unit', $unit);
                  $insert_stmt->bindParam(':price_stock', $price_stock);

                  if ($insert_stmt->execute()) {
                      $insertMsg = "Insert Successfully...";
                      header("refresh:1;item.php");
                  }
              }
          } catch (PDOException $e) {
              echo $e->getMessage();
          }
      }
  }

  
?>
<link rel="icon" type="image/png" href="../components/images/tooth.png"/>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <title>Plus dental clinic</title>
   
    
    <?php include('../components/header.php');?>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

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
    
    <?php include('../components/nav_stock.php'); ?>

    <header>
    
      <div class="display-3 text-xl-center">
        <H2>เพิ่มรายการใหม่</H2>  
      </div>

    </header>
    <hr><br>

    <?php include('../components/content.php')?>
    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger mb-2">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success mb-2">
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>
    
   <div class="container px-4">
     
   <form method="post">
   <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">ชื่อรายการ</label>
      <input type="text" class="form-control" name="txt_item_name" id="formGroupExampleInput" placeholder="กระดาษA4,ปากกา,รีเทรินเนอร์........." require>
      </div>
      <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">รหัสบาร์โค้ด</label>
      <input type="number" class="form-control" name="txt_code_item" min="100000" max="999999" onKeyUp="if(this.value>999999){this.value='999999';}else if(this.value<0){this.value='0';}"id="yourid">
      </div>
      <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">หน่วยนับ</label>

      <select name="txt_unit" id="unit_name"class="form-control form-control-lg select2">>
            <option value="" selected hidden>--- เลือก ---</option>
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
      <input type="number" class="form-control" name="txt_price" min="0.01" step="0.01" onKeyUp="if(this.value>1000000.00){this.value='1000000.00';}else if(this.value<0.00){this.value='0.00';}"id="yourid">
      </div>
      <div class="mb-4">
      <input type="submit" name="save" class="btn btn-outline-success" value="Insert">
                    <a href="item.php" class="btn btn-outline-danger">reset</a>
    </div>
    </form>
  
  <hr>
  <div class="text-center"><H2>แสดงข้อมูล</H2></div>
  <br>
   <table class="table table-dark table-hover text-xl-center">
    <thead>
      <tr>
        <th scope="col">ชื่อรายการ</th>
        <th scope="col">รหัสบาร์โค้ด</th>
        <th scope="col">หน่วยนับ</th>
        <th scope="col">ราคา(บาท)</th>
        <th scope="col">แก้ไข</th>
        <th scope="col">ลบ</th>
        
        
      
      </tr>
    </thead>
    <tbody>
    <?php 
          $select_stmt = $db->prepare("SELECT * FROM item INNER JOIN unit ON item.unit = unit.unit_id ");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?php echo $row["item_name"]; ?></td>
        <td><?php echo $row["code_item"]; ?></td>
        <td><?php echo $row["unit_name"]; ?></td>
        <td><?php echo $row["price_stock"]; ?></td>
        <td><a href="edit/item_edit.php?update_id=<?php echo $row["item_id"]; ?>" class="btn btn-outline-warning">View</a></td>
        <td><a href="?delete_id=<?php echo $row["item_id"];?>" class="btn btn-outline-danger">Delete</a></td>
        
        <?php } ?>
      </tr>
    </tbody>
  </table>
   </div>

      
   
   <?php include('../components/footer.php')?>
   
   <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
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
