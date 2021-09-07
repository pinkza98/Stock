<?php  
include("../database/db.php");
$stock_id = count($_POST["stock_id"]);  
// $qty = count($_POST["qty"]);
$bn_id = count($_POST["bn_id"]);
// $price_stock = count($_POST["price_stock"]);
// $exd_date = count($_POST["exd_date"]);
// $user_full_name = count($_POST["user_full_name"]);

     for($i=0; $i<2; $i++)  
     {  
                    try {
                         $insert_full_stock = $db->prepare("INSERT INTO branch_stock (stock_id,bn_stock) VALUES ('".$_POST["stock_id"][$i]."','".$_POST["bn_id"][$i]."')");

                         if ($insert_full_stock->execute()) {
                              echo  "เพิ่มข้อมูลสำเร็จ...";
                              header("refresh:1;sub_test_3.php");
                         }
                    }
               
                    catch (PDOException $e) {
                    echo $e->getMessage();
                    
                    }
     }  
     echo "สำเร็จ";  
     

?> 