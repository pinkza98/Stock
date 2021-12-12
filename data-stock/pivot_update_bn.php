<?php 
include('../database/db.php');
if(isset($_POST['stock_id'])){ // if save button on the form is clicked
   $status = $_POST['status'];
   $stock_id = $_POST['stock_id'];
   $user_id = $_POST['user_name'];
   $quantity = $_POST['new_sum'];
   $bn_id=$_POST['user_bn'];
    if(is_null($stock_id)){
        echo false;
    }
    else{
    try{
    if($status == "edit_stock_bn"){ //function ในการปรับยอด รายการใน หน้า คลังสาขา
    
   
    $select_sum = $db->query("SELECT SUM(item_quantity) as sum_item FROM branch_stock  
    INNER JOIN branch_stock_log ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
    WHERE branch_stock.bn_stock = $bn_id AND branch_stock.stock_id = $stock_id ");
    $select_sum->execute();
    $sum = $select_sum->fetch(PDO::FETCH_ASSOC);

    $select_rowCount = $db->query("SELECT * FROM branch_stock_log  
    INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
    WHERE branch_stock.bn_stock = '".$bn_id."' AND branch_stock.stock_id = '".$stock_id."' ");
    
    $row_count = $select_rowCount->rowCount();
    $select_stock_full_log = $db->prepare("SELECT full_stock_id_log,branch_stock_log.stock_log_id,item_quantity  FROM branch_stock_log  
    INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
    WHERE branch_stock.bn_stock = '".$bn_id."' AND branch_stock.stock_id = '".$stock_id."'ORDER BY exd_date_log ");
    $i=1;
    if ($select_stock_full_log->execute()) {
        while ($row = $select_stock_full_log->fetch(PDO::FETCH_ASSOC)){
            if($sum == 0){
                $update_stock_log_reconcile = $db->prepare("UPDATE branch_stock_log SET item_quantity = '.$quantity.' ,user_name_log = '.$user_id.' WHERE stock_log_id = '". $row['stock_log_id']."'");
                $update_stock_log_reconcile->bindParam(':new_item_quantity', $quantity);
                $update_stock_log_reconcile->bindParam(':new_user_id', $user_id);
                if ($update_stock_log_reconcile->execute()){
                    $insertMsg = "ปรับยอดสำเร็จ";
                }
            }
            elseif ($i < $row_count or $i > $row_count) {
                    $del_stock_log = $db->prepare("DELETE FROM branch_stock_log WHERE full_stock_id_log  = '".$row['full_stock_id_log']."'");
                    $del_bn_stock = $db->prepare("DELETE FROM branch_stock WHERE full_stock_id  = '".$row['full_stock_id_log']."'");
                    if($del_stock_log->execute()&&  $del_bn_stock->execute()){
                        $i++;
                    }
                
            }elseif($i == $row_count){
                $update_stock_log_reconcile = $db->prepare("UPDATE branch_stock_log SET exd_date_log = NOW() ,item_quantity = :new_item_quantity ,user_name_log = :new_user_id WHERE stock_log_id = '". $row['stock_log_id']."'");
                $update_stock_log_reconcile->bindParam(':new_item_quantity', $quantity);
                $update_stock_log_reconcile->bindParam(':new_user_id', $user_id);
                if ($update_stock_log_reconcile->execute()){
                    $insertMsg = "ปรับยอดสำเร็จ";
                
                }else{
                    $errorMsg = "update_stock_log_reconcile->execute() ไม่สำเร็จ";
                }
            }
        }
        echo $insertMsg = "ปรับยอดสำเร็จ";
        $use_stock = "ปรับยอด"; 
        $date_new = new DateTime();
        $update_stock_bn_user_last = $db->prepare("UPDATE branch_stock SET name_update = '".$user_id."',transaction_update='".$use_stock."',datetime_update = NOW(),quantity_update=".$sum['sum_item']." WHERE stock_id = ".$stock_id." AND bn_stock=$bn_id");
        $update_stock_bn_user_last ->execute();
        
            }
            else{
                $errorMsg = "select_stock_full_log->execute เกิดปัญหา!!";
            }
    }elseif($status == "edit_stock_po"){    //function แก้ไขยอด stock_po
        

        $update_stock_po = $db->prepare("UPDATE stock_po SET $bn_id = $quantity WHERE stock_po_id=$stock_id");
        $update_stock_po ->execute();

        echo $insertMsg = "แก้ไขยอดสำเร็จ";

    }else{
        echo $errorMsg = false;
    }
}catch (PDOException $e) {
        echo $e->getMessage();
}

}
}


?>