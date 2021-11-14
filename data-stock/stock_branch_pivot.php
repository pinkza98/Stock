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
    <!-- <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- <==========================================booystrap 5==================================================> -->

    <!-- <==========================================data-teble==================================================> -->
    <script src="../node_modules/data-table/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../node_modules/data-table/datatables.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <!-- <==========================================data-teble==================================================> -->
  


    <?php include('../components/header.php');?>
    
</head>

<body>
    
    <?php include('../components/nav_stock.php'); ?>
    

    <header>
        <div class="display-3 text-xl-center">
            <H2>PIVOT สต๊อกคลังสาขา : <?php echo $row_session['bn_name']; ?> </H2>
        </div>
    </header>
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
    <div  class="tableFixHead"style ="width:1900; word-wrap: break-word">
        <br>
        <table class="table table-hover text-center m-2 " id="stock">
            <thead class="table-dark">
                <tr>
                    <th class="text-center ">รหัส</th>
                    <th class="text-center ">รายการ</th>
                    <th class="text-center ">หน่วย</th>
                    <th class="text-center ">ผู้ขาย</th>
                    <th class="text-center ">ราคา</th>
                    <th class="text-center">คลัง :<?php echo $row_session['bn_name'];?></th>
                    <th class="text-center">ธุระกรรม</th>
                    <th class="text-center">จำนวน</th>
                    <th class="text-center">ผู้ดำเนินการ</th>
                
                    
                </tr>
            </thead>
            <tbody class="table-light">
                <tr>

                </tr>
            </tbody>
        </table>
    </div>

    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php if($row_session['user_lv']==1){?>
    <script>
    $(document).ready(function() {

        var table = $('#stock').DataTable({
            fixedHeader: {
                header: true
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "../fetch_stock.php?page=4",
                type: "POST"
            },
            "searching": true,
            "lengthChange": false,
            "paging": false


        });

    });
    </script>
    <?php }else{?>
        <script>
    $(document).ready(function() {

        var table = $('#stock').DataTable({
            fixedHeader: {
                header: true
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "../fetch_stock.php?page=4",
                data: { user_bn: "<?php echo $row_session['user_bn'] ?>"},
                type: "POST"
            },
            dom: 'lBfrtip',
            buttons: [
                'excel', 'print'
            ],
            "searching": true,
            "lengthChange": false,
            "paging": false
        });
    });
    </script>

      <?php }?>