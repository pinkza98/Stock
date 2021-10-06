<?php  
include("../database/db.php");

if($_POST['status']=="pass"){
$transfer_stock_id=$_POST['uid'];
 $text1=$_POST['text1'];
 $name=$_POST['name'];

$update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 2 ,note2 = '$text1',user2='$name' WHERE transfer_stock_id  ='$transfer_stock_id'");
    if($update_transfer_stock->execute()){

    $select_transfer_stock = $db->prepare("SELECT * FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id WHERE transfer_stock.transfer_id  = '$transfer_stock_id'");
    if( $select_transfer_stock->execute()){
        $row_transfer_stock = $select_transfer_stock->fetch(PDO::FETCH_ASSOC);
        extract($row_transfer_stock);

        $select_stock_log = $db->prepare("SELECT * from branch_stock_log WHERE status_log ='$transfer_name'");
        if($select_stock_log->execute()){
            while ($row_stock_log = $select_stock_log->fetch(PDO::FETCH_ASSOC)) {

                if($row_stock_log['remain_log']!=null){
                    $remain = $row_stock_log['remain_log'];
                    $update_stock_stock_log = $db->prepare("UPDATE branch_stock_log SET item_quantity =$remain,status_log =null,remain_log=null WHERE stock_log_id =".$row_stock_log['stock_log_id']."");
                    $update_stock_stock_log ->execute();
                }else{
                    $select_stock_log_del = $db->prepare("DELETE FROM branch_stock_log WHERE stock_log_id  = '".$row_stock_log['stock_log_id']."'");
                    $select_stock_del = $db->prepare("DELETE FROM branch_stock WHERE full_stock_id  = '".$row_stock_log['full_stock_id_log']."'");
                    if($select_stock_del->execute()){
                        $select_stock_log_del->execute();
                    }
                }
                
            }
            echo "สำเร็จ";
        }
    }
    }else{
        echo "การ update ข้อมูลผิดพลาด";
    }
}elseif($_POST['status']=="no_pass"){
    $transfer_stock_id=$_POST['uid'];
    $text1=$_POST['text1'];
    $name=$_POST['name'];

$update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 3 ,note2 = '$text1' ,user2='$name' WHERE transfer_stock_id  ='$transfer_stock_id'");//set t_stock status ไม่อนุมัติ และโน๊ต และ user2 (1)
    if($update_transfer_stock->execute()){

    $select_transfer_stock = $db->prepare("SELECT * FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id WHERE transfer_stock.transfer_id  = '$transfer_stock_id'");//ดึงค่า t_stock มมาเพื่อจะloop t_stock_log (2)
    if( $select_transfer_stock->execute()){
        $row_transfer_stock = $select_transfer_stock->fetch(PDO::FETCH_ASSOC);
        extract($row_transfer_stock);

        $select_transfer_stock_log = $db->prepare("SELECT * FROM transfer_stock_log  WHERE transfer_stock_id  = '$transfer_name'"); //ดึง t_stock_log ทั้งหมด (3)
        
        if($select_transfer_stock_log->execute()){
                $update_stock_stock_log = $db->prepare("UPDATE branch_stock_log SET status_log =null,remain_log=null WHERE status_log ='$transfer_name'"); // set (6)
                if($update_stock_stock_log->execute()){
                    
                    // $select_transfer_stock_log_del = $db->prepare("DELETE FROM transfer_stock_log WHERE transfer_stock_id  = '$transfer_name'"); // ลบข้อมูล t_stock_log ตาม t_stock_log (7)
                    // if($select_transfer_stock_log_del->execute()){
                        echo "บันทึกรายการยกเลิกแล้ว";
                    // }

                }
            }
        }
            
    }
}elseif($_POST['status']=="set_carry"){
    $transfer_stock_id=$_POST['uid'];
    $text1=$_POST['text1'];
     $text2=$_POST['text2'];
     $text3=$_POST['text3'];
    $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 4,transfer_service ='$text1',code_service='$text2',transfer_price=$text3  WHERE transfer_stock_id  ='$transfer_stock_id'");
    if($update_transfer_stock->execute()){
        echo "บันทึกข้อมูลขนส่งเรียบร้อย";
    }
    
}elseif($_POST['status']=="del_row"){
    $transfer_stock_id=$_POST['uid'];
    $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 6  WHERE transfer_stock_id  ='$transfer_stock_id'");
    $update_transfer_stock->execute();
    // $select_transfer_stock_log_del = $db->prepare("DELETE FROM transfer_stock_log WHERE transfer_stock_id  = '$transfer_name'"); // ลบข้อมูล t_stock_log ตาม t_stock_log (7)
    // if($select_transfer_stock_log_del->execute()){
        echo "จัดการบันทึกรายการยกเลิกสำเร็จ";
    // }
}elseif($_POST['status']=="add_stock"){
    $transfer_stock_id=$_POST['uid'];
    $name=$_POST['name'];
    
        $select_transfer_stock_1 = $db->prepare("SELECT transfer_name,bn_id_1,bn_id_2,transfer_price FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id WHERE transfer_stock.transfer_id  = '$transfer_stock_id'");//แปร id เป็นรหัสไอเท็ม
        $select_transfer_stock_1->execute();
        $row_1 = $select_transfer_stock_1->fetch(PDO::FETCH_ASSOC);

        $select_transfer_stock_2 = $db->prepare("SELECT transfer_stock_id,stock_id,transfer_log_id FROM transfer_stock_log WHERE transfer_stock_id ='".$row_1['transfer_name']."' GROUP BY stock_id ORDER BY transfer_log_id");//หาcode ใน transfer_stock_log
        $select_transfer_stock_2->execute();
        $row_count_1 = $select_transfer_stock_2->rowCount();//นับจำรายการ stock_id ใน transfer_log ที่ code รายการ
        $set_i_1 = 1;
        $select_transfer_log_all_sum = $db->prepare("SELECT SUM(transfer_qty)as sum_qty,SUM(transfer_qty_set)as sum_qty_set FROM transfer_stock_log  WHERE  transfer_stock_id = '".$row_1['transfer_name']."'"); 
        $select_transfer_log_all_sum->execute();///เช็คในcode
        $sum_all_log = $select_transfer_log_all_sum->fetch(PDO::FETCH_ASSOC);
        if(is_null($sum_all_log['sum_qty_set'])){
            echo "กรุณาตรวจสอบ ยอดรับก่อนดำเนินรายการรับสินค้า";
        }elseif($sum_all_log['sum_qty_set']>$sum_all_log['sum_qty']){
            echo "จำนวนเบิกรับไม่ถูกต้อง กรุณาปรับยอดใหม่";
        }
        else{
            $status_transfer=0;
            while ($row_transfer_log = $select_transfer_stock_2->fetch(PDO::FETCH_ASSOC) ) {//loop1
                $select_transfer_log_check_sum = $db->prepare("SELECT SUM(transfer_qty)as sum_qty,SUM(transfer_qty_set)as sum_qty_set FROM transfer_stock_log  WHERE stock_id = ".$row_transfer_log['stock_id']." AND transfer_stock_id = '".$row_transfer_log['transfer_stock_id']."'"); 
                $select_transfer_log_check_sum->execute();
                $sum_log = $select_transfer_log_check_sum->fetch(PDO::FETCH_ASSOC);//เช็คstock_id กับ
                $select_transfer_log = $db->prepare("SELECT * FROM transfer_stock_log  WHERE stock_id = ".$row_transfer_log['stock_id']." AND transfer_stock_id = '".$row_transfer_log['transfer_stock_id']."'  ORDER BY transfer_log_id ASC"); //ตัวโยนข้อมมูลรายละเอียด tranfer_stock_log
                $select_transfer_log->execute();
                $row_count_2 = $select_transfer_log->rowCount();
                $row_count_log = $select_transfer_log->rowCount();
                $row_count_log =  $row_count_log-1;
                $count2 = 1;
                $set_new_transfer_stock_id = $row_1['transfer_name']."-1"; // อ้างอิงค่ารหัสใหม่ โดยใส่ -1 กำกับ
                $select_transfer = $db->prepare("SELECT * FROM transfer WHERE transfer_name = '$set_new_transfer_stock_id'");
                $select_transfer->execute();
                $transfer = $select_transfer->fetch(PDO::FETCH_ASSOC);
                if($row_count_1 >=$set_i_1 ){
                if($sum_all_log['sum_qty']!=$sum_all_log['sum_qty_set']){ //เช็คค่าทั้งหมด โอนย้ายเลยหรือไม่
                    while ($row_2 = $select_transfer_log->fetch(PDO::FETCH_ASSOC) ) {
                        if($row_count_2 > $count2){//stap1
                    if($sum_log['sum_qty']!=$sum_log['sum_qty_set']){ 
                        $status_transfer = 1;
                        $insert_full_stock = $db->prepare("INSERT INTO branch_stock (bn_stock,stock_id) VALUES (".$row_1['bn_id_2'].",".$row_2['stock_id'].")");
                        $insert_full_stock->execute();
                        $sum_divide =$sum_log['sum_qty_set']/$row_count_log;
                        $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,exd_date_log,item_quantity,full_stock_id_log,price_stock_log) VALUES ('$name',NOW(),'".$row_2['item_date']."','$sum_divide',LAST_INSERT_ID(),".$row_2['transfer_price'].")");    
                        $insert_full_stock_log->execute();
                        $update_transfer_stock_log = $db->prepare("UPDATE transfer_stock_log  SET transfer_qty =".$sum_log['sum_qty_set'].", transfer_stock_id =  '$set_new_transfer_stock_id' WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
                        $update_transfer_stock_log->execute();
                        $count2++;
                    }else{
                        $status_transfer = 2;
                        $insert_full_stock = $db->prepare("INSERT INTO branch_stock (bn_stock,stock_id) VALUES (".$row_1['bn_id_2'].",".$row_2['stock_id'].")");
                        $insert_full_stock->execute();
                        $sum_divide =$sum_log['sum_qty_set']/$row_count_log;
                        $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,exd_date_log,item_quantity,full_stock_id_log,price_stock_log) VALUES ('$name',NOW(),'".$row_2['item_date']."','$sum_divide',LAST_INSERT_ID(),".$row_2['transfer_price'].")");    
                        $insert_full_stock_log->execute();
                        $update_transfer_stock_log = $db->prepare("UPDATE transfer_stock_log  SET transfer_qty =".$sum_log['sum_qty_set'].", transfer_stock_id =  '$set_new_transfer_stock_id' WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
                        $update_transfer_stock_log->execute();
                        $count2++;
                        

                    }
                    }else{
                        $sum=$sum_log['sum_qty']-$sum_log['sum_qty_set'];
                        $update_transfer_log = $db->prepare("UPDATE transfer_stock_log SET transfer_qty=$sum,transfer_qty_set =NULL ,transfer_note=null  WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
                        $update_transfer_log->execute();
                    }
                }

                }else{
                    //สำหรับไม่ต้องถอน
                    //เก็บstatus
                    while ($row_2 = $select_transfer_log->fetch(PDO::FETCH_ASSOC) ) {//loop2 ลูปเช็คค่า
                        if($row_count_2 >= $count2){//stap1
                        $status_transfer = 3;
                        $insert_full_stock = $db->prepare("INSERT INTO branch_stock (bn_stock,stock_id) VALUES (".$row_1['bn_id_2'].",".$row_2['stock_id'].")");
                        $insert_full_stock->execute();
                        $sum_divide =$sum_log['sum_qty_set']/$row_count_log;
                        $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,exd_date_log,item_quantity,full_stock_id_log,price_stock_log) VALUES ('$name',NOW(),'".$row_2['item_date']."','$sum_divide',LAST_INSERT_ID(),".$row_2['transfer_price'].")");    
                        $insert_full_stock_log->execute();
                        $count2++;
                        }else{
                        $sum=$sum_log['sum_qty']-$sum_log['sum_qty_set'];
                        $update_transfer_log = $db->prepare("UPDATE transfer_stock_log SET transfer_qty=$sum,transfer_qty_set =NULL ,transfer_note=null  WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
                        $update_transfer_log->execute();
                        }
                        
                        
                    }
                }
            }
            else{
                echo "Error";
            }
        } 
            if($status_transfer ==1){
                echo "ของมาไม่ครบ";
                if($transfer['transfer_id']==null){ 
                    $insert_transfer =$db->prepare("INSERT INTO transfer (transfer_name)VALUES('$set_new_transfer_stock_id')");
                    $insert_transfer->execute();
                    $insert_transfer_stock = $db->prepare("INSERT INTO transfer_stock (bn_id_1,bn_id_2,transfer_id,transfer_status,user3,note3,transfer_date)VALUES(".$row_1['bn_id_1'].",".$row_1['bn_id_2'].",LAST_INSERT_ID(),5,'$name','รายการมียอดค้างอยู่',NOW())");
                    $insert_transfer_stock->execute();
                }
                $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 4 ,user3='$name'  WHERE transfer_stock_id  =$transfer_stock_id");
                $update_transfer_stock->execute();
                
            }elseif($status_transfer ==2){
                echo "มีมาไม่ครับ กับไม่ครบ";
                if($transfer['transfer_id']==null){ 
                    $insert_transfer =$db->prepare("INSERT INTO transfer (transfer_name)VALUES('$set_new_transfer_stock_id')");
                    $insert_transfer->execute();
                    $insert_transfer_stock = $db->prepare("INSERT INTO transfer_stock (bn_id_1,bn_id_2,transfer_id,transfer_status,user3,note3,transfer_date)VALUES(".$row_1['bn_id_1'].",".$row_1['bn_id_2'].",LAST_INSERT_ID(),5,'$name','รายการมียอดค้างอยู่',NOW())");
                    $insert_transfer_stock->execute();
                }
                $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 4 ,user3='$name'  WHERE transfer_stock_id  =$transfer_stock_id");
                $update_transfer_stock->execute();
                
            }elseif($status_transfer ==3){
                echo "มาครบ set code -1 ออก";
                $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 5,user3='$name',note3='รับของครบแล้ว'  WHERE transfer_stock_id  =$transfer_stock_id");
                $update_transfer_stock->execute();
                $delete_transfer_stock_log = $db->prepare("DELETE FROM transfer_stock_log WHERE transfer_stock_id = ".$row_1['transfer_name']." AND transfer_note = '".$row_1['transfer_name']."'");
                $delete_transfer_stock_log->execute();
            }else{
                echo "หลุดลูป";
            }
        }
}else{
echo "error";
}
?>








 <!-- // while ($row_transfer_log = $select_transfer_stock_2->fetch(PDO::FETCH_ASSOC) ) {    
        //         if($row_count_1 >=$set_i_1 ){
        //             $select_transfer_log_check_sum = $db->prepare("SELECT SUM(transfer_qty)as sum_qty,SUM(transfer_qty_set)as sum_qty_set FROM transfer_stock_log  WHERE stock_id = '".$row_transfer_log['stock_id']."' AND transfer_stock_id = '".$row_transfer_log['transfer_stock_id']."'"); 
        //             $select_transfer_log_check_sum->execute();
        //             $sum_log = $select_transfer_log_check_sum->fetch(PDO::FETCH_ASSOC);//เช็คstock_id กับ 
        //             $select_transfer_log = $db->prepare("SELECT * FROM transfer_stock_log  WHERE stock_id = '".$row_transfer_log['stock_id']."' AND transfer_stock_id = '".$row_transfer_log['transfer_stock_id']."' ORDER BY transfer_log_id ASC"); //ตัวโยนข้อมมูลรายละเอียด tranfer_stock_log
        //             $select_transfer_log->execute();
        //             $row_count_2 = $select_transfer_log->rowCount();
        //             $row_count_log = $select_transfer_log->rowCount();
        //             $row_count_log =  $row_count_log-1;
        //             $count2 = 1;
        //             if($sum_log['sum_qty']!=$sum_log['sum_qty_set']){ 
        //                 while ($row_2 = $select_transfer_log->fetch(PDO::FETCH_ASSOC) ) {//loop2 ลูปเช็คค่า
        //                     if($row_count_2 > $count2){//stap1
        //                         $insert_full_stock = $db->prepare("INSERT INTO branch_stock (bn_stock,stock_id) VALUES (".$row_1['bn_id_2'].",".$row_2['stock_id'].")");
        //                         if($insert_full_stock->execute()){
        //                             $sum_divide =$sum_log['sum_qty_set']/$row_count_log; // 
        //                                 $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,exd_date_log,item_quantity,full_stock_id_log,price_stock_log) VALUES ('$name',NOW(),'".$row_2['item_date']."',' $sum_divide',LAST_INSERT_ID(),".$row_2['transfer_price'].")");    
        //                                 if($insert_full_stock_log->execute()){
        //                                     $set_new_transfer_stock_id = $row_1['transfer_name']."-1"; // อ้างอิงค่ารหัสใหม่ โดยใส่ -1 กำกับ
        //                                     $update_transfer_stock_log = $db->prepare("UPDATE transfer_stock_log  SET transfer_qty =".$sum_log['sum_qty_set'].", transfer_stock_id =  '$set_new_transfer_stock_id' WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
        //                                     if($update_transfer_stock_log->execute()){
        //                                         $select_transfer = $db->prepare("SELECT * FROM transfer WHERE transfer_name = '$set_new_transfer_stock_id'");
        //                                         $select_transfer->execute();
        //                                         $transfer = $select_transfer->fetch(PDO::FETCH_ASSOC);
        //                                         if($transfer['transfer_id']==null){  //เช็คหาค่ารหัส ว่่ามีไหม
        //                                             $insert_transfer =$db->prepare("INSERT INTO transfer (transfer_name)VALUES('$set_new_transfer_stock_id')");
        //                                             if($insert_transfer->execute()){
        //                                                 $insert_transfer_stock = $db->prepare("INSERT INTO transfer_stock (bn_id_1,bn_id_2,transfer_id,transfer_status,user3,note3,transfer_date)VALUES(".$row_1['bn_id_1'].",".$row_1['bn_id_2'].",LAST_INSERT_ID(),5,'$name','รายการมียอดค้างอยู่',NOW())");
        //                                             $insert_transfer_stock->execute();
        //                                             $count2++;
        //                                             }
                                                    
        //                                         }else{
        //                                             $count2++;
        //                                         }
                                                
        //                                     }
        //                                 }
        //                             }
        //                     }else{//stap1
        //                         $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 4 ,user3='$name'  WHERE transfer_stock_id  =$transfer_stock_id");
        //                         $update_transfer_stock->execute();
        //                         $sum=$sum_log['sum_qty']-$sum_log['sum_qty_set'];
        //                         $update_transfer_log = $db->prepare("UPDATE transfer_stock_log SET transfer_qty=$sum,transfer_qty_set =NULL ,transfer_note=null  WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
        //                         $update_transfer_log->execute();
        //                         echo "รับสินค้าแต่มียอดค้างสำเร็จ";
        //                     }
        //                 }
        //             }else{//stap2
        //                 while ($row_2 = $select_transfer_log->fetch(PDO::FETCH_ASSOC) ) {
        //                     if($row_count_2 > $count2){
        //                         $insert_full_stock = $db->prepare("INSERT INTO branch_stock (bn_stock,stock_id) VALUES (".$row_1['bn_id_2'].",".$row_2['stock_id'].")");
        //                         if($insert_full_stock->execute()){
        //                             $sum_divide =$sum_log['sum_qty_set']/$row_count_log;
        //                                 $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,exd_date_log,item_quantity,full_stock_id_log,price_stock_log) VALUES ('$name',NOW(),'".$row_2['item_date']."','$sum_divide',LAST_INSERT_ID(),".$row_2['transfer_price'].")");    
        //                                 if($insert_full_stock_log->execute()){
        //                                             $count2++;
        //                                 }
        //                             }
        //                     }else{//stap3
        //                         $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 5,user3='$name',note3='รับของครบแล้ว'  WHERE transfer_stock_id  =$transfer_stock_id");
        //                         $update_transfer_stock->execute();
        //                         $sum=$sum_log['sum_qty']-$sum_log['sum_qty_set'];
        //                         $delete_transfer_stock_log = $db->prepare("DELETE  FROM transfer_stock_log WHERE  transfer_log_id = ".$row_2['transfer_log_id']." AND transfer_note = '".$row_2['transfer_stock_id']."'");
        //                         $delete_transfer_stock_log->execute();
        //                         echo "รับสินค้าไม่มียอดค้างสำเร็จ";
                                
        //                     }
        //                 }
        //             }
        //         }
        //     } -->

        <!-- // while ($row_transfer_log = $select_transfer_stock_2->fetch(PDO::FETCH_ASSOC) ) {   
        //     if($row_count_1 >$set_i_1 ){
        //     $select_transfer_log_check_sum = $db->prepare("SELECT SUM(transfer_qty)as sum_qty,SUM(transfer_qty_set)as sum_qty_set FROM transfer_stock_log  WHERE stock_id = '".$row_transfer_log['stock_id']."' AND transfer_stock_id = '".$row_transfer_log['transfer_stock_id']."'"); 
        //     $select_transfer_log_check_sum->execute();//เช็คใน
        //     $sum_log = $select_transfer_log_check_sum->fetch(PDO::FETCH_ASSOC);
        //     $select_transfer_log = $db->prepare("SELECT * FROM transfer_stock_log  WHERE stock_id = '".$row_transfer_log['stock_id']."' AND transfer_stock_id = '".$row_transfer_log['transfer_stock_id']."' ORDER BY transfer_log_id ASC"); //ตัวโยนข้อมมูลรายละเอียด tranfer_stock_log
        //     $select_transfer_log->execute();
        //     $row_count_2 = $select_transfer_log->rowCount();
        //     $count2 = 1;
        //     $set_up=0;
        //     $set_new_transfer_stock_id = $row_1['transfer_name']."-1";
        //     $select_transfer = $db->prepare("SELECT * FROM transfer WHERE transfer_name = '$set_new_transfer_stock_id'");
        //     $select_transfer->execute();
        //     $transfer = $select_transfer->fetch(PDO::FETCH_ASSOC);
        //         while ($row_2 = $select_transfer_log->fetch(PDO::FETCH_ASSOC) ) {
        //             if($row_count_2 >= $count2){
                
        //         if($sum_all_log['sum_qty']!=$sum_all_log['sum_qty_set']){
        //                 if($sum_log['sum_qty']!=$sum_log['sum_qty_set']){
        //                     $set_up=1;
        //                     echo "ไม่เท่า && ไม่เท่า +";
        //                     $update_transfer_stock_log = $db->prepare("UPDATE transfer_stock_log  SET transfer_qty =".$sum_log['sum_qty_set'].", transfer_stock_id =  '$set_new_transfer_stock_id' WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
        //                     $update_transfer_stock_log->execute();
                            
        //                     if($transfer['transfer_id']==null){
        //                         $insert_transfer =$db->prepare("INSERT INTO transfer (transfer_name)VALUES('$set_new_transfer_stock_id')");
        //                         $insert_transfer->execute();
        //                         $insert_transfer_stock = $db->prepare("INSERT INTO transfer_stock (bn_id_1,bn_id_2,transfer_id,transfer_status,user3,note3,transfer_date)VALUES(".$row_1['bn_id_1'].",".$row_1['bn_id_2'].",LAST_INSERT_ID(),5,'$name','รายการมียอดค้างอยู่',NOW())");
        //                         $insert_transfer_stock->execute();
        //                         $count2++;
        //                     }else{
        //                         $count2++;
        //                         //ไม่ต้องสร้าง key transfer_id
        //                     }

        //                 }else{
        //                     $set_up=2;
        //                     echo "ไม่เท่า && เท่า+";
        //                     $update_transfer_stock_log = $db->prepare("UPDATE transfer_stock_log  SET transfer_qty =".$sum_log['sum_qty_set'].", transfer_stock_id =  '$set_new_transfer_stock_id' WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
        //                     $update_transfer_stock_log->execute();
        //                     $count2++;

                            
        //                 }
        //         }
        //         elseif($sum_all_log['sum_qty']==$sum_all_log['sum_qty_set']){
        //                 if($sum_log['sum_qty']!=$sum_log['sum_qty_set']){
        //                     $set_up=3;
        //                     // echo "เท่า && ไม่เท่า+";
        //                     // $update_transfer_stock->execute();
        //                     // $update_transfer_stock_log = $db->prepare("UPDATE transfer_stock_log  SET transfer_qty =".$sum_log['sum_qty_set'].", transfer_stock_id =  '$set_new_transfer_stock_id' WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
        //                     // $update_transfer_stock_log->execute();
        //                     $count2++;

        //                 }else{
        //                     $set_up=4;
        //                     echo "เท่า && เท่า+";
        //                     $update_transfer_stock_log = $db->prepare("UPDATE transfer_stock_log  SET transfer_qty =".$sum_log['sum_qty_set']." WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
        //                     $update_transfer_stock_log->execute();
        //                     $count2++;

        //                 }
        //             }
        //         else{
        //             echo "ออกลูปมีข้อมูลผิดพลาด";
        //         }
        //     }else{
               
        //         if($set_up==1){
        //             $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 4 ,user3='$name'  WHERE transfer_stock_id  =$transfer_stock_id");
        //             $update_transfer_stock->execute();
        //              $sum=$sum_log['sum_qty']-$sum_log['sum_qty_set'];
        //         $update_transfer_log = $db->prepare("UPDATE transfer_stock_log SET transfer_qty=$sum,transfer_qty_set =NULL ,transfer_note=null  WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
        //         $update_transfer_log->execute();
        //         }elseif($set_up==2){
        //             $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 4 ,user3='$name'  WHERE transfer_stock_id  =$transfer_stock_id");
        //             $update_transfer_stock->execute();
        //              $sum=$sum_log['sum_qty']-$sum_log['sum_qty_set'];
        //         $update_transfer_log = $db->prepare("UPDATE transfer_stock_log SET transfer_qty=$sum,transfer_qty_set =NULL ,transfer_note=null  WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
        //         $update_transfer_log->execute();
        //         }elseif($set_up==3){
        //             $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 5 ,user3='$name'  WHERE transfer_stock_id  =$transfer_stock_id");
        //             $update_transfer_stock->execute();

        //             $update_transfer_stock_log = $db->prepare("UPDATE transfer_stock_log  SET transfer_stock_id  ='". $row_1['transfer_name']."'WHERE  transfer_stock_id =  '$set_new_transfer_stock_id'");
        //             $update_transfer_stock_log->execute();
        //         }elseif($set_up==4){
        //             $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 5 ,user3='$name'  WHERE transfer_stock_id  =$transfer_stock_id");
        //             $update_transfer_stock->execute();

        //             $update_transfer_stock_log = $db->prepare("UPDATE transfer_stock_log  SET transfer_stock_id  ='". $row_1['transfer_name']."'WHERE  transfer_stock_id =  '$set_new_transfer_stock_id'");
        //             $update_transfer_stock_log->execute();
        //             $delete_transfer_stock_log = $db->prepare("DELETE  FROM transfer_stock_log WHERE  transfer_note  ='".$row_2['transfer_stock_id']."'");
        //             $delete_transfer_stock_log->execute();
        //         }
        //         $set_i_1++;
                
        //         }
        //     } -->