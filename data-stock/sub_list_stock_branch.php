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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/b-1.7.1/datatables.min.css" />
    <script type="text/javascript" src="../node_modules/data-table/bootstrap-table.min.css"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/b-1.7.1/datatables.min.js">
    </script>
    <script>
    $(document).ready(function() {

        $('#stock').DataTable();
    });
    </script>
    <?php include('../components/header.php');?>
</head>

<body>
    <?php include('../components/nav_stock.php'); ?>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/b-1.7.1/datatables.min.js">
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

    <script type="text/javascript" src="node_modules/data-table/bootstrap-table.min.css"></script>
    <!---แก้ไขแล้ว-->
    </head>

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

                        <th scope="col" class="text-center">รหัส</th>
                        <th scope="col" class="text-center">รายการ</th>
                        <th scope="col" class="text-center">จำนวน</th>
                        <th scope="col" class="text-center">ราคา</th>
                        <th scope="col" class="text-center">หมวด</th>
                        <th scope="col" class="text-center">ประเภท</th>
                        <th scope="col" class="text-center">ผู้ลงบันทึก</th>
                        <th scope="col" class="text-center">วัน/เดือน/ปี</th>
                        <th scope="col" class="text-center">สาขา</th>
                        <th scope="col" class="text-center">ผู้ขาย</th>
                        <!-- <th scope="col" class="text-center">ชนิด</th> -->
                        
                        <!-- <th scope="col" class="text-center">รูปภาพประกอบ</th> -->
                        <!-- <th scope="col" class="text-center">แก้ไข</th>    -->
                        <th scope="col" class="text-center">ลบ</th>

                    </tr>
                </thead>
                <tbody>

                    <?php 
          $select_stmt = $db->prepare("SELECT * FROM branch_stock  
          INNER JOIN stock ON branch_stock.stock_id = stock.stock_id
          INNER JOIN item ON stock.item_id = item.item_id
          INNER JOIN catagories ON stock.type_catagories = catagories.catagories_id
          INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
          INNER JOIN unit ON stock.unit = unit.unit_id
          INNER JOIN type_name ON stock.type_item = type_name.type_id
          INNER JOIN user ON branch_stock.user_id = user.user_id
          INNER JOIN vendor ON stock.vendor = vendor.vendor_id
          WHERE bn_stock ='".$row_session["user_bn"]."'
          ORDER BY full_stock_id DESC");
          $select_stmt->execute();
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
                    <tr class="table-light">
                    <td><?php echo $row["code_item"]; ?></td>
                        <td><?php echo $row["item_name"]; ?></td>
                        <td><?php echo $row["quantity"]; ?> <?php echo $row["unit_name"]; ?> </td>
                        <td><?php echo $row["price_stock"]; ?> บาท</td>
                        <td><?php echo $row["catagories_name"]; ?></td>
                        <td><?php echo $row["type_name"]; ?></td>
                        <td><?php echo $row["user_fname"]; ?> <?php echo $row["user_lname"]; ?></td>
                        <td><?php echo DateThai($row["exp_date"]); ?></td>
                        <td><?php echo $row["bn_name"]; ?></td>
                        <td><?php echo $row["vendor_name"]; ?></td>
                        <!-- <td><a href="edit/stock_edit.php?update_id=<?php echo $row["stock_id"]; ?>" class="btn btn-warning">View</a></td> -->
                        <td><a href="?delete_id=<?php echo $row["stock_id"];?>" class="btn btn-danger">Delete</a></td>
                        <?php } ?>
                    </tr>
                </tbody>
                <tfoot a>
                    <tr class="table-active">
                    <th scope="col" class="text-center">รหัส</th>
                        <th scope="col" class="text-center">รายการ</th>
                        <th scope="col" class="text-center">จำนวน</th>
                        <th scope="col" class="text-center">ราคา</th>
                        <th scope="col" class="text-center">หมวด</th>
                        <th scope="col" class="text-center">ประเภท</th>
                        <th scope="col" class="text-center">ผู้ลงบันทึก</th>
                        <th scope="col" class="text-center">วัน/เดือน/ปี</th>
                        <th scope="col" class="text-center">สาขา</th>
                        <th scope="col" class="text-center">ผู้ขาย</th>
                        <!-- <th scope="col" class="text-center">แก้ไข</th> -->
                        <th scope="col" class="text-center">ลบ</th>
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

        <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>