<?php  require_once('database/db.php');?>
<link rel="icon" type="image/png" href="components/images/tooth.png"/>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <title>Plus Dental Clinic</title>
    
    <?php include('components/header.php');?>
   <!-- <==========================================booystrap 5==================================================> -->
<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- <==========================================booystrap 5==================================================> -->

  <!-- <==========================================data-teble==================================================> -->
  <script src="node_modules/data-table/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="node_modules/data-table/datatables.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">    
  <link rel="stylesheet" href="node_modules/data-table/dataTables.bootstrap.min.css" />  

 <script type="text/javascript" src="node_modules/data-table/dataTables_excel.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<!-- <==========================================data-teble==================================================> -->


    
  </head>
  <body>
    <?php include('components/nav.php'); ?>
    <header>
      <div class="display-3 text-xl-center">
      <H2>Plus Dental Clinic</H2>
      </div>
    </header>
    
    <?php include('components/nav_stock_sild_index.php');?>

    <hr>
    <?php include('components/content.php')?>
    <div class="m-4">
    <button class="btn btn-yellow btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    แจ้งประกาศ
  </button>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
   <p>
      อัพเดทแล้ว <br>
     <div style="color:green"> - ปรับหน้า รายการรวม ถูกนำออกไปใช้ตาราง piovt แทนได้ 21/11/2564<br>
      - ปรับหน้า รายการแยกส่วนสาขา การลบข้อมูลถูกนำออกไป ใช่การปรับยอดแทนได้ 21/11/2564<br>
      - สามารถปรับยอดรายการสาขา ได้ที่หน้า piovt สาขา 23/11/2564<br>
      - เพิ่มฟังชั่น piovt สาขาให้มีการข้อมูลในการตรวจเช็คจากการโอน/รับของเพิ่มขึ้นโดยมีเวลาแสดงให้ทราบ 28/11/2564<br>
      - แก้ไข(bug) piovt เบิกรวมให้ดึงยอดที่ถูกต้อง 28/11/2564 <br>
      - หน้ากรอก min-max สาขา แจ้งเตือนหน้า piovt สาขา #ผู้จัดการสาขา (3/12/64)<br>
      - หน้ากำหนด ความถี่รายการสินค้าเพื่อแจ้งเตือน poivt สาขา #AMหรือจัดซื้อ (3/12/64)<br>
      </div>
      รออัพเดทแก้ไข<br>
      <div style="color:yellowgreen">
      - ไม่มี<br>
      </div>
      อัพเดทเพิ่มเติม <br>
      <div style="color:orange">
      - ไม่มี<br>
      </div>
    </p>
  </div>
</div>
    </div>
  <div class="m-4 ">
    <br>
    <table class="table table-dark table-hover  " id="stock">
    <thead class="table-dark ">
        <tr class="table-active">
          <!-- <th scope="col" class="text-center">รหัสรายการ</th> -->
            <th scope="col" class="text-center">รหัส</th>
            <th scope="col" class="text-left">ชื่อรายการ</th>
            <th scope="col" class="text-center">หน่วยนับ</th>
            <th scope="col" class="text-center">ราคา</th>
            <th scope="col" class="text-center">ประเภท</th>
            <th scope="col" class="text-center">ลักษณะ</th>
            <th scope="col" class="text-center">แผนก</th>
            <th scope="col" class="text-center">ยี่ห้อ</th>  
            <th scope="col" class="text-center">ผู้ขาย</th>  
        </tr>
    </thead>
    <tbody class="table-light" >
   
      <tr>
       
      </tr>
    </tbody>
    <tfoot>
            <tr class="table-active">
            <!-- <th scope="col" class="text-center">รหัสรายการ</th> -->
            <th scope="col" class="text-center">รหัส</th>
            <th scope="col" class="text-left">ชื่อรายการ</th>
            <th scope="col" class="text-center">หน่วยนับ</th>
            <th scope="col" class="text-center">ราคา</th>
            <th scope="col" class="text-center">ประเภท</th>
            <th scope="col" class="text-center">ลักษณะ</th>
            <th scope="col" class="text-center">แผนก</th>
            <th scope="col" class="text-center">ยี่ห้อ</th>  
            <th scope="col" class="text-center">ผู้ขาย</th>  

            </tr>
        </tfoot>
  </table>
  </div>

  </body>
</html>
<?php if($row_session['user_lv']==1){?>
    <script>
        $(document).ready( function () {
            
        $('#stock').DataTable({
          
          "processing" : true,
          "serverSide" : true,
          "ajax" : {
            url:"fetch_stock.php?page=1",
            type:"POST"
          },
          "lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50,100, "All"] ]
  });
 });
    </script>
    <?php }else{?>
      <script>
        $(document).ready( function () {
            
        $('#stock').DataTable({
          
          "processing" : true,
          "serverSide" : true,
          "ajax" : {
            url:"fetch_stock.php?page=1",
            type:"POST"
          },
          dom: 'lBfrtip',
          buttons: [
            'excel','print'
          ],
          "lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50,100, "All"] ]
  });
 });
    </script>

      <?php }?>