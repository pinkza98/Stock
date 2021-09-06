<?php 
include('../database/db.php');
   if(isset($_POST["code_item"])){
   $code= $_POST['code_item'];
   $bn=$_POST['bn_id'];
   
   
   $select_item =$db->prepare("SELECT code_item,item_id,item_name FROM item WHERE code_item='$code'");
   
   $select_item->execute();
   $row_item = $select_item->fetch(PDO::FETCH_ASSOC);
   extract($row_item);
   if($code_item != $code){
     echo $errorMsg ="ไม่มีรหัสนี้อยู่ในระบบ";
   }
   
   $select_stock =$db->prepare("SELECT SUM(branch_stock_log.item_quantity) as sum ,item.item_id,code_item,item_name FROM stock 
   INNER JOIN branch_stock ON stock.stock_id = branch_stock.stock_id
   INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
   INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
   INNER JOIN item ON stock.item_id = item.item_id
   WHERE code_item='$code_item' AND branch_stock.bn_stock ='$bn'");
   $select_stock->execute();
   $row_stock = $select_stock->fetch(PDO::FETCH_ASSOC);
   extract($row_stock);
   if(is_null($sum)){
     $sum = 0;
   }
     $select_bn = $db ->query("SELECT * FROM branch WHERE bn_id = '$bn'");
     $select_bn->execute();
     $row_bn = $select_bn->fetch(PDO::FETCH_ASSOC);
     extract($row_bn);
     $bn_name = $row_bn['bn_name'];
 

   $list_item = array('item_id'=>$item_id,'item_name'=>$item_name,'code_item'=>$code_item,'sum_item'=>$sum,'bn_name'=>$bn_name);
   
   echo json_encode($list_item,JSON_UNESCAPED_UNICODE);
}
   
