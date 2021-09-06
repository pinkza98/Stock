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
      $unit_id = $_REQUEST['txt_unit'];
      $price_stock = $_REQUEST['txt_price'];
      $exd_date = $_REQUEST['txt_exd_date'];

      $select_item = $db->prepare("SELECT * FROM item WHERE code_item = :code_item_row");
      $select_item->bindParam(':code_item_row', $code_item);
      $select_item->execute();
      if ($select_item->fetchColumn() > 0){
        $errorMsg = 'รหัสบาร์โค้ดมีรายการซ้ำ!!!';
      }elseif(empty($unit_id)){
        $errorMsg = "Please enter unit";
      }
      elseif(empty($code_item)){
        $errorMsg = "Please enter code item";
      }
      elseif (empty($item_name)) {
          $errorMsg = "Please enter item name";
      }
    else {
          try {
              if (!isset($errorMsg)) {
                  $insert_stmt = $db->prepare("INSERT INTO item (item_name,code_item,unit_id,price_stock,exd_date) VALUES (:new_item_name,:new_code_item,:new_unit,:new_price_stock,:new_exd_date)");
                  $insert_stmt->bindParam(':new_item_name', $item_name);
                  $insert_stmt->bindParam(':new_code_item', $code_item);
                  $insert_stmt->bindParam(':new_unit', $unit_id);
                  $insert_stmt->bindParam(':new_price_stock', $price_stock);
                  $insert_stmt->bindParam(':new_exd_date', $exd_date);

                 
                  if ($insert_stmt->execute()) {
                      $insertMsg = "Record update successfully...";
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
   
         <!-- <==========================================booystrap 5==================================================> -->
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
<!-- <==========================================booystrap 5==================================================> -->
<!-- <==========================================data-teble==================================================> -->
<script src="../node_modules/data-table/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../node_modules/data-table/datatables.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">    
<!-- <==========================================data-teble==================================================> -->
    <?php include('../components/header.php');?>
    <script>
    $(document).ready(function() {

        $('#stock').DataTable();
    });
    </script>

    
  </head>


    
  </head>
  <body>
    
    <?php include('../components/nav_stock.php'); ?>

    <header>
    
      <div class="display-3 text-xl-center">
        <H2>เพิ่มรายการใหม่ </H2>  
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
    
   <div class="container">
     <div class="row">
     <div class="container col-md-7">
   <form method="post">
   <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">ชื่อรายการ</label>
      <input type="text" class="form-control" name="txt_item_name" id="formGroupExampleInput" placeholder="กระดาษA4,ปากกา,รีเทรินเนอร์........." require>
      </div>
      <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">รหัสบาร์โค้ด</label>
      <input type="text" class="form-control" name="txt_code_item">
      </div>
      
      <div class="mb-4">
      <label for="formGroupExampleInput" class="form-label">หน่วยนับ</label>

      <select type="number" name="txt_unit" id="unit_name"class="form-control">>
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
      <label for="formGroupExampleInput" class="form-label">วันหมดอายุ</label>
      <input type="number" class="form-control" name="txt_exd_date">
      </div>
      <div class="mb-4">
      <input type="submit" name="save" class="btn btn-outline-success" value="Add">
        <a href="item.php" class="btn btn-outline-danger">reset</a>
    </div>
    </form>
  </div>
     </div>
  <hr>
  <div class="text-center"><H2>แสดงข้อมูล</H2></div>
  <br>
   <table class="table table-dark table-hover text-xl-center" id="stock">
    <thead  class="text-center">
      <tr>
        <th>รหัส</th>
        <th scope="col" class="text-center">ชื่อรายการ</th>
        <th>หน่วยนับ</th>
        <th>ราคา(บาท)</th>
        <th scope="col" class="text-center">หมดอายุ</th>
        <th>แก้ไข</th>
        <!-- <th>ลบ</th> -->
      </tr>
    </thead>
    <tbody class=" table-light">
    <?php 
          $select_stmt = $db->prepare("SELECT item_id,code_item,item_name,unit_name,price_stock,exd_date FROM item INNER JOIN unit ON item.unit_id = unit.unit_id  ORDER BY code_item ASC");
          $select_stmt->execute();
          while ($row_item = $select_stmt->fetch(PDO::FETCH_ASSOC)) {?>
      <tr>
        <td ><?php echo $row_item["code_item"]; ?></td>
        <td class="text-left"><?php echo $row_item["item_name"]; ?></td>
        <td><?php echo $row_item["unit_name"]; ?></td>
        <td><?php echo $row_item["price_stock"]; ?></td>
        <?php if($row_item['exd_date'] == null){?>
        <td>ว่าง</td>
        <?php }else{?>
        <td><?php echo $row_item["exd_date"]; ?>(วัน)</td>
        <?php } ?>
        <td><a href="edit/item_edit.php?update_id=<?php echo $row_item["item_id"]; ?>" class="btn btn-outline-warning">View</a></td>
        <!-- <td><a href="?delete_id=<?php echo $row_item["item_id"];?>" class="btn btn-outline-danger">Delete</a></td> -->
        <?php } ?>
      </tr>
    </tbody>
  </table>
   </div>
  </body>
</html>

