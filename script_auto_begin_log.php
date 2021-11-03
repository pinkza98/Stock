<?php 
include_once("database/db.php");
if (isset($_REQUEST['begin_update'])=="dGpQ7w@uWHs2KtS") {
    $date_now=date_create();
    $select_stock_id = $db->prepare("SELECT stock_id as sum_item FROM branch_stock GROUP BY stock_id ORDER BY stock_id ASC");
    $select_stock_id->execute();
    while ($row_stock_id = $select_stock_id->fetch(PDO::FETCH_ASSOC) ) {
        $select_branch_stock_count = $db->prepare("SELECT stock_id,bn_stock  FROM branch_stock  WHERE stock_id=".$row_stock_id['stock_id']." GROUP BY  bn_stock,stock_id ORDER BY stock_id ASC ");
        $select_branch_stock_count->execute();
        $row_branch_stock_count = $select_branch_stock_count->rowCount();
        $select_branch_stock = $db->prepare("SELECT stock_id,bn_stock,SUM(item_quantity) as sum_item FROM branch_stock INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log WHERE stock_id = ".$row_stock_id['stock_id']."  GROUP BY  bn_stock,stock_id ORDER BY bn_stock ASC ");
        $select_branch_stock->execute();
        while ($row_stock_id_count = $select_branch_stock_count->fetch(PDO::FETCH_ASSOC) ) {
            $select_begin_log = $db->prepare("SELECT * FROM begin_log WHERE stock_id = ".$row_stock_id['stock_id']." AND date_begin = ".$date_now." ");
            $select_begin_log->execute();
            $row_begin_log = $select_begin_log->fetch(PDO::FETCH_ASSOC);
            if(is_null($row_begin_log)){
                $insert_begin_log = $db->prepare("INSERT INTO begin_log (stock_id,date_begin,begin_log_count) VALUES (".$row_stock_id['stock_id'].",".$date_now.",".$row_branch_stock_count.")");
                $insert_begin_log->execute();
            }else{
               //update 
            }
            

        }//loop2 เช็คจำนวนที่อยู่ในรายการนั้นมีกี่สาขา
    }//loop แรก
}//isset ใหญ่่
    ?>