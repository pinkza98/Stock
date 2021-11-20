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
            <H2>รายการคลังสาขา </H2>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col">
                    <?php include('../components/nav_stock_sild_bn.php'); ?>
                    <?php include('../components/content.php')?>

                </div>
            </div>
        </div>
        </header>
        <div class="m-5">
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

                    </tr>
                </thead>
                <tbody>
                    <?php 
          $select_stmt = $db->prepare("SELECT stock.stock_id,code_item,item_name,quantity,unit_name,bn_name,img_stock,date,user_id FROM cut_stock_log  
          INNER JOIN stock ON cut_stock_log.stock_id = stock.stock_id
          INNER JOIN item ON stock.item_id = item.item_id
          INNER JOIN branch ON cut_stock_log.bn_id = branch.bn_id
          INNER JOIN unit ON item.unit_id = unit.unit_id
          INNER JOIN type_item ON stock.type_id = type_item.type_id
          WHERE cut_stock_log.bn_id = ".$row_session['user_bn']."
          ORDER BY cut_stock_id DESC");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {?>
                    <tr class="table-light text-danger">
                        <td><?php echo $row["code_item"]; ?></td>
                        <td><?php echo $row["item_name"]; ?></td>
                        <td><?php echo $row["quantity"];?><?php  echo$row["unit_name"];  ?></td>
                        <td><?php echo DateThai($row["date"]); ?></td>
                        <td><?php echo $row["user_id"];?></td>
                        <td><?php echo $row["bn_name"]; ?></td>
                        <?php } ?>
                    </tr>
                </tbody>
                <tfoot style="color:black">
                    <tr >
                        <th scope="col" class="text-center">รหัสบาร์โค้ด</th>
                        <th scope="col" class="text-center">ชื่อรายการ</th>
                        <th scope="col" class="text-center">จำนวน</th>
                        <th scope="col" class="text-center">วันที่เบิก</th>
                        <th scope="col" class="text-center">ผู้เบิก</th>
                        <th scope="col" class="text-center">สาขา</th>
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

        var table = $('#stock').DataTable({
          "lengthMenu": [ [10,25, 50,100, -1], [ 10,25, 50,100, "All"] ],
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if (that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
    });
    </script>
    <?php }else{?>
        <script>
         $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#stock tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#stock').DataTable({
        dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
          "lengthMenu": [ [10,25, 50,100, -1], [ 10,25, 50,100, "All"] ],
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if (that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
 
} );
    </script>
      <?php }?>