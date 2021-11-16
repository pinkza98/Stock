<?php 
include_once("database/db.php");
$Key = $_REQUEST['txt_key'];
if ($Key=="start") {//start
    $date_now=date_create();
    $date_now = $date_now->format('Y-m-d');
    $select_stock_id = $db->prepare("SELECT stock_id FROM branch_stock GROUP BY stock_id ORDER BY stock_id ASC");//หาเลขทั้งหมดเรียงจากน้อยไปมาก
    $select_stock_id->execute();
    
    while ($row_stock_id = $select_stock_id->fetch(PDO::FETCH_ASSOC) ) {
        $select_branch_stock_count = $db->prepare("SELECT stock_id,bn_stock,SUM(item_quantity) as sum_item  FROM branch_stock  INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log WHERE stock_id = ".$row_stock_id['stock_id']." GROUP BY  bn_stock,stock_id ORDER BY bn_stock ASC ");//นำตัวเลขที่ได้มาคุ้นหาว่ามีกี่สาขา
        $select_branch_stock_count->execute();       
        while ($row_sum_item = $select_branch_stock_count->fetch(PDO::FETCH_ASSOC) ) {//ให้วิ่งกี่รอบ เช็คตามของที่มี
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
            
            $select_begin_log = $db->prepare("SELECT begin_id,date_begin,$begin_branch as begin_sum FROM begin_log WHERE stock_begin = ".$row_sum_item['stock_id']." AND date_begin = '".$date_now."' ORDER BY date_begin ASC  LIMIT 1");
            $select_begin_log->execute();
            $row_begin_log = $select_begin_log->fetch(PDO::FETCH_ASSOC);//ออกไปเช็คจำนวนดูก่อน
            $row_begin_log_count = $select_begin_log->rowCount();
            if($row_begin_log_count==false) {
                $insert_begin_log = $db->prepare("INSERT INTO begin_log (stock_begin,date_begin,$begin_branch) VALUES (".$row_sum_item['stock_id'].",NOW(),".$row_sum_item['sum_item'].")");
                $insert_begin_log->execute();
            }elseif($row_begin_log_count==true) {
                
                $select_begin_log_update = $db->prepare("SELECT * FROM begin_log WHERE stock_begin =".$row_sum_item['stock_id']." ORDER BY date_begin ASC LIMIT 1");
                $select_begin_log_update->execute();
                $row_begin_log_update = $select_begin_log_update->fetch(PDO::FETCH_ASSOC);
                $update_begin_log = $db->prepare("UPDATE begin_log SET $begin_branch=".$row_sum_item['sum_item']." WHERE begin_id = ".$row_begin_log_update['begin_id']."");
                $update_begin_log->execute();
            }else{
                echo "unkow";
            }
            

        }//loop2 เช็คจำนวนที่อยู่ในรายการนั้นมีกี่สาขา
    }//loop แรก
    header("refresh:1;data-user/ui_run_scrip.php");
}//isset ใหญ่่
elseif($Key=="It898989!@#"){//update/day
    $date_now=date_create();
    $date_now = $date_now->format('Y-m-d');
    $select_stock_id = $db->prepare("SELECT stock_id FROM branch_stock GROUP BY stock_id ORDER BY stock_id ASC");//หาเลขทั้งหมดเรียงจากน้อยไปมาก
    $select_stock_id->execute();
    
    while ($row_stock_id = $select_stock_id->fetch(PDO::FETCH_ASSOC) ) {
        $select_branch_stock_count = $db->prepare("SELECT stock_id,bn_stock,SUM(item_quantity) as sum_item  FROM branch_stock  INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log WHERE stock_id = ".$row_stock_id['stock_id']." GROUP BY  bn_stock,stock_id ORDER BY bn_stock ASC ");//นำตัวเลขที่ได้มาคุ้นหาว่ามีกี่สาขา
        $select_branch_stock_count->execute();       
        while ($row_sum_item = $select_branch_stock_count->fetch(PDO::FETCH_ASSOC) ) {//ให้วิ่งกี่รอบ เช็คตามของที่มี
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
            $select_begin_log = $db->prepare("SELECT begin_id,date_begin,stock_begin,$begin_branch as begin_sum FROM begin_log WHERE stock_begin = ".$row_sum_item['stock_id']." ORDER BY begin_id ASC  LIMIT 1");
            $select_begin_log->execute();//เช็คฝั่ง log begin ล่าสุด
            $row_begin_log = $select_begin_log->fetch(PDO::FETCH_ASSOC);//ออกไปเช็คจำนวนดูก่อน 
            $row_begin_log_count = $select_begin_log->rowCount();
            if($row_begin_log['begin_sum']==$row_sum_item['sum_item']){

            }else{
                
                $select_begin_log_new1 = $db->prepare("SELECT * FROM begin_log WHERE stock_begin = ".$row_sum_item['stock_id']." ORDER BY begin_id ASC  LIMIT 1");
                $select_begin_log_new1->execute();
                $row_begin_new1 = $select_begin_log_new1->fetch(PDO::FETCH_ASSOC); 
                $insert_begin_log_new = $db->prepare("INSERT INTO begin_log (date_begin,stock_begin,$begin_branch) VALUES (NOW(),".$row_sum_item['stock_id'].",".$row_begin_new1['cn'].",".$row_begin_new1['ra'].",".$row_begin_new1['ar'].",".$row_begin_new1['sa'].",".$row_begin_new1['as_1'].",".$row_begin_new1['on_1'].",".$row_begin_new1['ud'].",".$row_begin_new1['nw'].",".$row_begin_new1['cw'].",".$row_begin_new1['r2'].",".$row_begin_new1['lb'].",".$row_begin_new1['bk'].",".$row_begin_new1['hq'].")");
                $insert_begin_log_new->execute();//โครนข้อมูลเก่าลงใหม่ ก่อน update
                $select_begin_log_new2 = $db->prepare("SELECT * FROM begin_log  WHERE stock_begin = ".$row_sum_item['stock_id']." ORDER BY begin_id ASC  LIMIT 1");
                $select_begin_log_new2->execute();
                $row_begin_new2 = $select_begin_log_new2->fetch(PDO::FETCH_ASSOC);
                $select_branch_stock_loop1 = $db->prepare("SELECT stock_id,bn_stock,SUM(item_quantity) as sum_item  FROM branch_stock  INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log WHERE stock_id = ".$row_stock_id['stock_id']." GROUP BY  bn_stock,stock_id ORDER BY bn_stock ASC ");//นำตัวเลขที่ได้มาคุ้นหาว่ามีกี่สาขา
                $select_branch_stock_loop1->execute(); 
                while ($row_bn_stock = $select_branch_stock_loop1->fetch(PDO::FETCH_ASSOC) ) {
                    if($row_bn_stock['bn_stock']==1){
                        $begin_branch_1 = "cn"; 
                    }elseif($row_bn_stock['bn_stock']==2){
                        $begin_branch_1 = "ra";
        
                    }elseif($row_bn_stock['bn_stock']==3){
        
                        $begin_branch_1 = "ar";
                    }elseif($row_bn_stock['bn_stock']==4){
                        $begin_branch_1 = "sa";
                        
                    }elseif($row_bn_stock['bn_stock']==5){
                        $begin_branch_1 = "as_1";
                        
                    }elseif($row_bn_stock['bn_stock']==6){
                        $begin_branch_1 = "on_1";
                        
                    }elseif($row_bn_stock['bn_stock']==7){
                        $begin_branch_1 = "ud";
                        
                    }elseif($row_bn_stock['bn_stock']==8){
                        $begin_branch_1 = "nw";
                        
                    }elseif($row_bn_stock['bn_stock']==9){
                        $begin_branch_1 = "cw";
                        
                    }elseif($row_bn_stock['bn_stock']==10){
                        $begin_branch_1 = "r2";
                        
                    }elseif($row_bn_stock['bn_stock']==11){
                        $begin_branch_1 = "lb";
                        
                    }elseif($row_bn_stock['bn_stock']==12){
                        $begin_branch_1 = "bk";
                        
                    }elseif($row_bn_stock['bn_stock']==13){
                        $begin_branch_1 = "hq";
                    }
                    $select_begin_log_new_3 = $db->prepare("SELECT begin_id FROM begin_log  WHERE stock_begin = ".$row_sum_item['stock_id']." ORDER BY begin_id ASC  LIMIT 1");
                    $select_begin_log_new_3->execute();
                    $row_begin_new3 = $select_begin_log_new_3->fetch(PDO::FETCH_ASSOC);
                    $update_begin_log_new = $db->prepare("UPDATE begin_log SET $begin_branch_1=".$row_bn_stock['sum_item']." WHERE begin_id = ".$row_begin_new3['begin_id']."");
                    $update_begin_log_new->execute();
                }
            }
        }//loop2 เช็คจำนวนที่อยู่ในรายการนั้นมีกี่สาขา
    }//loop แรก
    header("refresh:1;data-user/ui_run_scrip.php");
}//isset ใหญ่่
else{
    echo "รหัสคำสั่งไม่ถูกต้องไม่ถูกต้อง";
}
    ?>

