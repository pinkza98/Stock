<?php  
include("../database/db.php");
$number = count($_POST["stock_id"]); 

    for($i=0; $i<$number; $i++){  
        $stock_id = $_POST["stock_id"][$i]; 
        $bn_id = $_POST["bn_id"][$i];
        $qty = $_POST["qty"][$i];
        $price_stock = $_POST["price_stock"][$i];
        // $exd_date = $_POST["exd_date"];
        $exd_date =NULL;
        $user_name = "เจ้าหน้าที่ไอที";
        try {
            $insert_full_stock = $db->prepare("INSERT INTO branch_stock (stock_id,bn_stock) VALUES ('.$stock_id.','.$bn_id.')");

            $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_name_log,exp_date_log,item_quantity,exd_date_log,full_stock_id_log,price_stock_log) VALUES ('$user_name',NOW(),'.$qty.','.$exd_date.',LAST_INSERT_ID(),'.$price_stock.')");
            if($insert_full_stock->execute()){
                if($insert_full_stock_log->execute()){
                    header("location:sub_test_3.php");
                }
            }
        }catch (PDOException $e) {
            echo "ERROR: ".$e->getMessage();
        }
    }
?> 