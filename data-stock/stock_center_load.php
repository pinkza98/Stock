<?php 
include('../database/db.php');
   if(isset($_POST["code_item"])){
   $code= $_POST['code_item'];
   $bn=$_POST['bn_id'];
   $user_name=$_POST['user_name'];

   $select_item =$db->prepare("SELECT item_id,item_name,code_item,price_stock,exd_date FROM item WHERE code_item='$code'");
   $select_item->execute();
   $row_item = $select_item->fetch(PDO::FETCH_ASSOC);
   extract($row_item);
   if($row_item['code_item']!= $code){
   echo $errorMsg ="ไม่มีรหัสนี้อยู่ในระบบ";
   }else{
   $select_bn = $db ->query("SELECT * FROM branch WHERE bn_id = '$bn'");
   $select_bn->execute();
   $row_bn = $select_bn->fetch(PDO::FETCH_ASSOC);
   $bn_name = $row_bn['bn_name'];
   $bn_id = $row_bn['bn_id'];

   $select_stock =$db->prepare("SELECT stock_id FROM stock WHERE item_id ='$item_id'");
   $select_stock->execute();
   $row_stock = $select_stock->fetch(PDO::FETCH_ASSOC);
   extract($row_stock);

   $select_stock_bn =$db->prepare("SELECT SUM(branch_stock_log.item_quantity) as sum FROM branch_stock 
   INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
   WHERE stock_id='$stock_id' AND bn_stock ='$bn_id'");
   $select_stock_bn->execute();
   $row_stock_bn = $select_stock_bn->fetch(PDO::FETCH_ASSOC);
   extract($row_stock_bn);
   }
   if(is_null($row_stock_bn['sum'])){
    $sum = 0;
   }
   if(is_null($exd_date)){
   $exd_date =NULL;
   }
   if(!empty($errorMsg)){
      echo $errorMsg;
   }else{
   $list_item = array('stock_id'=>$stock_id,'item_name'=>$item_name,'code_item'=>$code_item,'sum_item'=>$sum,'bn_name'=>$bn_name,'exd_date'=>$exd_date,'bn_id'=>$bn_id,'price_stock'=>$price_stock,'user_name'=>$user_name);
   }
   echo json_encode($list_item,JSON_UNESCAPED_UNICODE);
}
   
