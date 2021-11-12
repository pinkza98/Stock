<?php  
include("../database/db.php");
if($_POST['stock_id']){
    $number = count($_POST['stock_id']);
    for($i=0; $i< $number; $i++){  

        $stock_id=$_POST['stock_id'][$i];
        $sum_item=$_POST['sum'][$i];
        $bn_stock =$_POST['bn_stock'][$i];
        if($bn_stock==1){
            $user_bn = "cn";
        }elseif($bn_stock==2){
            $user_bn = "ra";
        }elseif($bn_stock==3){
            $user_bn = "ar";
        }elseif($bn_stock==4){
            $user_bn = "sa";
        }elseif($bn_stock==5){
            $user_bn = "as_1";
        }elseif($bn_stock==6){
            $user_bn = "on_1";
        }elseif($bn_stock==7){
            $user_bn = "ud";
        }elseif($bn_stock==8){
            $user_bn = "nw";
        }elseif($bn_stock==9){
            $user_bn = "cw";
        }elseif($bn_stock==10){
            $user_bn = "r2";
        }elseif($bn_stock==11){
            $user_bn = "lb";
        }elseif($bn_stock==12){
            $user_bn = "bk";
        }elseif($bn_stock==13){
            $user_bn = "hq";
        }

        $update_stock_po = $db->prepare("UPDATE stock_po SET $user_bn = $sum_item WHERE stock_po_id = $stock_id ");
        $update_stock_po->execute();

    }
    echo "update ขอสั่งของสำเร็จ";
    
    
    
    
    

}

    ?>