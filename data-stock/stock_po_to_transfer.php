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
            <H2>รายการส่งออเดอร์ให้สาขา </H2>
        </div>
    </header>
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
    <form id="list_item" name="list_item">
        <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="row g-2">
             
                                <div class="col-sm-6">
                                <?php 
                         
                                        ?>
                                <?php 
                                        $select_bn = $db->prepare("SELECT * FROM branch ORDER BY bn_id DESC");
                                        $select_bn->execute();
                                        ?>

                                <select class="form-select mt-1" name="bn_id" id="bn_id">
                                    <?php  while ($row_bn = $select_bn->fetch(PDO::FETCH_ASSOC)) {?>
                                    <option value="<?php echo$row_bn['bn_id']?>"><?php echo$row_bn['bn_name']?>
                                    </option>
                                    <?php } ?>
                                </select>
                                </div>
                                <div class="col-sm-6">
                                
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <br>
                   
        </div>
                </form>
    
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
                    <th class="text-center ">จำนวน</th>
                    <th class="text-center">มูลค่า</th>
                </tr>
            </thead>
            <tbody class="table-light">
                
                <?php 
                $sel_bn = "lb";
                $select_stock_po = $db->prepare("SELECT code_item,item_name,vendor_name,price_stock,unit_name,$sel_bn FROM stock_po 
                INNER JOIN stock ON stock.stock_id = stock_po.stock_po_id
                LEFT JOIN item ON  item.item_id  =stock.item_id
                LEFT JOIN unit ON item.unit_id = unit.unit_id  
                LEFT JOIN nature ON stock.nature_id = nature.nature_id   
                LEFT JOIN type_item ON stock.type_id = type_item.type_id
                LEFT JOIN vendor ON stock.vendor_id = vendor.vendor_id
                LEFT JOIN division ON stock.division_id = division.division_id
                LEFT JOIN marque ON stock.marque_id = marque.marque_id
                WHERE $sel_bn != 0
                ORDER BY code_item ASC");
                $select_stock_po->execute();
                $sum_order = 0 ;
                while ($row_stock_po = $select_stock_po->fetch(PDO::FETCH_ASSOC)) {
                    $sum_order += $row_stock_po['price_stock']*$row_stock_po[$sel_bn];
                    $sum_po = $row_stock_po['price_stock']*$row_stock_po[$sel_bn];
                   
                ?>
                <tr>
                    <td><?php echo $row_stock_po['code_item'] ?></td>
                    <td><?php echo $row_stock_po['item_name'] ?></td>
                    <td><?php echo $row_stock_po['unit_name'] ?></td>
                    <td><?php echo $row_stock_po['vendor_name'] ?></td>
                    <td><?php echo $row_stock_po['price_stock'] ?></td>
                    <td><?php echo $row_stock_po[$sel_bn] ?></td>
                    <td style="background-color: #82E0AA;color:#21618C"><?php echo $sum_po ?></td>
                    
                </tr>
                <?php }?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center "></th>
                    <th class="text-center "></th>
                    <th class="text-center "></th>
                    <th class="text-center "></th>
                    <th class="text-center"></th>
                    <th class="text-center">รวมมูลค่าทั้งหมด</th>
                    <th class="text-center"><?php echo number_format($sum_order); ?> บาท</th>
                    
                </tr>
            </tfoot>
        </table>
    </div>

   
</body>
</html>
<?php if($row_session['user_lv']==1){?>
    <script>
    $(document).ready(function() {

        var table = $('#stock').DataTable({
            fixedHeader: {
                header: true
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