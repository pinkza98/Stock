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
        $price = $_POST["transfer_price"][$i];
        $check = 1;
        $select_transfer_stock = $db->prepare("SELECT transfer_stock_id,transfer_qty_set,transfer_note,transfer_qty,stock_id  FROM transfer_stock_log WHERE transfer_stock_id = '$code' AND stock_id=$stock_id");
        $select_transfer_stock ->execute();
        $row_count = $select_transfer_stock->rowCount();
            while ($row = $select_transfer_stock->fetch(PDO::FETCH_ASSOC) ) {
                if($row_count > $check){
                    $check++;
                }else{
                    if(($row['transfer_note'] != $code  )){
                        $insert_transfer_log = $db->prepare("INSERT INTO transfer_stock_log (transfer_stock_id,stock_id,transfer_qty_set,transfer_price,transfer_note) VALUES ('$code','$stock_id','$sum_qty_set',$price,'$code')");
                        $insert_transfer_log->execute();
                        
                        
                    } else{
                        if($row['sum_qty_set']!= 0 and $row['sum_qty_set'] != null){
                            $update_transfer_log = $db->prepare("UPDATE transfer_stock_log SET transfer_qty_set ='$sum_qty_set'  WHERE transfer_note  ='$code' AND  stock_id ='$stock_id'");
                            $update_transfer_log->execute();
                        }
                       
                    }
                    
                    }
                }
        }
           
        
        
   
    }


?> 
<!-- AND $row['stock_id']==$stock_id AND $row['transfer_qty'] == NULL -->