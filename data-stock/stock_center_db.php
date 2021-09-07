<?php  
include("../database/db.php");
$number = count($_POST["stock_id"]); 

    for($i=0; $i<$number; $i++){  
        $stock_id = $_POST["stock_id"][$i]; 
        $bn_id = $_POST["bn_id"][$i];
        $qty = $_POST["qty"][$i];
        $price_stock = $_POST["price_stock"][$i];
        $exd_date =$_POST["exd_date"][$i];
        $user_name = $_POST["user_name"][$i];
        try {
            $insert_full_stock = $db->prepare("INSERT INTO branch_stock (stock_id,bn_stock) VALUES ('.$stock_id.','.$bn_id.')");
            if($exd_date != 0000-00-00 AND $exd_date != NULL){
                $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,item_quantity,exd_date_log,full_stock_id_log,price_stock_log) VALUES ('$user_name',NOW(),'.$qty.','$exd_date',LAST_INSERT_ID(),'.$price_stock.')");
            }elseif(strtotime($exd_date) <= 62169984000){
                $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,item_quantity,exd_date_log,full_stock_id_log,price_stock_log) VALUES ('$user_name',NOW(),'.$qty.',NULL,LAST_INSERT_ID(),'.$price_stock.')");
            }
            if($insert_full_stock->execute()){
                if($insert_full_stock_log->execute()){
                    echo "เพิ่มข้อมูลสำเร็จ >".$exd_date;  
                }else{
                    echo "พบข้อผิดพลาด full stock bn ไม่ทำงาน";
                }
            }else{
                echo "พบข้อผิดพลาด stock bn ไม่ทำงาน";
            }
        }catch (PDOException $e) {
            echo "ERROR: ".$e->getMessage();
        }
    }
?> 