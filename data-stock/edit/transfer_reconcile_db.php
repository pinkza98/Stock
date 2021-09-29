<?php 
include("../../database/db.php");
if(empty($_POST['stock_id'])){
    $errorMsg=false;
}else{
$number = count($_POST['stock_id']);
    for($i=0; $i< $number; $i++){  
        $sum_qty_set = $_POST["sum_qty_set"][$i];
        $stock_id = $_POST["stock_id"][$i]; 
        $code = $_POST["code"][$i];
        $sum_qty = $_POST["sum_qty"][$i];
        $select_transfer_stock = $db->prepare("SELECT transfer_stock_id,transfer_qty_set,transfer_note,transfer_qty,stock_id  FROM transfer_stock_log WHERE transfer_stock_id = '$code' AND stock_id='$stock_id'  GROUP BY transfer_stock_id");
        

        if($select_transfer_stock ->execute()){

            $row = $select_transfer_stock->fetch(PDO::FETCH_ASSOC);
      
            if(($row['transfer_note'] != $code AND $row['stock_id']==$stock_id AND $row['transfer_qty'] == NULL )){
                $insert_transfer_log = $db->prepare("INSERT INTO transfer_stock_log (transfer_stock_id,stock_id,transfer_qty_set,transfer_note) VALUES ('$code','$stock_id','$sum_qty_set','$code')");
                $insert_transfer_log->execute();
            }else{
                $update_transfer_log = $db->prepare("UPDATE transfer_stock_log SET transfer_qty_set ='$sum_qty_set'  WHERE transfer_note  ='$code' ");
                 $update_transfer_log->execute();
            }
           
        }
        
   
    }
}

?> 