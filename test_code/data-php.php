<?php 
   if (isset($_REQUEST['code_item_check'])) {

    $code_item_check = $_REQUEST['code_item_check'];
    $bn_id =$_REQUEST['txt_user_bn'];

    $select_item =$db->query("SELECT code_item,item_id,item_name FROM item WHERE code_item='$code_item_check'");
    $select_item->execute();
    $row_item = $select_item->fetch(PDO::FETCH_ASSOC);
    @@extract($row_item);
    
//     if($row_item['code_item']!= $code_item_check){
//     $errorMsg = "รหัสบาร์โค้ดนี้ยังไม่มีในระบบ";
//     $item_id = $select_item->fetch();
//     }else{
//     @@$select_stock =$db->prepare("SELECT bn_name,SUM(branch_stock_log.item_quantity) as sum ,item.item_id,code_item,item_name FROM stock 
//     INNER JOIN branch_stock ON stock.stock_id = branch_stock.stock_id
//     INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
//     INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
//     INNER JOIN item ON stock.item_id = item.item_id
//     WHERE code_item='$code_item' AND branch_stock.bn_stock ='$bn_id' ");
//     $select_stock->execute();
//     $row_stock = $select_stock->fetch(PDO::FETCH_ASSOC);
//     @@extract($row_stock);
// }
    

   $list_item = array('item_id'=>'$item_id','item_name'=>'$item_name','code_item'=>'$code_item');
   echo json_encode($list_item);

}

?>