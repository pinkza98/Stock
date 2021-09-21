<?php 
    require_once('../database/db.php');
 
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
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
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
        <H2>รายการขนส่ง </H2>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col">
                <?php include('../components/nav_transfer_status.php'); ?>   
            </div>
        </div>
    </div>
    </header>
    <?php include('../components/content.php')?>
    <div class="m-5">
        <br>
        <table class="table table-dark table-hover text-xl-center" id="stock">

            <thead class="table-dark">
                <tr class="table-active">
                    <th scope="col" class="text-center">รหัสติดตาม</th>
                    <th scope="col" class="text-center">สาขาส่ง</th>
                    <th scope="col" class="text-center">สาขารับ</th>
                    <th scope="col" class="text-center">ผู้ขอส่ง</th>
                    <th scope="col" class="text-center">ราคา</th>
                    <th scope="col" class="text-center">รายการ</th>
                    <th scope="col" class="text-center">วันที่</th>
                    <th scope="col" class="text-center">อนุมัติ</th>
                    <th scope="col" class="text-center">ไม่อนุมัติ</th>
                </tr>
            </thead>
            <tbody>


            <?php 
          $select_transfer_stock = $db->prepare("SELECT bn_id_1,bn_id_2,transfer_stock.transfer_id,user1,transfer_stock.transfer_date,transfer_name,COUNT(transfer_log_id)as count_log,b1.bn_name as bn_name1 ,b2.bn_name as bn_name2 FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id 
          LEFT JOIN transfer_stock_log ON transfer.transfer_name = transfer_stock_log.transfer_stock_id
          INNER JOIN branch as b1 ON b1.bn_id  = transfer_stock.bn_id_1 
          INNER JOIN branch as b2 ON b2.bn_id  = transfer_stock.bn_id_2 
           GROUP BY transfer_name
          ");
          $select_transfer_stock->execute();
          while ($row_transfer = $select_transfer_stock->fetch(PDO::FETCH_ASSOC)) {?>
          <tr class="table-light">
                    <td><?php echo $row_transfer['transfer_name'];?></td>
                    <td><?php echo $row_transfer['bn_name1'];?></td>
                    <td><?php echo $row_transfer['bn_name2'];?></td>
                    <td><?php echo $row_transfer['user1'];?></td>
                    <td>ราคา</td>
                    <td><button class="btn btn-info"><?php echo $row_transfer['count_log'];?>รายการ</button></td>
                    <td><?php echo DateThai($row_transfer['transfer_date']);?></td>
                    <td><button class="btn btn-success">อนุมัติ</button></td>
                    <td><button class="btn btn-danger">ไม่อนุมัติ</button></td>
                    </tr>
                    <?php }?>
    
            </tbody>
            <tfoot>
                <tr class="table-active">
                    <th scope="col" class="text-center">รหัสติดตาม</th>
                    <th scope="col" class="text-center">สาขาส่ง</th>
                    <th scope="col" class="text-center">สาขารับ</th>
                    <th scope="col" class="text-center">ผู้ขอส่ง</th>
                    <th scope="col" class="text-center">ราคา</th>
                    <th scope="col" class="text-center">รายการ</th>
                    <th scope="col" class="text-center">วันที่</th>
                    <th scope="col" class="text-center">อนุมัติ</th>
                    <th scope="col" class="text-center">ไม่อนุมัติ</th>
                    <!-- <th scope="col" class="text-center">แก้ไข</th> -->
                    <!-- <th scope="col" class="text-center">ลบ</th> -->
                </tr>
            </tfoot>
        </table>
    </div>   
</body>
</html>
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