<?php  
include("../database/db.php"); // เชื่อมต่อไฟล์ฐานข้อมูล

if($_POST['stock_id']){ //ถ้าหากมี การส่งค่า post มาจากฟอร์ม
    
    $number = count($_POST['stock_id']); //นับจำนวนข้อมูลที่ส่งมา
    for($i=0; $i< $number; $i++){  //วนลูปแสดงข้อมูล
        $bn_stock =$_POST['bn_stock'][$i];
        $stock_id=$_POST['stock_id'][$i];
        $stock_min=$_POST['sum_min'][$i];
        $stock_max=$_POST['sum_max'][$i];
        //ดึงข้อมูลจาก ตางราง branch_stock
        $select_stock_bn = $db->prepare("SELECT stock_id,bn_stock,stock_min,stock_max FROM branch_stock WHERE stock_id = '$stock_id' AND bn_stock = '$bn_stock'");
        $select_stock_bn->execute();
        //ดึงข้อมูลที่ได้จาก branch_stock มาใช้งาน โดนเก็บไว้ที่ตัวแปร row_stock_bn
        $row_stock_bn = $select_stock_bn->fetch(PDO::FETCH_ASSOC);
        if($row_stock_bn['stock_min'] != $stock_min || $row_stock_bn['stock_max'] != $stock_max){ //ถ้าหากข้อมูลที่ส่งมาไม่เท่ากับข้อมูลที่มีอยู่ในตาราง branch_stock
            $update_stock_bn = $db->prepare("UPDATE branch_stock SET stock_min = '$stock_min', stock_max = '$stock_max' WHERE stock_id = '$stock_id' AND bn_stock = '$bn_stock'");
            $update_stock_bn->execute(); //ทำการ update ค่าmin-max เดิมที่มีอยู่ในตาราง branch_stock
        }
    }
    echo "update การตั้งค่า min-max สำเร็จ!!";
}else{
    echo false;
}
?>