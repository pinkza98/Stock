<?php  
include("../database/db.php");

if($_POST['status']=="pass"){
$transfer_stock_id=$_POST['uid'];
 $text1=$_POST['text1'];

$update_transfer_stock = $db->prepare("UPDATE transfer_stock SET transfer_status = 2 ,note2 = '$text1' WHERE transfer_stock_id  ='$transfer_stock_id'");
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
}
else{
   echo "error";
}
?>