<?php  
include("../database/db.php");
$number = count($_POST["stock_id"]);  
$stock_id = $_POST["stock_id"];  
$qty = $_POST["qty"];
$bn_id = $_POST["bn_id"];
 $price_stock = $_POST["price_stock"];
// $exd_date = count($_POST["exd_date"]);
// $user_full_name = count($_POST["user_full_name"]);

     for($i=0; $i<$number; $i++)  
     {  
                    try {
                         $insert_full_stock = $db->prepare("INSERT INTO branch_stock (stock_id,bn_stock) VALUES ('".$_POST["stock_id"][$i]."','".$_POST["bn_id"][$i]."')");
                         $insert_full_stock_log = $db->prepare("INSERT INTO branch_stock_log (exp_date_log,item_quantity,full_stock_id_log,price_stock_log) VALUES (NOW(),'".$_POST["qty"][$i]."',LAST_INSERT_ID(),'".$_POST["price_stock"][$i]."')");
                         if ($insert_full_stock->execute()) {
                              if($insert_full_stock_log->execute()) {
                              echo  "เพิ่มข้อมูลสำเร็จ...";
                              header("refresh:1;sub_test_3.php");
                              }else{
                                   echo "stock_log ไม่ทำงาน";
                              }
                         }else{
                              echo "bn_stock ไม่ทำงาน";
                         }
                    }
               
                    catch (PDOException $e) {
                    echo $e->getMessage();
                    
                    }
     }  
     echo "สำเร็จ";  
     

?> 