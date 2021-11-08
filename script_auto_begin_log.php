<?php 
include_once("database/db.php");
$Key = $_REQUEST['txt_key'];
if ($Key=="It898989!@#") {
    $date_now=date_create();
    $date_now = $date_now->format('Y-m-d');
    $select_stock_id = $db->prepare("SELECT stock_id FROM branch_stock GROUP BY stock_id ORDER BY stock_id ASC");
    $select_stock_id->execute();
    while ($row_stock_id = $select_stock_id->fetch(PDO::FETCH_ASSOC) ) {
        $select_branch_stock_count = $db->prepare("SELECT stock_id,bn_stock  FROM branch_stock  WHERE stock_id=".$row_stock_id['stock_id']." GROUP BY  bn_stock,stock_id ORDER BY stock_id ASC ");
        $select_branch_stock_count->execute();
        $row_branch_stock_count = $select_branch_stock_count->rowCount();
        $select_branch_stock = $db->prepare("SELECT stock_id,bn_stock,SUM(item_quantity) as sum_item FROM branch_stock INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log WHERE stock_id = ".$row_stock_id['stock_id']."  GROUP BY  bn_stock,stock_id ORDER BY bn_stock ASC ");
        $select_branch_stock->execute();
        $row_sum_item = $select_branch_stock->fetch(PDO::FETCH_ASSOC);
        while ($row_stock_id_count = $select_branch_stock_count->fetch(PDO::FETCH_ASSOC) ) {
            if($row_sum_item['bn_stock']==1){
                $begin_branch = "cn";

            }elseif($row_sum_item['bn_stock']==2){
                $begin_branch = "ra";

            }elseif($row_sum_item['bn_stock']==3){

                $begin_branch = "ar";
                
            }elseif($row_sum_item['bn_stock']==4){
                $begin_branch = "sa";
                
            }elseif($row_sum_item['bn_stock']==5){
                $begin_branch = "as_1";
                
            }elseif($row_sum_item['bn_stock']==6){
                $begin_branch = "on_1";
                
            }elseif($row_sum_item['bn_stock']==7){
                $begin_branch = "ud";
                
            }elseif($row_sum_item['bn_stock']==8){
                $begin_branch = "nw";
                
            }elseif($row_sum_item['bn_stock']==9){
                $begin_branch = "cw";
                
            }elseif($row_sum_item['bn_stock']==10){
                $begin_branch = "r2";
                
            }elseif($row_sum_item['bn_stock']==11){
                $begin_branch = "lb";
                
            }elseif($row_sum_item['bn_stock']==12){
                $begin_branch = "bk";
                
            }elseif($row_sum_item['bn_stock']==13){
                $begin_branch = "hq";
                
            }else{
                echo "unkow bn_stock";
            }
            $select_begin_log = $db->prepare("SELECT * FROM begin_log WHERE stock_begin = ".$row_stock_id['stock_id']." AND date_begin = NOW()");
            $select_begin_log->execute();
            $row_begin_log = $select_begin_log->fetch(PDO::FETCH_ASSOC);
            $row_begin_log_count = $select_begin_log->rowCount();
            if($row_begin_log_count==false) {
                $insert_begin_log = $db->prepare("INSERT INTO begin_log (stock_begin,date_begin,$begin_branch) VALUES (".$row_stock_id['stock_id'].",NOW(),".$row_sum_item['sum_item'].")");
                $insert_begin_log->execute();
            }elseif($row_begin_log_count==true) {
                $select_begin_log_update = $db->prepare("SELECT * FROM begin_log WHERE stock_begin =".$row_stock_id['stock_id']." ORDER BY date_begin ASC LIMIT 1");
                $select_begin_log_update->execute();
                $row_begin_log_update = $select_begin_log_update->fetch(PDO::FETCH_ASSOC);
                $update_begin_log = $db->prepare("UPDATE begin_log SET $begin_branch=".$row_sum_item['sum_item']." WHERE begin_id = ".$row_begin_log_update['begin_id']."");
                $update_begin_log->execute();
            }else{
                echo "unkow";
            }
            

        }//loop2 เช็คจำนวนที่อยู่ในรายการนั้นมีกี่สาขา
    }//loop แรก
}//isset ใหญ่่
else{
    echo "รหัสคำสั่งไม่ถูกต้องไม่ถูกต้อง";
}
    ?>