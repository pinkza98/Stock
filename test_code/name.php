<?php  
include("../database/db.php");
$number = count($_POST["name"]);  
$qty = count($_POST["qty"]);
if($number > 0)  
{  
     for($i=0; $i<$number; $i++)  
     {  
          if(trim($_POST["name"][$i] != ''))  
          {
               else {
                    try {
                         if (!isset($errorMsg)) {
                         $insert_full_stock = $db->prepare("INSERT INTO branch_stock (user_id,stock_id,bn_stock) VALUES (:user_id,:stock_id,:bn_stock)");
                         
                         $insert_full_stock->bindParam(':user_id', $stock_user_id);
                         $insert_full_stock->bindParam(':stock_id', $stock_id);
                         $insert_full_stock->bindParam(':bn_stock', $stock_bn_stock);

                         $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (user_id_log,exp_date_log,item_quantity,exd_date_log,full_stock_id_log,price_stock_log) VALUES (:user_id_log,NOW(),:item_quantity,:new_exd_date_log,LAST_INSERT_ID(),:new_price)");
                         $insert_full_stock_log->bindParam(':user_id_log', $stock_user_id);
                         $insert_full_stock_log->bindParam(':item_quantity', $stock_quantity);
                         $insert_full_stock_log->bindParam(':new_exd_date_log', $exd_date);
                         $insert_full_stock_log->bindParam(':new_price', $price_stock);
                         

                         if ($insert_full_stock->execute()) {
                              if($insert_full_stock_log->execute()){
                              $insertMsg = "เพิ่มข้อมูลสำเร็จ...";
                              // header("refresh:1;stock_center.php");
                              }else{
                              $insertMsg = "ตารางที่ Logมีปัญหา...";
                              }
                         }
                         else {
                              $errorMsg="การส่งข้อมูลเกิด เหตุขัดข้อง";
                         }
                         }
                         else {
                              $errorMsg="มีบ้างอย่าง error โปรดแจ้ง แอดมิน";
                         }
                    }
                    catch (PDOException $e) {
                    echo $e->getMessage();
                    
                    }
               }
               
          }
     }  
     echo "สำเร็จ";  
     
}  
else  
{  
     echo "Please Enter Name";  
}  
?> 