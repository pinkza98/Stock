<?php  
include("../database/db.php");

if($_POST['stock_id']){
    
    $number = count($_POST['stock_id']);
    for($i=0; $i< $number; $i++){  
        $bn_stock =$_POST['bn_stock'][$i];
        $stock_id=$_POST['stock_id'][$i];
        $stock_min=$_POST['sum_min'][$i];
        $stock_max=$_POST['sum_max'][$i];

        $select_stock_bn = $db->prepare("SELECT stock_id,bn_stock,stock_min,stock_max FROM branch_stock WHERE stock_id = '$stock_id' AND bn_stock = '$bn_stock'");
        $select_stock_bn->execute();
        $row_stock_bn = $select_stock_bn->fetch(PDO::FETCH_ASSOC);
        if($row_stock_bn['stock_min'] != $stock_min || $row_stock_bn['stock_max'] != $stock_max){
            $update_stock_bn = $db->prepare("UPDATE branch_stock SET stock_min = '$stock_min', stock_max = '$stock_max' WHERE stock_id = '$stock_id' AND bn_stock = '$bn_stock'");
            $update_stock_bn->execute();
        }
    }
    echo "update การตั้งค่า min-max สำเร็จ!!";
}else{
    echo false;
}
?>