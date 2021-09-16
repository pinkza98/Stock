<?php 
include('../database/db.php');
   if(isset($_POST["code_item"])){
   $code= $_POST['code_item'];
   $bn=$_POST['bn_id'];
   $user_name=$_POST['user_name'];
   $status=$_POST['status'];
   $code = lcfirst($code);
if(isset($status)!==false){
   $select_item =$db->prepare("SELECT item_id,item_name,code_item,price_stock,exd_date FROM item WHERE code_item='$code'");
   $select_item->execute();
   $row_item = $select_item->fetch(PDO::FETCH_ASSOC);
   extract($row_item);
   if($row_item['code_item']!= $code){
    $errorMsg ="ไม่มีรหัสนี้อยู่ในระบบ";
   }else{
   $select_bn = $db ->query("SELECT * FROM branch WHERE bn_id = '$bn'");
   $select_bn->execute();
   $row_bn = $select_bn->fetch(PDO::FETCH_ASSOC);
   $bn_name = $row_bn['bn_name'];
   $bn_id = $row_bn['bn_id'];
   $bn_acronym = $row_bn['bn_acronym'];
   

   if($status =="transfer"){
      $bn2 = $_POST['bn_id_end'];
      $select_bn2 = $db ->query("SELECT * FROM branch WHERE bn_id = '$bn2'");
      $select_bn2->execute();
      $row_bn2 = $select_bn2->fetch(PDO::FETCH_ASSOC);
      $bn_name2 = $row_bn2['bn_name'];
      $bn_id2 = $row_bn2['bn_id'];
      $bn2_acronym = $row_bn2['bn_acronym'];
   }

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
   $exd_date_gen =NULL;
   }else{
     
      $date=date_create();
      $data_date_set  = '+'.$exd_date.' days';
      $exd_date_set2=date_modify($date,"".$data_date_set);
      $exd_date_gen=date_format($exd_date_set2 ,"Y-m-d" );
   



   }
   if(!empty($errorMsg)){
      echo $errorMsg;
   }elseif($status =="transfer"){
      $list_item = array('stock_id'=>$stock_id,'item_name'=>$item_name,'code_item'=>$code_item,'sum_item'=>$sum,'bn_name'=>$bn_name,'exd_date'=>$exd_date_gen,'bn_id'=>$bn_id,'price_stock'=>$price_stock,'user_name'=>$user_name,'status'=>$status,'bn_id2'=>$bn_id2,'bn_name2'=>$bn_name2,'bn_acronym'=>$bn_acronym,'bn2_acronym'=>$bn2_acronym);
   }
   else{
   $list_item = array('stock_id'=>$stock_id,'item_name'=>$item_name,'code_item'=>$code_item,'sum_item'=>$sum,'bn_name'=>$bn_name,'exd_date'=>$exd_date_gen,'bn_id'=>$bn_id,'price_stock'=>$price_stock,'user_name'=>$user_name,'status'=>$status);
   }
   echo json_encode($list_item,JSON_UNESCAPED_UNICODE);
}
}
   ?>
