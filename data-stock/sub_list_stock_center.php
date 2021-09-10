<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['delete_id'])) {
      $stock_id = $_REQUEST['delete_id'];
      $select_stmt = $db->prepare("SELECT stock_log_id FROM branch_stock_log WHERE stock_log_id  = :new_stock_id");
      $select_stmt->bindParam(':new_stock_id', $stock_id);
      $select_stmt->execute();
      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
      // Delete an original record from db
      $delete_branch_stock = $db->prepare('DELETE FROM branch_stock WHERE full_stock_id  = :new_stock_id');
      $delete_branch_stock->bindParam(':new_stock_id', $stock_id);
      $delete_branch_stock_log = $db->prepare('DELETE FROM branch_stock_log WHERE stock_log_id  = :new_stock_id');
      $delete_branch_stock_log->bindParam(':new_stock_id', $stock_id);
      if($delete_branch_stock_log->execute()){
          $delete_branch_stock->execute();
        $insertMsg = "ลบข้อมูลสำเร็จ...";
      }
        // header('Location:sub_list_stock_branch.php');
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
    <!-- <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- <==========================================booystrap 5==================================================> -->

    <!-- <==========================================data-teble==================================================> -->
    <link rel="stylesheet" href="../node_modules/data-table/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="../node_modules/data-table/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../node_modules/data-table/datatables.min.js"></script>
    <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <!-- <==========================================data-teble==================================================> -->
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
    <?php include('../components/header.php');?>
</head>

<body>
    <?php include('../components/nav_stock.php'); ?>

    <header></header>
    <div class="display-3 text-xl-center">
        <H2>รายการคลังของส่วนกลาง </H2>
    </div>
    <hr>
    <div class="container">
    <?php 
        if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success mb-2">
            <strong>เยี่ยม! <?php echo $insertMsg; ?></strong>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col">
                <?php include('../components/nav_stock_slid.php'); ?>   
            </div>
        </div>
    </div>
    </header>
    <?php include('../components/content.php')?>
    <div class="m-4">
        <br>
        <table class="table table-dark table-hover text-xl-center" id="stock">

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
                    <th scope="col" class="text-center">ลบ</th>
                </tr>
            </thead>
            <tbody>

            <?php 
$select_stmt = $db->prepare("SELECT full_stock_id,division_name,nature_name,price_stock_log,full_stock_id,bn_stock,code_item,item_name,item_quantity,price_stock,type_name,unit_name,exp_date_log ,exd_date_log,bn_name,vendor_name,user_name_log FROM branch_stock  
INNER JOIN stock ON branch_stock.stock_id = stock.stock_id
INNER JOIN item ON stock.item_id = item.item_id
INNER JOIN unit ON item.unit_id = unit.unit_id
INNER JOIN type_item ON stock.type_id = type_item.type_id
INNER JOIN division ON stock.division_id = division.division_id
INNER JOIN nature ON stock.nature_id = nature.nature_id
INNER JOIN vendor ON stock.vendor_id = vendor.vendor_id
INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
WHERE item_quantity != 0 AND bn_stock = 1
ORDER BY exp_date_log DESC");
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
        <td><a href="?delete_id=<?php echo $row["full_stock_id"];?>" class="btn btn-danger">Delete</a></td>
        <?php } ?>
    </tr>
            </tbody>
            <tfoot a>
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
                    <th scope="col" class="text-center">ลบ</th>
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

    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>