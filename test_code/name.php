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
             $insert_stock_item = $db->prepare("INSERT INTO tbl_name(name,qty) VALUES('".$_POST["name"][$i]."','".$_POST["qty"][$i]."')");  
             $insert_stock_item->execute(); 
                 
           }  
      }  
      echo "สำเร็จ";  
      
 }  
 else  
 {  
      echo "Please Enter Name";  
 }  
 ?> 