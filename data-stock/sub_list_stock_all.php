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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <title>Plus dental clinic</title>
 <!-- liberty ทำงานในคำสั่งตามที่คาดหัวไว้ -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
<!-- <==========================================booystrap 5==================================================> -->
<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- <========================================== jquery ==================================================> -->
<script src="../node_modules/jquery/dist/jquery.js"></script>
  <!-- <==========================================data-teble==================================================> -->
  <script type="text/javascript" src="../node_modules/data-table/jquery-table-2.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">    
  <link rel="stylesheet" href="../node_modules/data-table/dataTables.bootstrap.min.css" />  
  <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<!-- <==========================================data-teble==================================================> -->
   
    <?php include('../components/header.php');?>
    <style>
        tfoot input {
        width: 100%;
        padding: 0px;
        box-sizing: content-box;
        color: black;
    }
    </style>

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
        <div class="m-5">
            <br>
            <table class="table table-dark table-hover text-xl-center" id="stock_sub">

<thead class="table-dark">
    <tr class="table-active">

        <th scope="col" class="text-center">รหัส</th>
        <th scope="col" class="text-center">รายการ</th>
        <th scope="col" class="text-center">จำนวน</th>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-center">ราคา</th>
        <th scope="col" class="text-center">ประเภท</th>
        <th scope="col" class="text-center">ลักษณะ</th>
        <th scope="col" class="text-center">แผนก</th>
        <th scope="col" class="text-center">ผู้บันทึก</th>
        <th scope="col" class="text-center">วันที่เพิ่ม</th>
        <th scope="col" class="text-center">หมดอายุ</th> 
        <th scope="col" class="text-center">สาขา</th>
        <th scope="col" class="text-center">ผู้ขาย</th>

    </tr>
</thead>
<tbody>

    <?php 
$select_stmt = $db->prepare("SELECT division_name,nature_name,price_stock_log,full_stock_id,bn_stock,code_item,item_name,item_quantity,price_stock,type_name,unit_name,exp_date_log ,exd_date_log,bn_name,vendor_name,user_name_log FROM branch_stock  
INNER JOIN stock ON branch_stock.stock_id = stock.stock_id
INNER JOIN item ON stock.item_id = item.item_id
INNER JOIN unit ON item.unit_id = unit.unit_id
INNER JOIN type_item ON stock.type_id = type_item.type_id
INNER JOIN division ON stock.division_id = division.division_id
INNER JOIN nature ON stock.nature_id = nature.nature_id
INNER JOIN vendor ON stock.vendor_id = vendor.vendor_id
INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
WHERE item_quantity != 0
ORDER BY full_stock_id DESC");
$select_stmt->execute();
while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
?>
    <tr class="table-light">
        <td><?php echo $row["code_item"]; ?></td>
        <td><?php echo $row["item_name"]; ?></td>
        <td><?php echo $row["item_quantity"]; ?> </td>
        <td><?php echo $row["unit_name"]; ?> </td>
        <td><?php echo number_format($row["price_stock_log"],2); ?> </td>
        
        <td><?php echo $row["type_name"]; ?></td>
        <td><?php echo $row["nature_name"]; ?></td>
        <td><?php echo $row["division_name"]; ?></td>
        <td><?php echo $row["user_name_log"]; ?></td>
        <td><?php echo DateThai($row["exp_date_log"]); ?></td>
        <?php 
            date_default_timezone_set("Asia/Bangkok");
                $date_now=date("Y-m-d");
            $exd_2 = $row["exd_date_log"];
            $exd_date =DateDiff($date_now,$exd_2);
            if($exd_date > 1 && $exd_date < 400 OR $exd_date == NULL){
        ?>
        <td>ในอีก <?php echo number_format($exd_date); ?>(วัน)</td>
        <?php }else {?>
            <td>-</td>
            <?php }?>
        <td><?php echo $row["bn_name"]; ?></td>
        <td><?php echo $row["vendor_name"]; ?></td>  
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
        <th scope="col" class="text-center"></th>
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
//functionในการ แปลงวันที่เป็นภาษาไทย
function DateThai($strDate)
{
$strYear = date("Y",strtotime($strDate))+543;
$strMonth= date("n",strtotime($strDate));
$strDay= date("j",strtotime($strDate));

$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$strMonthThai=$strMonthCut[$strMonth];
return "$strDay $strMonthThai $strYear";
}
//function สำหรับคำนวณวันที่
function DateDiff($strDate1,$strDate2)
            {
                        return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
            }
            function TimeDiff($strTime1,$strTime2)
            {
                        return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
            }
            function DateTimeDiff($strDateTime1,$strDateTime2)
            {
                        return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
            }
?>
</body>
</html>
<!-- function ในการกำหนดสิทธิ์ใช้งาน table data -->
<?php if($row_session['user_lv']==1){?>
    <script>
    $(document).ready(function() {

        $('#stock_sub').DataTable({
        });
    });
    </script>
    <?php }else{?>
        <script>
         $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#stock_sub tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#stock_sub').DataTable({
        dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
          "lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50,100, "All"] ],
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