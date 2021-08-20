<?php 
include_once('../database/db.php');


$select_stock_full_log = $db->query("SELECT full_stock_id_log,branch_stock_log.stock_log_id,item_quantity  FROM branch_stock_log  
INNER JOIN branch_stock ON  branch_stock_log.full_stock_id_log = branch_stock.full_stock_id 
WHERE branch_stock.bn_stock = 10 AND branch_stock.stock_id = 1 ");

$row_count = $select_stock_full_log->rowCount();

 
echo $row_count;



  
 

?>
