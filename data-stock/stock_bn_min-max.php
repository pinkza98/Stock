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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
    <!-- <==========================================fancybox==================================================> -->

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

        return < > {props.children} </>;
    }

    export default Fancybox;
    </script>
    <?php include('../components/header.php');?>
</head>

<body>
</head>
    <?php include('../components/nav_stock.php'); ?>

    <!---แก้ไขแล้ว-->
  
    
    <body>
        <header></header>
        <div class="display-3 text-xl-center">
            <H2>รายการตั้งค่า min-max ของสาขา : <?php echo $row_session['bn_name']?></H2>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col">
                    <?php include('../components/nav_stock_sild_bn.php'); ?>
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
                        <th scope="col" class="text-center">จำนวนรวม</th>
                        <th scope="col" class="text-center">ค่าmin</th>
                        <th scope="col" class="text-center">ค่าmax</th>
                        <th scope="col" class="text-center">Update</th>
                        <!-- <th scope="col" class="text-center">แก้ไข</th>    -->
                        <!-- <th scope="col" class="text-center">ลบ</th>   -->

                    </tr>
                </thead>
                <tbody>
                    <?php 
          $select_stmt = $db->prepare("SELECT branch_stock.stock_id,code_item,item_name,bn_stock,SUM(item_quantity) as quantity ,stock_min,stock_max,unit_name FROM branch_stock 
INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log 
INNER JOIN stock ON branch_stock.stock_id = stock.stock_id
 INNER JOIN item ON stock.item_id = item.item_id
 INNER JOIN division ON stock.division_id = division.division_id
 INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
 INNER JOIN unit ON  item.unit_id = unit.unit_id
 INNER JOIN type_item ON stock.type_id = type_item.type_id
  INNER JOIN nature ON stock.nature_id = nature.nature_id
WHERE bn_stock = 7 GROUP BY stock_id ORDER BY stock_id ASC;");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
                    <tr class="table-light text-left">
                        <td><?php echo $row["code_item"]; ?></td>
                        <td><?php echo $row["item_name"]; ?></td>
                        <td><?php echo $row["quantity"];?> (<?php  echo$row["unit_name"];?>)</td>
                        <td><input type="text" name="" placeholder="min"/></td>
                        <td><input type="text" name="" placeholder="max"/></td>
                        <td><button>update</button></td>
                        <?php } ?>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <th scope="col" class="text-center"></th>
                        <th scope="col" class="text-center"></th>
                        <th scope="col" class="text-center"></th>
                        <th scope="col" class="text-center"></th>
                        <th scope="col" class="text-center"></th>
                        <th scope="col" class="text-center"></th>
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
    </body>

</html>
<?php if($row_session['user_lv']==1){?>
    <script>
    $(document).ready(function() {

        $('#stock').DataTable({});
    });
    </script>
    <?php }else{?>
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
      <?php }?>