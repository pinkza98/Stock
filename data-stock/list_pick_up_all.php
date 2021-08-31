<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['delete_id'])) {
      $stock_id = $_REQUEST['delete_id'];
      $select_stmt = $db->prepare("SELECT * FROM stock WHERE stock_id = :new_stock_id");
      $select_stmt->bindParam(':new_stock_id', $stock_id);
      $select_stmt->execute();
      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
      // Delete an original record from db
      $delete_stmt = $db->prepare('DELETE FROM stock WHERE stock_id = :new_stock_id');
      $delete_stmt->bindParam(':new_stock_id', $stock_id);
      $delete_stmt->execute();
        header('Location:stock_main.php');
    }
?>
<link rel="icon" type="image/png" href="../components/images/tooth.png" />
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <title>Plus dental clinic</title>

   
<!-- <==========================================booystrap 5==================================================> -->
<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- <==========================================booystrap 5==================================================> -->

  <!-- <==========================================data-teble==================================================> -->
  <script src="../node_modules/data-table/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="../node_modules/data-table/datatables.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">    
  <link rel="stylesheet" href="../node_modules/data-table/dataTables.bootstrap.min.css" />  
  <!---แก้ไขแล้ว--> 
  <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<!-- <==========================================data-teble==================================================> -->
<!-- <==========================================fancybox==================================================> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
<!-- <==========================================fancybox==================================================> -->
<!---แก้ไขแล้ว-->
    <script>
    $(document).ready(function() {

        $('#stock').DataTable({
            dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
        });
    });
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
    <?php include('../components/header.php');?>
</head>

<body>
    <?php include('../components/nav_stock.php'); ?>
    
    
   

    <body>
        <header></header>
        <div class="display-3 text-xl-center">
            <H2>รายการคลังทุกสาขา </H2>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col">
                    <?php include('../components/nav_stock_sild_all.php'); ?>
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
                        <th scope="col" class="text-center">วันที่เบิก</th>
                        <th scope="col" class="text-center">ผู้เบิก</th>
                        <th scope="col" class="text-center">สาขา</th>
                        <th scope="col" class="text-center">รูปภาพ</th>
                        <!-- <th scope="col" class="text-center">แก้ไข</th>    -->
                        <!-- <th scope="col" class="text-center">ลบ</th>   -->

                    </tr>
                </thead>
                <tbody>
                    <?php 
          $select_stmt = $db->prepare("SELECT stock.stock_id,code_item,item_name,quantity,user_fname,user_lname,unit_name,bn_name,img_stock,date FROM cut_stock_log  
          INNER JOIN stock ON cut_stock_log.stock_id = stock.stock_id
          INNER JOIN item ON stock.item_id = item.item_id
          INNER JOIN catagories ON stock.type_catagories = catagories.catagories_id
          INNER JOIN branch ON cut_stock_log.bn_id = branch.bn_id
          INNER JOIN unit ON item.unit = unit.unit_id
          INNER JOIN user ON cut_stock_log.user_id = user.user_id
          INNER JOIN type_name ON stock.type_item = type_name.type_id
          ORDER BY cut_stock_id DESC LIMIT 50");
         
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
                    <tr class="table-light text-danger">
                        <td><?php echo $row["code_item"]; ?></td>
                        <td><?php echo $row["item_name"]; ?></td>
                        <td><?php echo $row["quantity"];?><?php  echo$row["unit_name"];  ?></td>
                        <td><?php echo DateThai($row["date"]); ?></td>
                        <td><?php echo $row["user_fname"];?> <?php echo $row["user_lname"]  ?></td>
                        <td><?php echo $row["bn_name"]; ?></td>
                        <?php if($row['img_stock']!=='' &&$row['img_stock']!=null){?> 
                        <td><button data-fancybox="gallery"data-src="img_stock/<?php echo $row['img_stock']?>"className="button button--secondary"><img src="img_stock//<?php echo $row['img_stock'] ?>" width="25" height="25" alt=""></button>
                        <?php }else{?>
                        <td>-</td>
                        <?php } ?>
                        <!-- <td><a href="edit/stock_edit.php?update_id=<?php echo $row["stock_id"]; ?>" class="btn btn-warning">View</a></td> -->
                        <!-- <td><a href="?delete_id=<?php echo $row["stock_id"];?>" class="btn btn-danger">Delete</a></td>  -->
                        <?php } ?>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="table-active">
                    <th scope="col" class="text-center">รหัสบาร์โค้ด</th>
                        <th scope="col" class="text-center">ชื่อรายการ</th>
                        <th scope="col" class="text-center">จำนวน</th>
                        <th scope="col" class="text-center">วันที่เบิก</th>
                        <th scope="col" class="text-center">ผู้เบิก</th>
                        <th scope="col" class="text-center">สาขา</th>
                        <th scope="col" class="text-center">รูปภาพ</th>
                        <!-- <th scope="col" class="text-center">แก้ไข</th> -->
                        <!-- <th scope="col" class="text-center">ลบ</th> -->
                    </tr>
                </tfoot>
            </table>
        </div>
<?php 
function DateThai($strDate)
{
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));
    
    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
?>
<!-- <==========================================fancybox==================================================> -->

  <!-- <==========================================fancybox==================================================> -->
 
    </body>

</html>