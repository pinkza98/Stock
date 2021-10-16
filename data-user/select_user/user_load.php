<?php 
include('../../database/db.php');
if(isset($_POST["all"])){


   $list_user = array('stock_id'=>$stock_id,'item_name'=>$item_name,'code_item'=>$code_item,'sum_item'=>$sum,'bn_name'=>$bn_name,'exd_date'=>$exd_date_gen,'bn_id'=>$bn_id,'price_stock'=>$price_stock,'user_name'=>$user_name,'status'=>$status,'unit_name'=>$unit_name);
   
   echo json_encode($list_item,JSON_UNESCAPED_UNICODE);
}elseif(isset($_POST['one'])){

}

   ?>