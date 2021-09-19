<?php  
include("../database/db.php");

$randomking = rand(000001,999999);
    for($i=0; $i< count($_POST['stock_id']); $i++){  
        $status = $_POST["status"][$i];
        $stock_id = $_POST["stock_id"][$i]; 
        $bn_id = $_POST["bn_id"][$i];
        $quantity = $_POST["qty"][$i];
        $price_stock = $_POST["price_stock"][$i];
        $exd_date =$_POST["exd_date"][$i];
        $user_name = $_POST["user_name"][$i];
        $sum = $_POST["sum"][$i];
        try {
            if($status=="stock_item"){
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
                    $insertMsg = "สต๊อกคลัง";
                }else{
                    $errorMsg = "พบข้อผิดพลาด full stock bn ไม่ทำงาน";
                }
            }else{
                $errorMsg = "พบข้อผิดพลาด stock bn ไม่ทำงาน";
                }
            }
            elseif($status=="disburse"){
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
                    WHERE branch_stock.bn_stock = '$bn_id' AND branch_stock.stock_id = '$stock_id'  ");
                    $row_count = $select_rowCount->rowCount();
                    
                    $select_stock_full_log = $db->prepare("SELECT *  FROM branch_stock_log  
                    INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
                    WHERE branch_stock.bn_stock = '$bn_id' AND branch_stock.stock_id = '$stock_id' ORDER BY exd_date_log ASC");
                                if ($select_stock_full_log->execute()) {
                                while ($row = $select_stock_full_log->fetch(PDO::FETCH_ASSOC)AND  $stop_row != 1){
                                    if($i_check > $row_count){
                                    if ($row['item_quantity']< $quantity) {
                                        $quantity = $quantity- $row['item_quantity'];
                                            $del_stock_log = $db->prepare("DELETE FROM branch_stock_log WHERE full_stock_id_log  = '".$row['stock_log_id']."'");
                                            if($del_stock_log->execute()){
                                                $del_bn_stock = $db->prepare("DELETE FROM branch_stock WHERE full_stock_id  = '".$row['full_stock_id']."'");
                                                $del_bn_stock->execute();
                                                $i_check++;
                                            }
                                        }
                                    }elseif($i_check <= $row_count){
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
                                                $insertMsg = "เบิกคลัง";
                                            }
                                    }else{
                                        $quantity = $quantity- $row['item_quantity'];
                                        $del_stock_log = $db->prepare("DELETE FROM branch_stock_log WHERE full_stock_id_log  = '".$row['stock_log_id']."'");
                                        if($del_stock_log->execute()){
                                            $del_bn_stock = $db->prepare("DELETE FROM branch_stock WHERE full_stock_id  = '".$row['full_stock_id']."'");
                                            $del_bn_stock->execute();
                                        }
                                    }
                                }
                            }
                            $insertMsg = "เบิกคลัง";

                        }else{
                            $errorMsg = "อัพเดดข้อมูลผิดพลาด!!";
                        }
                }
            }elseif($status=="transfer"){
                $bn_acronym = $_POST["bn_acronym"][$i];
                $bn2_acronym = $_POST["bn2_acronym"][$i];
                $bn_id2 = $_POST["bn_id2"][$i];
                $result = $quantity;
                $sum_new = $sum;
                $quantity_new = $quantity;
                $answer;

                $select_rowCount = $db->query("SELECT *  FROM branch_stock_log  
                INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
                WHERE branch_stock.bn_stock = '$bn_id' AND branch_stock.stock_id = '$stock_id'  ");
                $row_count = $select_rowCount->rowCount();
                $i_check=1;
                $stop_row = 0;
                $transfer =$bn_acronym.$randomking.$bn2_acronym;
                $insert_transfer = $db->prepare("INSERT INTO transfer (transfer_name) VALUES ('$transfer')");
                $insert_transfer->execute(); 
                $insert_transfer_stock =$db->prepare("INSERT INTO transfer_stock (bn_id_1,bn_id_2,transfer_id,user1,transfer_date) VALUES ('$bn_id',' $bn_id2',LAST_INSERT_ID(),'$user_name',NOW())");
                $insert_transfer_stock->execute();
                $select_stock_full_log = $db->prepare("SELECT *  FROM branch_stock_log  
                INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
                WHERE branch_stock.bn_stock = '$bn_id' AND branch_stock.stock_id = '$stock_id' ORDER BY stock_log_id ASC");
                            if ($select_stock_full_log->execute()) {
                            while ($row = $select_stock_full_log->fetch(PDO::FETCH_ASSOC) AND $stop_row != 1){
                                if($i_check > $row_count){
                                if ($row['item_quantity']< $quantity) {
                                    $quantity = $quantity- $row['item_quantity'];
                                        $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$transfer'  WHERE full_stock_id_log  = '".$row['stock_log_id']."'");
                                        if($update_stock_log->execute()){
                                            $i_check++;
                                        }
                                    }
                                }elseif($i_check <= $row_count){
                                if ($row['item_quantity']> $quantity){
                                    $quantity_as = $row['item_quantity']-$quantity; 
                                    if($quantity_as == $row['item_quantity']){
                                        $stop_row++;
                                    }else{
                                        $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$transfer' ,remain_log='$quantity_as' WHERE full_stock_id_log  = '".$row['stock_log_id']."'");
                                        if($update_stock_log->execute()){
                                            $stop_row++;
                                        }; 
                                    }
                                }elseif($row['item_quantity'] < $quantity){
                                    $quantity = $quantity- $row['item_quantity'];
                                    $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$transfer' WHERE full_stock_id_log  = '".$row['stock_log_id']."'");
                                        $update_stock_log->execute();
                                        if($result==$row['item_quantity']){
                                            $stop_row++;
                                        }
                                        
                                }else{
                                    $quantity = $quantity- $row['item_quantity'];
                                    $update_stock_log = $db->prepare("UPDATE branch_stock_log set status_log='$transfer'  WHERE full_stock_id_log  = '".$row['stock_log_id']."'");
                                    $update_stock_log->execute();
                                    if($result==$row['item_quantity']){
                                        $stop_row++;
                                    }
                                    
                                }
                            }
                        }
                        $insertMsg ="โอนย้าย";
                    }else{
                        $errorMsg = "อัพเดดข้อมูลผิดพลาด!!";
                    }
            }
            else{
                $errorMsg = "กรุณาเลือกรายการก่อนเพิ่มข้อมูล";
            }
        }catch (PDOException $e) {
            echo "ERROR: ".$e->getMessage();
        }
            if(isset($insertMsg)){
            echo "ทำรายการ สำเร็จ!!";
            }else{
                echo "ทำรายการ ไม่สำเร็จ!!";
            }
    }

    
?>