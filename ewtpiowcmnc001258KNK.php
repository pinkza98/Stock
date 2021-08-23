<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="components/images/tooth.png" />
    <title>Plus Dental Clinic
    </title>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <style type="text/css">
        @import 'https://fonts.googleapis.com/css?family=Kanit|Prompt';

        html,
        body {
            height: 100%;
            /* ให้ html และ body สูงเต็มจอภาพไว้ก่อน */
            margin: 0;
            padding: 0;
            width: 100%;
        }

        div.img-resize img {
            width: 75px;
            height: auto;
        }

        div.img-resize {
            width: 100px;
            height: 60px;
            overflow: hidden;
            text-align: center;
        }

        html {

            font-family: 'Kanit', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        a {
            font-family: 'Kanit', sans-serif;
        }

        header {
            height: 50px;
        }

        footer {
            height: 60px;
            background: black;
        }

        /**** Trick: ****/
        body {
            display: table;
            width: 100%;
        }

        footer {
            display: table-row;
        }table{
            width: 1500px;
        }
       
        </style>

        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    </head>
<body>
    <div class="text-center mt-4">
        <H2>
            หน้าดึงข้อมูล ไป google sheet
        </H2>
    </div>
    <br>
    <div class="m-auto">
        <table class="table table-hover table-dark container-max-auto text-center">
            <thead>
            <tr>
                    <th scope="col" class="text-center">รหัสใหม่</th>
                    <th scope="col" class="text-center">รหัสรหัสเก่า</th>
                    <th scope="col" class="text-center">รายการ</th>
                    <th scope="col" class="text-center">ผู้ขาย</th>
                    <th scope="col" class="text-center">หน่วย</th>
                    <th scope="col" class="text-center">ราคา</th>
                    <th scope="col" class="text-center">ชนิด</th>
                    <th scope="col" class="text-center">ประเภท</th>
                    <th scope="col" class="text-center">ลักษณะ</th>
                    <th scope="col" class="text-center">ฝ่าย</th>
                    <th scope="col" class="text-center">รามคำแหง</th>
                    <th scope="col" class="text-center">อารีย์</th>
                    <th scope="col" class="text-center">สาทร</th>
                    <th scope="col" class="text-center">อโศก</th>
                    <th scope="col" class="text-center">อ่อนนุช</th>
                    <th scope="col" class="text-center">อุดมสุข</th>
                    <th scope="col" class="text-center">งามวงค์วาน</th>
                    <th scope="col" class="text-center">แจ้งวัฒนะ</th>
                    <th scope="col" class="text-center">พระราม2</th>
                    <th scope="col" class="text-center">ลาดกระบัง</th>
                    <th scope="col" class="text-center">บางแค</th>
                    <th scope="col" class="text-center">สาขาส่วนกลาง</th>
                    <th scope="col" class="text-center">รวม</th>
                </tr>
            </thead>
            <tbody>
                <?php 
    require_once('database/db.php');
    $select_stmt = $db->prepare("SELECT

    it.code_item,it.code_item_archaic,unit_name,item_name,v.vendor_name,type_name,catagories_name,cotton_name,nature_name,price_stock,

      SUM(IF(bn_stock = 1, item_quantity, 0)) AS BN1,
      SUM(IF(bn_stock = 2, item_quantity, 0)) AS BN2,
      SUM(IF(bn_stock = 3, item_quantity, 0)) AS BN3,
      SUM(IF(bn_stock = 4, item_quantity, 0)) AS BN4,
      SUM(IF(bn_stock = 5, item_quantity, 0)) AS BN5,
      SUM(IF(bn_stock = 6, item_quantity, 0)) AS BN6,
      SUM(IF(bn_stock = 7, item_quantity, 0)) AS BN7,
      SUM(IF(bn_stock = 8, item_quantity, 0)) AS BN8,
      SUM(IF(bn_stock = 9, item_quantity, 0)) AS BN9,
      SUM(IF(bn_stock = 10, item_quantity, 0)) AS BN10,
      SUM(IF(bn_stock = 11, item_quantity, 0)) AS BN11,
      SUM(IF(bn_stock = 12, item_quantity, 0)) AS BN12,
      SUM(CASE WHEN bn_stock=1 or bn_stock=2 or bn_stock=3 or bn_stock=4 or bn_stock=5 or bn_stock=6 or bn_stock=7 or bn_stock=8 or bn_stock=9 or bn_stock=10 or bn_stock=11 or bn_stock=12 THEN item_quantity ELSE NULL END) AS SUM_BN
    FROM branch_stock bn
    INNER JOIN stock s  on bn.stock_id = s.stock_id
    INNER JOIN vendor v  on s.vendor = v.vendor_id
    INNER JOIN item it  on s.item_id = it.item_id
    INNER JOIN unit u  on it.unit = u.unit_id
    INNER JOIN type_name ty  on s.type_item = ty.type_id
    INNER JOIN catagories c  on s.type_catagories = c.catagories_id
    INNER JOIN cotton ct  on s.cotton_id = ct.cotton_id
    INNER JOIN nature n  on s.nature_id = n.nature_id

    
    INNER JOIN  branch_stock_log bsl  on bn.full_stock_id = bsl.full_stock_id_log
    WHERE
      bn.bn_stock BETWEEN 1 AND 12
    GROUP BY
      it.item_id;");
    $select_stmt->execute();
    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
                <tr class="table-light">
                    <td><?php echo $row["code_item"]; ?></td>
                    <td><?php echo $row["code_item_archaic"]; ?></td>
                    <td><?php echo $row["item_name"]; ?></td>
                    <td><?php echo $row["vendor_name"]; ?></td>
                    <td><?php echo $row["unit_name"]; ?></td>
                    <td><?php echo $row["price_stock"]; ?></td>
                    <td><?php echo $row["type_name"]; ?></td>
                    <td><?php echo $row["catagories_name"]; ?></td>
                    <td><?php echo $row["nature_name"]; ?></td>
                    <td><?php echo $row["cotton_name"]; ?></td>
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
        </table>
    </div>
</body>
</html>