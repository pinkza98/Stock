<?php  
include("../database/db.php");
if(empty($_POST['stock_id'])){
    $errorMsg=false;
}else{
$number = count($_POST['stock_id']);
$randomking = rand(000001,999999);
    for($i=0; $i< $number; $i++){  
        $status = $_POST["status"][$i];
        $stock_id = $_POST["stock_id"][$i]; 
        $bn_id = $_POST["bn_id"][$i];
        $quantity = $_POST["qty"][$i];
        $price_stock = $_POST["price_stock"][$i];
        $exd_date =$_POST["exd_date"][$i];
        $user_name = $_POST["user_name"][$i];
        $sum = $_POST["sum"][$i];
        try {
            if($status=="stock_item"){ //function ในการ เพิ่มข้อมูล stock สาขา
            if (is_null($quantity)) {
                    $errorMsg = false;
            }elseif($quantity < 0){
                $errorMsg = false;
            }
            else{
                $insert_full_stock = $db->prepare("INSERT INTO branch_stock (stock_id,bn_stock) VALUES ('.$stock_id.','.$bn_id.')");
                if($exd_date != 0000-00-00 AND $exd_date != NULL){
                    $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,item_quantity,exd_date_log,full_stock_id_log,price_stock_log) VALUES ('$user_name',NOW(),'.$quantity.','$exd_date',LAST_INSERT_ID(),'.$price_stock.')");

                }elseif(strtotime($exd_date) <= 62169984000){
                    $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,item_quantity,exd_date_log,full_stock_id_log,price_stock_log) VALUES ('$user_name',NOW(),'.$quantity.',NULL,LAST_INSERT_ID(),'.$price_stock.')");
                }else{
                    echo "พบข้อผิดพลาด ข้อมูลไม่เข้าเงื่อนไข การทำงาน";
                }
                if($insert_full_stock->execute()){
                    if($insert_full_stock_log->execute()){ 
                        
                    }else{
                        $errorMsg = "พบข้อผิดพลาด full stock bn ไม่ทำงาน";
                    }
                    
                }
                else{
                    $errorMsg = "พบข้อผิดพลาด stock bn ไม่ทำงาน";
                    }
                    $insertMsg = "สต๊อกคลัง";
                    $use_stock = "สต๊อกคลัง"; 
                    $date_new = new DateTime();
                    $update_stock_bn_user_last = $db->prepare("UPDATE branch_stock SET name_update = '".$user_name."',transaction_update='".$use_stock."',datetime_update = NOW(),quantity_update=$quantity WHERE stock_id = ".$stock_id." AND bn_stock=$bn_id");
                    $update_stock_bn_user_last ->execute();
                }
            }
            elseif($status=="disburse"){  //function ในการ เบิกคลัง stock สาขา
                if ($quantity > $sum) {
                $errorMsg = "จำนวนสินค้ามีไม่เพียงพอในคลัง!!";
                }elseif (is_null($quantity) or $quantity ==0) {
                    $errorMsg = "กรุณาใส่กรองจำนวนที่ต้องการเบิกคลัง!!";
                }else{
                    $result = $quantity;
                    $sum_new = $sum;
                    $quantity_new = $quantity;
                    $answer;
                    $i_check=1;
                    $stop_row = 0;
                    $select_rowCount = $db->query("SELECT *  FROM branch_stock_log  
                    INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
                    WHERE branch_stock.bn_stock = '$bn_id' AND branch_stock.stock_id = '$stock_id' AND status_log IS NULL");
                    $row_count = $select_rowCount->rowCount();
                    $use_stock = "เบิกใช้"; 
                    $date_new = new DateTime();
                    $update_stock_bn_user_last = $db->prepare("UPDATE branch_stock SET name_update = '".$user_name."',transaction_update='".$use_stock."',datetime_update = NOW(),quantity_update=$quantity WHERE stock_id = ".$stock_id." AND bn_stock=$bn_id");
                    $update_stock_bn_user_last ->execute();
                    
                    $select_stock_full_log = $db->prepare("SELECT *  FROM branch_stock_log  
                    INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
                    WHERE branch_stock.bn_stock = '$bn_id' AND branch_stock.stock_id = '$stock_id' AND status_log IS NULL ORDER BY exd_date_log ASC");
                                if ($select_stock_full_log->execute()) {
                                while ($row = $select_stock_full_log->fetch(PDO::FETCH_ASSOC)AND  $stop_row != 1){
                                        if($i_check > $row_count){
                                                if ($row['item_quantity']< $quantity) {
                                                    $quantity = $quantity- $row['item_quantity'];
                                                        $del_stock_log = $db->prepare("DELETE FROM branch_stock_log WHERE full_stock_id_log  = '".$row['stock_log_id']."'");
                                                        if($del_stock_log->execute()){
                                                            $del_bn_stock = $db->prepare("DELETE FROM branch_stock WHERE full_stock_id  = '".$row['full_stock_id']."'");
                                                            $del_bn_stock->execute();
                                                        }
                                            }
                                            //end1จำนวนแถวมากกว่า
                                        }elseif($i_check < $row_count){
                                                    if ($row['item_quantity']> $quantity){
                                                        $quantity_as = $row['item_quantity']-$quantity;
                                                        $answer = $sum - $quantity_new;
                                                        $update_stock_log = $db->prepare("UPDATE branch_stock_log SET item_quantity = '$quantity_as'  WHERE stock_log_id = '". $row['stock_log_id']."'");
                                                        $insert_cut_stock = $db->prepare("INSERT INTO cut_stock_log( user_id, quantity, date, stock_id, bn_id,price_cut_stock) VALUES('$user_name','.$result.',NOW(),'.$stock_id.','.$bn_id.','.$price_stock.')");
                                                        if ( $insert_cut_stock->execute()) {
                                                            if($update_stock_log->execute()){
                                                                $stop_row++; 
                                                            }
                                                    }else{
                                                        $errorMsg = "อัพเดดข้อมูลผิดพลาด!!";
                                                    }
                                                    }elseif($row['item_quantity'] < $quantity){
                                                        $quantity = $quantity- $row['item_quantity'];
                                                        $del_stock_log = $db->prepare("DELETE FROM branch_stock_log WHERE full_stock_id_log  = '".$row['stock_log_id']."'");
                                                            if($del_stock_log->execute()){
                                                                $del_bn_stock = $db->prepare("DELETE FROM branch_stock WHERE full_stock_id  = '".$row['full_stock_id']."'");
                                                                $del_bn_stock->execute();
                                                                
                                                            }
                                                            }else{
                                                                $quantity = $quantity- $row['item_quantity'];
                                                                $del_stock_log = $db->prepare("DELETE FROM branch_stock_log WHERE full_stock_id_log  = '".$row['stock_log_id']."'");
                                                                if($del_stock_log->execute()){
                                                                    $del_bn_stock = $db->prepare("DELETE FROM branch_stock WHERE full_stock_id  = '".$row['full_stock_id']."'");
                                                                    $del_bn_stock->execute();
                                                                }
                                                    }
                                                    //end2 จำนวนแถว <
                                            }elseif($i_check == $row_count){
                                                $quantity = $row['item_quantity']-$quantity;
                                                $answer = $sum - $quantity_new;
                                                $update_stock_log = $db->prepare("UPDATE branch_stock_log SET item_quantity = '$quantity'  WHERE stock_log_id = '". $row['stock_log_id']."'");
                                                $insert_cut_stock = $db->prepare("INSERT INTO cut_stock_log( user_id, quantity, date, stock_id, bn_id,price_cut_stock) VALUES('$user_name','.$result.',NOW(),'.$stock_id.','.$bn_id.','.$price_stock.')");
                                                $insert_cut_stock->execute();
                                                $update_stock_log->execute();
                                            }
                                            //end 3 จำนวนแถว ==
                                $i_check++; 
                            }
                            $insertMsg = "เบิกคลัง";

                        }else{
                            $errorMsg = "อัพเดดข้อมูลผิดพลาด!!";
                        }
                }
            }elseif($status=="transfer"){  //function ในการ ส่งข้อมูลโอนย้ายของระหว่างคลัง
                $bn_acronym = $_POST["bn_acronym"][$i];
                $bn2_acronym = $_POST["bn2_acronym"][$i];
                $bn_id2 = $_POST["bn_id2"][$i];
                $result = $quantity;
                $sum_new = $sum;
                $quantity_new = $quantity;
                $answer;
                if (is_null($quantity) or $quantity ==0) {

                }else{
                $select_rowCount = $db->query("SELECT *  FROM branch_stock_log  
                INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
                WHERE branch_stock.bn_stock = '$bn_id' AND branch_stock.stock_id = '$stock_id'  AND status_log IS NULL");
                $row_count = $select_rowCount->rowCount();
                $i_check=1;
                $stop_row = 0;
                $transfer =$bn_acronym.$randomking.$bn2_acronym;
                    if($i+1== $number){
                    $insert_transfer = $db->prepare("INSERT INTO transfer (transfer_name) VALUES ('$transfer')");
                    
                    $insert_transfer_stock =$db->prepare("INSERT INTO transfer_stock (bn_id_1,bn_id_2,transfer_id,user1,transfer_date,transfer_status) VALUES ('$bn_id',' $bn_id2',LAST_INSERT_ID(),'$user_name',NOW(),1)");
                    
                    if($insert_transfer->execute()){ //function สร้างรหัสติดตาม พัสดุ
                        $insert_transfer_stock->execute();
                        $insertMsg = "โอนย้าย รหัสติดตามสถานะพัสดุ ".$transfer;
                    }
                    }
                $select_stock_full_log = $db->prepare("SELECT *  FROM branch_stock_log  
                INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
                WHERE branch_stock.bn_stock = '$bn_id' AND branch_stock.stock_id = '$stock_id'  AND status_log IS NULL ORDER BY stock_log_id ASC");
                            if ($select_stock_full_log->execute()) {
                            while ($row = $select_stock_full_log->fetch(PDO::FETCH_ASSOC) AND $stop_row != 1){
                                $date_log = $row['exd_date_log'];
                                if($i_check > $row_count){
                                if ($row['item_quantity']< $quantity) {
                                    $quantity = $quantity- $row['item_quantity'];
                                        $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$transfer' ,remain_log=1000  WHERE stock_log_id  = ".$row['stock_log_id']."");
                                        $update_stock_log->execute();
                                    }
                                //end 1
                                }elseif($i_check <= $row_count){  
                                if ($row['item_quantity']> $quantity){
                                    $quantity_as = $row['item_quantity']-$quantity; 
                                    $sum_last = $row['item_quantity']-$row['remain_log']; 
                                    if($quantity_as == $row['item_quantity']){
                                        $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$transfer' ,remain_log='$quantity_as' WHERE stock_log_id  = ".$row['stock_log_id']."");
                                        $insert_transfer_stock_log = $db->prepare("INSERT INTO transfer_stock_log (transfer_stock_id,stock_id,transfer_qty,item_date,transfer_price) VALUES ('$transfer','$stock_id','$quantity;','$date_log','$price_stock')");
                                        $insert_transfer_stock_log->execute();
                                        $stop_row++;
                                    }else{
                                        $sum_last = $row['item_quantity']-$row['remain_log']; 
                                        $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$transfer' ,remain_log='$quantity_as' WHERE stock_log_id  = ".$row['stock_log_id']."");
                                        $insert_transfer_stock_log = $db->prepare("INSERT INTO transfer_stock_log (transfer_stock_id,stock_id,transfer_qty,item_date,transfer_price) VALUES ('$transfer','$stock_id','$quantity;','$date_log','$price_stock')");
                                        $insert_transfer_stock_log->execute();
                                        if($update_stock_log->execute()){
                                            $stop_row++;
                                        }; 
                                    }
                                }elseif($row['item_quantity'] < $quantity){
                                    $quantity = $quantity- $row['item_quantity'];
                                    $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$transfer',remain_log=NULL WHERE stock_log_id  = ".$row['stock_log_id']."");

                                        if($update_stock_log->execute()){
                                        $insert_transfer_stock_log = $db->prepare("INSERT INTO transfer_stock_log (transfer_stock_id,stock_id,transfer_qty,item_date,transfer_price) VALUES ('$transfer','$stock_id','".$row['item_quantity']."','$date_log','$price_stock')");
                                        $insert_transfer_stock_log->execute();
                                        }
                                        if($result==$row['item_quantity']){
                                            $stop_row++;
                                        }
                                        
                                }else{
                                    $quantity = $quantity- $row['item_quantity'];
                                    $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$transfer',remain_log=NULL WHERE stock_log_id  = ".$row['stock_log_id']."");
                                    if($update_stock_log->execute()){
                                        $insert_transfer_stock_log = $db->prepare("INSERT INTO transfer_stock_log (transfer_stock_id,stock_id,transfer_qty,item_date,transfer_price) VALUES ('$transfer','$stock_id','".$row['item_quantity']."','$date_log','$price_stock')");
                                        $insert_transfer_stock_log->execute();
                                    }
                                    if($result==$row['item_quantity']){
                                        $stop_row++;
                                    }
                                }
                            }
                        }
                    }else{
                        $errorMsg = "อัพเดดข้อมูลผิดพลาด!!";
                    }
            }
        }
            else{
                $errorMsg = "กรุณาเลือกรายการก่อนเพิ่มข้อมูล";
            }
        }catch (PDOException $e) {
            echo "ERROR: ".$e->getMessage();
        }
    }
    if(isset($insertMsg)){
        echo "ทำรายการ $insertMsg สำเร็จ!!";
        } elseif(isset($errorMsg)){
            echo false;
    }
}
//function disburse
?>