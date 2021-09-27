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

$update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 3 ,note2 = '$text1' WHERE transfer_stock_id  ='$transfer_stock_id'");//set t_stock status ไม่อนุมัติ และโน๊ต และ user2 (1)
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
    $update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 5 ,user3='$name'  WHERE transfer_stock_id  ='$transfer_stock_id'");
    $update_transfer_stock->execute();

    $select_transfer_stock = $db->prepare("SELECT * FROM transfer_stock INNER JOIN transfer ON transfer_stock.transfer_id = transfer.transfer_id WHERE transfer_stock.transfer_id  = '$transfer_stock_id'");
    $select_transfer_stock->execute();
    $row_transfer_stock = $select_transfer_stock->fetch(PDO::FETCH_ASSOC);
    

    $select_transfer_stock_log = $db->prepare("SELECT * FROM transfer_stock_log  WHERE transfer_stock_id  = '".$row_transfer_stock['transfer_name']."'"); 
    if($select_transfer_stock_log->execute()){
    while ($row_transfer_log = $select_transfer_stock_log->fetch(PDO::FETCH_ASSOC) ) {
        $insert_full_stock = $db->prepare("INSERT INTO branch_stock (bn_stock,stock_id) VALUES (".$row_transfer_stock['bn_id_2'].",".$row_transfer_log['stock_id'].")");
        if($insert_full_stock->execute()){
        $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,exd_date_log,item_quantity,full_stock_id_log,price_stock_log) VALUES ('$name',NOW(),'".$row_transfer_log['item_date']."',".$row_transfer_log['transfer_qty'].",LAST_INSERT_ID(),".$row_transfer_log['transfer_price'].")");    
        $insert_full_stock_log->execute();
        }else{
            echo "เพิ่มข้อมูลไม่สำเร็จ";
        }
        
    }
}
    echo "เพิ่มเข้าคลังสินค้าสำเร็จ";
}else{
   echo "error";
}
?>