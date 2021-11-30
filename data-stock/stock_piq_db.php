<?php  
include("../database/db.php");

if($_POST['stock_id']){
    
    $number = count($_POST['stock_id']);
    for($i=0; $i< $number; $i++){  
        $stock_id=$_POST['stock_id'][$i];
        $date_off=$_POST['date_off'][$i];

        $select_stock_bn = $db->prepare("SELECT stock_id,date_off FROM stock WHERE stock_id = $stock_id");
        $select_stock_bn->execute();
        $row_stock_bn = $select_stock_bn->fetch(PDO::FETCH_ASSOC);
        if($row_stock_bn['date_off'] != $date_off ){
            $update_stock_bn = $db->prepare("UPDATE stock SET date_off = '$date_off' WHERE stock_id = '$stock_id'");
            $update_stock_bn->execute();
        }
    }
    echo "update การตั้งค่าความถี่ สำเร็จ!!";
    
}else{
    echo false;
}
?>