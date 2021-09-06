<?php  
 include("../database/db.php");

 $qty = count($_POST["qty"]);
 $stock_id = count($_POST["stock_id"]);

 if($number > 0)  
 {  
      for($i=0; $i<$stock_id; $i++)
      {  
          
           
             $insert_stock_item = $db->prepare("INSERT INTO branch_stock(stock_id,bn_stock) VALUES('".$_POST["stock_id"][$i]."','".$_POST["qty"][$i].")");  
             $insert_stock_item->execute(); 
                 
           
      }  
      echo "สำเร็จ";  
      
 }  
 else  
 {  
      echo "ผิดพลาด";  
 }  
 ?> 