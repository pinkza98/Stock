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
        <header>
            <div class="display-3 text-xl-center">
                <H2>PIVOT สต๊อกคลังสาขา </H2>
            </div>
        </header>
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
        <div class="text-center m-4">
            <br>
            <table class="table table-dark table-hover text-xl-center" id="stock">

                <thead class="table-dark">
                    <tr class="table-active">
                        <th scope="col" class="text-center">รหัส</th>
                        <th scope="col" class="text-center">สาขาอารีย์</th>
                        <th scope="col" class="text-center">สาขาอุดมสุข</th>
                        <th scope="col" class="text-center">สาขาอโศก</th>
                        <th scope="col" class="text-center">สาขาสาทร</th>
                        <th scope="col" class="text-center">สาขาอ่อนนุช</th>
                        <th scope="col" class="text-center">สาขาลาดกระบัง</th>
                        <th scope="col" class="text-center">สาขางามวงค์วาน</th>
                        <th scope="col" class="text-center">สาขาแจ้งวัฒนะ</th>
                        <th scope="col" class="text-center">สาขาบางแค</th>
                        <th scope="col" class="text-center">สาขาพระราม2</th>
                        <th scope="col" class="text-center">สาขาพระรามคำแหง</th>
                        <th scope="col" class="text-center">สาขาส่วนกลาง</th>
                        <th scope="col" class="text-center">รวม</th>

                        <!-- <th scope="col" class="text-center">แก้ไข</th>    -->
                        <!-- <th scope="col" class="text-center">ลบ</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php 
            $select_stmt = $db->prepare("SELECT
            it.code_item,
              SUM(IF(bn_stock = 1, quantity, NULL)) AS BN1,
              SUM(IF(bn_stock = 2, quantity, NULL)) AS BN2,
              SUM(IF(bn_stock = 3, quantity, NULL)) AS BN3,
              SUM(IF(bn_stock = 4, quantity, NULL)) AS BN4,
              SUM(IF(bn_stock = 5, quantity, NULL)) AS BN5,
              SUM(IF(bn_stock = 6, quantity, NULL)) AS BN6,
              SUM(IF(bn_stock = 7, quantity, NULL)) AS BN7,
              SUM(IF(bn_stock = 8, quantity, NULL)) AS BN8,
              SUM(IF(bn_stock = 9, quantity, NULL)) AS BN9,
              SUM(IF(bn_stock = 10, quantity, NULL)) AS BN10,
              SUM(IF(bn_stock = 11, quantity, NULL)) AS BN11,
              SUM(IF(bn_stock = 12, quantity, NULL)) AS BN12,
              SUM(CASE WHEN bn_stock=1 or bn_stock=2 or bn_stock=3 or bn_stock=4 or bn_stock=5 or bn_stock=6 or bn_stock=7 or bn_stock=8 or bn_stock=9 or bn_stock=10 or bn_stock=11 or bn_stock=12 THEN quantity ELSE NULL END) AS SUM_BN
            FROM branch_stock bn
            INNER JOIN stock s  on bn.stock_id = s.stock_id
            INNER JOIN item it  on s.item_id = it.item_id
            WHERE
              bn.bn_stock BETWEEN 1 AND 12
            GROUP BY
              it.item_id;");
            $select_stmt->execute();
            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <tr class="table-light">
                        <td><?php echo $row["code_item"]; ?></td>
                        
                        <td><?php echo $row["BN2"]; ?></td>
                        <td><?php echo $row["BN3"]; ?></td>
                        <td><?php echo $row["BN4"]; ?></td>
                        <td><?php echo $row["BN5"]; ?></td>
                        <td><?php echo $row["BN6"]; ?></td>
                        <td><?php echo $row["BN7"]; ?></td>
                        <td><?php echo $row["BN8"]; ?></td>
                        <td><?php echo $row["BN9"]; ?></td>
                        <td><?php echo $row["BN10"]; ?></td>
                        <td><?php echo $row["BN11"]; ?></td>
                        <td><?php echo $row["BN12"]; ?></td>
                        <td><?php echo $row["BN1"]; ?></td>
                        <td><?php echo $row["SUM_BN"]; ?></td>

                        <?php } ?>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="table-active">
                    <th scope="col" class="text-center">รหัส</th>
                        <th scope="col" class="text-center">สาขาอารีย์</th>
                        <th scope="col" class="text-center">สาขาอุดมสุข</th>
                        <th scope="col" class="text-center">สาขาอโศก</th>
                        <th scope="col" class="text-center">สาขาสาทร</th>
                        <th scope="col" class="text-center">สาขาอ่อนนุช</th>
                        <th scope="col" class="text-center">สาขาลาดกระบัง</th>
                        <th scope="col" class="text-center">สาขางามวงค์วาน</th>
                        <th scope="col" class="text-center">สาขาแจ้งวัฒนะ</th>
                        <th scope="col" class="text-center">สาขาบางแค</th>
                        <th scope="col" class="text-center">สาขาพระราม2</th>
                        <th scope="col" class="text-center">สาขาพระรามคำแหง</th>
                        <th scope="col" class="text-center">สาขาส่วนกลาง</th>
                        <th scope="col" class="text-center">รวม</th>

                    </tr>
                </tfoot>
            </table>
        </div>

        <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>