<?php  
include("../database/db.php");
date_default_timezone_set("Asia/Bangkok");
$date = new DateTime();
$date_nows = $date->format('Y-m-d H:i:s');
$status_out = "ส่งออก";
$status_in = "รับโอน";
if($_POST['status']=="pass"){ //function อนุมัติรายการขอโอนย้าย
$transfer_stock_id=$_POST['uid'];
 $text1=$_POST['text1'];
 $name=$_POST['name'];
 $credit=$_POST['credit'];
 $user_id=$_POST['user_id'];
    $select_transfer_stock = $db->prepare("SELECT * FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id WHERE transfer_stock.transfer_id  = '$transfer_stock_id'");
    $select_transfer_stock->execute();
    $row_transfer_stock = $select_transfer_stock->fetch(PDO::FETCH_ASSOC);
    extract($row_transfer_stock);

    $select_transfer_credit = $db->prepare("SELECT SUM(transfer_qty*transfer_price) as sum_price  FROM transfer_stock_log WHERE transfer_stock_id = '$transfer_name'");
    $select_transfer_credit->execute();
    $row_transfer_credit = $select_transfer_credit->fetch(PDO::FETCH_ASSOC);
    
    if($credit >= $row_transfer_credit['sum_price'] ){
        $select_stock_log = $db->prepare("SELECT * from branch_stock_log WHERE status_log ='$transfer_name'");
        if($select_stock_log->execute()){
            while ($row_stock_log = $select_stock_log->fetch(PDO::FETCH_ASSOC)) {
                $select_branch_stock = $db->prepare("SELECT stock_id,bn_stock from branch_stock WHERE full_stock_id =".$row_stock_log['full_stock_id_log']."");
                $select_branch_stock->execute();
                $row_branch_stock = $select_branch_stock->fetch(PDO::FETCH_ASSOC);

                if($row_stock_log['remain_log']!=null){
                    // เก็บที่มีการส่ง


                    $sum_log = $row_stock_log['item_quantity'] - $row_stock_log['remain_log'];
                    $update_stock_bn_user_last = $db->prepare("UPDATE branch_stock SET transfer_date='".$date_nows."' , transfer_quantity = ".$sum_log." ,transfer_status = '".$status_out."'  WHERE stock_id = ".$row_branch_stock['stock_id']." AND bn_stock= ".$row_branch_stock['bn_stock']." ");
                    $update_stock_bn_user_last ->execute();
                    $remain = $row_stock_log['remain_log'];
                    $update_stock_stock_log = $db->prepare("UPDATE branch_stock_log SET item_quantity =$remain,status_log =null,remain_log=null WHERE stock_log_id =".$row_stock_log['stock_log_id']."");
                    $update_stock_stock_log ->execute()
                    ;
                }else{
                    // เก็บที่มีการส่ง
                    $update_stock_bn_user_last = $db->prepare("UPDATE branch_stock SET transfer_date='".$date_nows."' , transfer_quantity = ".$row_stock_log['item_quantity']." ,transfer_status = '".$status_out."'  WHERE stock_id = ".$row_branch_stock['stock_id']." AND bn_stock= ".$row_branch_stock['bn_stock']." ");
                    $update_stock_bn_user_last ->execute();
                    $select_stock_log_del = $db->prepare("DELETE FROM branch_stock_log WHERE stock_log_id  = '".$row_stock_log['stock_log_id']."'");
                    $select_stock_del = $db->prepare("DELETE FROM branch_stock WHERE full_stock_id  = '".$row_stock_log['full_stock_id_log']."'");
                    if($select_stock_del->execute()){
                        $select_stock_log_del->execute();
                    }
                }
                
                
            }
            $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 2 ,note2 = '$text1',user2='$name' WHERE transfer_stock_id  ='$transfer_stock_id'");
            $update_transfer_stock->execute();
            $credit = $credit-$row_transfer_credit['sum_price'];
            $update_credit_user=$db->prepare("UPDATE user SET credit =$credit WHERE user_id = '$user_id'");
            $update_credit_user->execute();
            
            
            
            echo "สำเร็จ";
        }
    }else{
            echo "เครดิตของคุณไม่เพียงพอ!!!";
    }

        
    
   
}elseif($_POST['status']=="no_pass"){ //function ไม่อนุมัติรายการขอโอนย้าย
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
}elseif($_POST['status']=="set_carry"){ // ตั้งค่าตัวรับยอดสินค้า
    $transfer_stock_id=$_POST['uid'];
    $text1=$_POST['text1'];
     $text2=$_POST['text2'];
     $text3=$_POST['text3'];
    $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 4,transfer_service ='$text1',code_service='$text2',transfer_price=$text3  WHERE transfer_stock_id  ='$transfer_stock_id'");
    if($update_transfer_stock->execute()){
        echo "บันทึกข้อมูลขนส่งเรียบร้อย";
    }
    
}elseif($_POST['status']=="del_row"){ //ลบข้อมูลแถวที่ไม่อนุมัติผ่าน
    $transfer_stock_id=$_POST['uid'];
    $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 6  WHERE transfer_stock_id  ='$transfer_stock_id'");
    $update_transfer_stock->execute();
    // $select_transfer_stock_log_del = $db->prepare("DELETE FROM transfer_stock_log WHERE transfer_stock_id  = '$transfer_name'"); // ลบข้อมูล t_stock_log ตาม t_stock_log (7)
    // if($select_transfer_stock_log_del->execute()){
        echo "จัดการบันทึกรายการยกเลิกสำเร็จ";
    // }
}elseif($_POST['status']=="add_stock"){ //กดรับสินค้าโอนเข้าคลัง สาขา หรือ สาขาอื่น
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
                            if($sum_log['sum_qty_set']%$row_count_log ==0){
                                
                                $sum_divide =$sum_log['sum_qty_set']/$row_count_log; 
                            
                            }else{
                                if($row_count_2 == ($count2+1)){
                                    $n=$sum_log['sum_qty_set']%$row_count_log;
                                    $sum_divide =($sum_log['sum_qty_set']-$n)/$row_count_log;
                                    $sum_divide = $sum_divide+$n;
                                }else{ 
                                    $n=$sum_log['sum_qty_set']%$row_count_log;
                                    $sum_divide =($sum_log['sum_qty_set']-$n)/$row_count_log;
                                }
                            }
                            if($sum_log['sum_qty']!=$sum_log['sum_qty_set']){ 
                                $status_transfer = 1;
                                
                                $update_transfer_stock_log = $db->prepare("UPDATE transfer_stock_log  SET transfer_qty=$sum_divide, transfer_stock_id =  '$set_new_transfer_stock_id' WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
                                $update_transfer_stock_log->execute();
                                $count2++;
                            }
                            // elseif($sum_log['sum_qty_set']==0){
                            //     $count2++;
                            //     $status_transfer = 2;
                            // }
                            else{

                                $status_transfer = 2;
                                $update_transfer_stock_log = $db->prepare("UPDATE transfer_stock_log  SET  transfer_qty=$sum_divide, transfer_stock_id =  '$set_new_transfer_stock_id' WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
                                $update_transfer_stock_log->execute();
                                $count2++;
                            }
                            }else{
                                if($status_transfer == 1){
                                    $insert_full_stock = $db->prepare("INSERT INTO branch_stock (bn_stock,stock_id) VALUES (".$row_1['bn_id_2'].",".$row_2['stock_id'].")");
                                    $insert_full_stock->execute();
                                    $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,exd_date_log,item_quantity,full_stock_id_log,price_stock_log) VALUES ('$name',NOW(),'".$row_2['item_date']."','".$sum_log['sum_qty_set']."',LAST_INSERT_ID(),".$row_2['transfer_price'].")");    
                                    $insert_full_stock_log->execute();
                                    //นับเข้าเช็ครายการรับ
                                    if($sum_log['sum_qty_set'] != 0 ){
                                        $update_stock_bn_date_time = $db->prepare("UPDATE branch_stock SET transfer_date='".$date_nows."' , transfer_quantity = ".$sum_log['sum_qty_set']." ,transfer_status = '".$status_in."'  WHERE stock_id = ".$row_2['stock_id']." AND bn_stock= ".$row_1['bn_id_2']." ");
                                        $update_stock_bn_date_time ->execute();
                                    }
                                    
                                    $sum=$sum_log['sum_qty']-$sum_log['sum_qty_set'];
                                    $update_transfer_log = $db->prepare("UPDATE transfer_stock_log SET transfer_qty=$sum,transfer_qty_set =NULL ,transfer_note=null  WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
                                    $update_transfer_log->execute();
                                }elseif($status_transfer == 2){  
                                    $insert_full_stock = $db->prepare("INSERT INTO branch_stock (bn_stock,stock_id) VALUES (".$row_1['bn_id_2'].",".$row_2['stock_id'].")");
                                    $insert_full_stock->execute();
                                    $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,exd_date_log,item_quantity,full_stock_id_log,price_stock_log) VALUES ('$name',NOW(),'".$row_2['item_date']."','".$sum_log['sum_qty_set']."',LAST_INSERT_ID(),".$row_2['transfer_price'].")");    
                                    $insert_full_stock_log->execute();
                                    //นับเข้าเช็ครายการรับ
                                    $update_stock_bn_date_time = $db->prepare("UPDATE branch_stock SET transfer_date='".$date_nows."' , transfer_quantity = ".$sum_log['sum_qty_set']." ,transfer_status = '".$status_in."'  WHERE stock_id = ".$row_2['stock_id']." AND bn_stock= ".$row_1['bn_id_2']." ");
                                    $update_stock_bn_date_time ->execute();
                                    $sum_divide =$sum_log['sum_qty_set']/$row_count_log;
                                    $sum=$sum_log['sum_qty']-$sum_log['sum_qty_set'];
                                    $update_transfer_log = $db->prepare("UPDATE transfer_stock_log SET transfer_qty=$sum,transfer_qty_set =NULL ,transfer_note=null  WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
                                    $update_transfer_log->execute();
                                    $delete_transfer_stock_log = $db->prepare("DELETE  FROM transfer_stock_log WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
                                    $delete_transfer_stock_log->execute();
                                }else{
                                    echo "เกิดข้อผิดพลาดหลุดลูปจำนวน";
                                }
                    }
                }
                }else{
                    //สำหรับไม่ต้องถอน
                    //เก็บstatus
                    while ($row_2 = $select_transfer_log->fetch(PDO::FETCH_ASSOC) ) {//loop2 ลูปเช็คค่า
                        if($row_count_2 > $count2){//stap1
                            if($sum_log['sum_qty_set']%$row_count_log ==0){
                                $sum_divide =$sum_log['sum_qty_set']/$row_count_log;
                            }else{
                                if($row_count_2 == $count2+1){
                                    $n=$sum_log['sum_qty_set']%$row_count_log;
                                    $sum_divide =$sum_log['sum_qty_set']/$row_count_log+($n);
                                }else{
                                    $n=$sum_log['sum_qty_set']%$row_count_log;
                                    $sum_divide =($sum_log['sum_qty_set']-$n)/$row_count_log;
                                }
                            }
                        $status_transfer = 3;
                        $insert_full_stock = $db->prepare("INSERT INTO branch_stock (bn_stock,stock_id) VALUES (".$row_1['bn_id_2'].",".$row_2['stock_id'].")");
                        $insert_full_stock->execute();
                        $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,exd_date_log,item_quantity,full_stock_id_log,price_stock_log) VALUES ('$name',NOW(),'".$row_2['item_date']."','$sum_divide',LAST_INSERT_ID(),".$row_2['transfer_price'].")");    
                        $insert_full_stock_log->execute();
                        //นับเข้าเช็ครายการรับ
                        $update_stock_bn_date_time = $db->prepare("UPDATE branch_stock SET transfer_date='".$date_nows."' , transfer_quantity = ".$sum_log['sum_qty_set']." ,transfer_status = '".$status_in."'  WHERE stock_id = ".$row_2['stock_id']." AND bn_stock= ".$row_1['bn_id_2']." ");
                        $update_stock_bn_date_time ->execute();
                        $count2++;
                        }else{
                        $sum=$sum_log['sum_qty']-$sum_log['sum_qty_set'];
                        // $update_transfer_log = $db->prepare("UPDATE transfer_stock_log SET transfer_qty=$sum,transfer_qty_set =NULL ,transfer_note=null  WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
                        // $update_transfer_log->execute();
                        $delete_transfer_stock_log = $db->prepare("DELETE  FROM transfer_stock_log WHERE transfer_log_id = ".$row_2['transfer_log_id']."");
                        $delete_transfer_stock_log->execute();
                        }
                    }
                } 
            }
            else{
                echo "Error";
            }
        } 
        if($status_transfer ==1){
            echo "ยังมียอดค้าง";
            $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 4 ,user3='$name',transfer_date=NOW()  WHERE transfer_stock_id  =$transfer_stock_id");
            $update_transfer_stock->execute();
            if($transfer['transfer_id']==null){ 
                $insert_transfer =$db->prepare("INSERT INTO transfer (transfer_name)VALUES('$set_new_transfer_stock_id')");
                $insert_transfer->execute();
                $insert_transfer_stock = $db->prepare("INSERT INTO transfer_stock (bn_id_1,bn_id_2,transfer_id,transfer_status,user3,note3,transfer_date)VALUES(".$row_1['bn_id_1'].",".$row_1['bn_id_2'].",LAST_INSERT_ID(),5,'$name','รายการมียอดค้างอยู่',NOW())");
                $insert_transfer_stock->execute();
            }
        }elseif($status_transfer ==2){
            echo "ยังมียอดค้าง";
            $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 4 ,user3='$name',transfer_date=NOW()  WHERE transfer_stock_id  =$transfer_stock_id");
            $update_transfer_stock->execute();
            if($transfer['transfer_id']==null){ 
                $insert_transfer =$db->prepare("INSERT INTO transfer (transfer_name)VALUES('$set_new_transfer_stock_id')");
                $insert_transfer->execute();
                $insert_transfer_stock = $db->prepare("INSERT INTO transfer_stock (bn_id_1,bn_id_2,transfer_id,transfer_status,user3,note3,transfer_date)VALUES(".$row_1['bn_id_1'].",".$row_1['bn_id_2'].",LAST_INSERT_ID(),5,'$name','รายการมียอดค้างอยู่',NOW())");
                $insert_transfer_stock->execute();
            }
        }elseif($status_transfer ==3){
            echo "รับสินค้าสำเร็จ";
            $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 5,user3='$name',note3='รับของครบแล้ว',transfer_date=NOW() WHERE transfer_stock_id  =$transfer_stock_id");
            $update_transfer_stock->execute();
            $update_transfer_stock_log = $db->prepare("UPDATE transfer_stock_log  SET transfer_stock_id = '".$row_1['transfer_name']."' WHERE transfer_stock_id =  '$set_new_transfer_stock_id'");
            if($update_transfer_stock_log->execute()){
                $select_transfer_del = $db->prepare("SELECT transfer_id,transfer_name FROM transfer WHERE transfer_name = '$set_new_transfer_stock_id'");//หาค่าตาราง - 1 ที่เป็นยอดค้างเพิ่มนำมาลบตารางทิ้ง
                $select_transfer_del->execute();
                $row_transfer_del = $select_transfer_del->fetch(PDO::FETCH_ASSOC);
                 if($row_transfer_count = $select_transfer_del->rowCount() == true){
                    $delete_transfer_stock = $db->prepare("DELETE  FROM transfer_stock WHERE transfer_id = ".$row_transfer_del['transfer_id']."");
                    $delete_transfer_stock->execute();
                    $delete_transfer = $db->prepare("DELETE  FROM transfer WHERE transfer_id = ".$row_transfer_del['transfer_id']."");
                    $delete_transfer->execute();
                 }

            }
            
        }else{
            echo "หลุดลูป";
        }
           
        }
}else{
echo "error";
}
?>