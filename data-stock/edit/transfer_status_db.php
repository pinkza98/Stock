<?php 
include("../../database/db.php");
if(empty($_POST['stock_id'])){
    $errorMsg=false;
}
else{
  $bn_stock= $_POST['bn_stock'];
  
$number = count($_POST['stock_id']);
    for($i=0; $i< $number; $i++){  
        $quantity = $_POST["sum_qty_set"][$i];
        $sum_qty = $_POST["sum_qty"][$i];
        $sum = $_POST["sum"][$i];
        $stock_id = $_POST["stock_id"][$i]; 
        $price = $_POST["transfer_price"][$i];
        $stock_code = $_POST["stock_code"][$i];
        $code = $_POST["code"][$i];
        if($quantity > $sum){
        echo $errorMsg = "ไม่สามารถปรับเกินยอดจำนวนที่มีได้";
        }elseif($quantity == $sum_qty){ 

        }else{          
            $select_stock_bn = $db->prepare("SELECT * FROM branch_stock INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log WHERE stock_id = '$stock_id'  AND bn_stock = '$bn_stock' AND status_log ='$code'"); //ดึง t_stock_log ทั้งหมด (3)
            $select_stock_bn->execute();
            while ($row_stock_log = $select_stock_bn->fetch(PDO::FETCH_ASSOC)) {
            $update_stock_bn_log = $db->prepare("UPDATE branch_stock_log SET status_log =null,remain_log=null WHERE full_stock_id_log = ".$row_stock_log['full_stock_id_log']." ");
            $update_stock_bn_log->execute();
            }
            $del_transfer_stock_log = $db->prepare("DELETE FROM transfer_stock_log WHERE stock_id =$stock_id AND transfer_stock_id= '".$code."' ");
            $del_transfer_stock_log->execute();

            $select_stock_full_log = $db->prepare("SELECT *  FROM branch_stock_log  
            INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
            WHERE branch_stock.bn_stock = $bn_stock AND branch_stock.stock_id = $stock_id  AND status_log IS NULL  OR status_log ='$code' ORDER BY stock_log_id ASC");
            $select_stock_full_log->execute();
            $row_count = $select_stock_full_log->rowCount();
            $stop_row = 0;
            $i_check=1;
            $result = $quantity;
            while ($row = $select_stock_full_log->fetch(PDO::FETCH_ASSOC) AND $stop_row != 1){
            $date_log = $row['exd_date_log'];
            if($i_check > $row_count){
            if ($row['item_quantity']< $quantity) {
                $quantity = $quantity- $row['item_quantity'];
                    $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$code' ,remain_log=1000  WHERE stock_log_id  = ".$row['stock_log_id']."");
                    if($update_stock_log->execute()){
                        $i_check++;
                    }
                }
            }elseif($i_check <= $row_count){  
            if ($row['item_quantity']> $quantity){
                $quantity_as = $row['item_quantity']-$quantity; 
                $sum_last = $row['item_quantity']-$row['remain_log']; 
                if($quantity_as == $row['item_quantity']){
                    $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$code' ,remain_log='$quantity_as' WHERE stock_log_id  = ".$row['stock_log_id']."");
                    $insert_transfer_stock_log = $db->prepare("INSERT INTO transfer_stock_log (transfer_stock_id,stock_id,transfer_qty,item_date,transfer_price) VALUES ('$code','$stock_id','$quantity;','$date_log','".$row['price_stock_log']."')");
                    $insert_transfer_stock_log->execute();
                    $stop_row++;
                }else{
                    $sum_last = $row['item_quantity']-$row['remain_log']; 
                    $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$code' ,remain_log='$quantity_as' WHERE stock_log_id  = ".$row['stock_log_id']."");
                    $insert_transfer_stock_log = $db->prepare("INSERT INTO transfer_stock_log (transfer_stock_id,stock_id,transfer_qty,item_date,transfer_price) VALUES ('$code','$stock_id','$quantity;','$date_log','".$row['price_stock_log']."')");
                    $insert_transfer_stock_log->execute();
                    if($update_stock_log->execute()){
                        $stop_row++;
                    }; 
                }
            }elseif($row['item_quantity'] < $quantity){
                $quantity = $quantity- $row['item_quantity'];
                $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$code',remain_log=NULL WHERE stock_log_id  = ".$row['stock_log_id']."");

                    if($update_stock_log->execute()){
                    $insert_transfer_stock_log = $db->prepare("INSERT INTO transfer_stock_log (transfer_stock_id,stock_id,transfer_qty,item_date,transfer_price) VALUES ('$code','$stock_id','".$row['item_quantity']."','$date_log','".$row['price_stock_log']."')");
                    $insert_transfer_stock_log->execute();
                    }
                    if($result==$row['item_quantity']){
                        $stop_row++;
                    }
                    
            }else{
                $quantity = $quantity- $row['item_quantity'];
                $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$code',remain_log=NULL WHERE stock_log_id  = ".$row['stock_log_id']."");
                if($update_stock_log->execute()){
                    $insert_transfer_stock_log = $db->prepare("INSERT INTO transfer_stock_log (transfer_stock_id,stock_id,transfer_qty,item_date,transfer_price) VALUES ('$code','$stock_id','".$row['item_quantity']."','$date_log','".$row['price_stock_log']."')");
                    $insert_transfer_stock_log->execute();
                }
                if($result==$row['item_quantity']){
                    $stop_row++;
                }
            }
        }
            
            }

        
        }
        
    }
    echo  $errorMsg=true;
}

?> 
