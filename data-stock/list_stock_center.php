<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['delete_id'])) {
      $full_stock_id = $_REQUEST['delete_id'];
      $select_stmt = $db->prepare("SELECT * FROM branch_stock WHERE full_stock_id  = :new_stock_id");
      $select_stmt->bindParam(':new_stock_id', $full_stock_id);
      $select_stmt->execute();
      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
      // Delete an original record from db
      $delete_stmt = $db->prepare('DELETE FROM branch_stock WHERE full_stock_id  = :new_stock_id');
      $delete_stmt->bindParam(':new_stock_id', $full_stock_id);
      $delete_stmt->execute();
        header('Location:list_stock_center.php');
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
  </head>
  <body>
    <?php include('../components/nav_stock.php'); ?>
    <!-- <==========================================boostrap5==================================================> -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- <==========================================ajax-jquery==================================================> -->
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
          <!-- <==========================================data-teble==================================================> -->
          <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/b-1.7.1/datatables.min.js"></script>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">         
          <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
          <script type="text/javascript" src="node_modules/data-table/bootstrap-table.min.css"></script>  <!---แก้ไขแล้ว--> 
    <!-- <==========================================data-teble==================================================> -->
    <!-- <==========================================fancybox==================================================> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
    <!-- <==========================================fancybox==================================================> -->
    <script>
        $(document).ready( function () {
            
        $('#stock').DataTable();
            } );
    </script>
    <script>
      function Fancybox(props) {
      const delegate = props.delegate || "[data-fancybox]";

      useEffect(() => {
        NativeFancybox.assign(delegate, props.options || {});

        return () => {
          NativeFancybox.trash(delegate);

          NativeFancybox.close(true);
        };
      }, []);

      return <>{props.children}</>;
    }

    export default Fancybox;
    </script>
  </head>
  <body>
    <header></header>
      <div class="display-3 text-xl-center">
      <H2>รายการคลังส่วนกลาง </H2>
      </div>
      <hr>
      <div class="container">
        <div class="row">
          <div class="col">
      <?php include('../components/nav_stock_slid.php'); ?>
      </div>
      </div>
      </div>
    </header>
    <?php include('../components/content.php')?>
  <div class="container">
    <br>
    <table class="table table-dark table-hover text-xl-center" id="stock">
    <thead class="table-dark">
        <tr class="table-active">
            
             <th scope="col" class="text-center">รหัสบาร์โค้ด</th>
             <th scope="col" class="text-center">ชื่อรายการ</th> 
             <th scope="col" class="text-center">จำนวน</th>
             <th scope="col" class="text-center">หมวดหมู่</th>
             <th scope="col" class="text-center">ประเภท</th>
             <th scope="col" class="text-center">สาขา</th>
            <th scope="col" class="text-center">รูปภาพประกอบ</th>
            <!-- <th scope="col" class="text-center">แก้ไข</th>    -->
            <th scope="col" class="text-center">ลบ</th>  
            
        </tr>
    </thead>
    <tbody >
    <?php 
          $select_stmt = $db->prepare("SELECT * FROM branch_stock  
          INNER JOIN stock ON branch_stock.stock_id = stock.stock_id
          INNER JOIN item ON stock.item_id = item.item_id
          INNER JOIN catagories ON stock.type_catagories = catagories.catagories_id
          INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
          INNER JOIN unit ON stock.unit = unit.unit_id
          INNER JOIN type_name ON stock.type_item = type_name.type_id
          WHERE bn_stock =1
          ORDER BY full_stock_id DESC");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <tr  class="table-light">
         <td><?php echo $row["code_item"]; ?></td>
         <td><?php echo $row["item_name"]; ?></td> 
         <td><?php echo $row["quantity"]; ?> <?php echo $row["unit_name"]; ?> </td>
         <td><?php echo $row["catagories_name"]; ?></td>
         <td><?php echo $row["type_name"]; ?></td>
         <td><?php echo $row["bn_name"]; ?></td>
         <?php if($row['img_stock']!=='' &&$row['img_stock']!=null){?>
        <td><button data-fancybox="gallery"data-src="img_stock/<?php echo $row['img_stock']?>"className="button button--secondary"><img src="img_stock/<?php echo $row['img_stock'] ?>" width="25" height="25" alt=""></button>
        </td>
        <?php }else{ ?>
        <td>-</td>
        <?php } ?>
        <!-- <td><a href="edit/stock_edit.php?update_id=<?php echo $row["full_stock_id"]; ?>" class="btn btn-warning">View</a></td> -->
         <td><a href="?delete_id=<?php echo $row["full_stock_id"];?>" class="btn btn-danger">Delete</a></td> 
        <?php } ?>
      </tr>
    </tbody>
    <tfoot  a>
            <tr class="table-active">
             <th scope="col" class="text-center">รหัสบาร์โค้ด</th>
             <th scope="col" class="text-center">ชื่อรายการ</th>
             <th scope="col" class="text-center">จำนวน</th>
             <th scope="col" class="text-center">หมวดหมู่</th>
             <th scope="col" class="text-center">ประเภท</th>
             <th scope="col" class="text-center">สาขา</th>
            <th scope="col" class="text-center">รูปภาพประกอบ</th>
            <!-- <th scope="col" class="text-center">แก้ไข</th> -->
            <th scope="col" class="text-center">ลบ</th>
            </tr>
        </tfoot>
  </table>
  </div>
  <!-- <==========================================fancybox==================================================> -->
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
  <!-- <==========================================fancybox==================================================> -->
  <!-- <==========================================booystrap 5==================================================> -->
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <==========================================booystrap 5==================================================> -->
  </body>
</html>