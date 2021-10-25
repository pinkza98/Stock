<?php 
include("../../database/db.php");
if(empty($_POST['stock_id'])){
    $errorMsg=false;
}
else{
   $bn_stock= $_POST['bn_stock'];
$number = count($_POST['stock_id']);
    for($i=0; $i< $number; $i++){  
        $sum_qty_set = $_POST["sum_qty_set"][$i];
        $sum_qty = $_POST["sum_qty"][$i];
        $sum = $_POST["sum"][$i];
        $stock_id = $_POST["stock_id"][$i]; 
        $code = $_POST["code"][$i];//รหัสtransfer name
        $price = $_POST["transfer_price"][$i];
         $stock_code = $_POST["stock_code"][$i];

         if($sum_qty_set > $sum){
           echo $errorMsg = "ไม่สามารถปรับเกินยอดจำนวนที่มีได้";
         }elseif($sum_qty_set == $sum_qty){ 

         }else{
           echo  $errorMsg=true;
         }


        }
    }


?> 
