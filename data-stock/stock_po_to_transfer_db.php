<?php 
include('../database/db.php');
date_default_timezone_set("Asia/Bangkok");//setค่า timezone และวันที่ ในรูปแบบ 2021-12-09 : 10:00:00 (วันที่-เวลา:นาที:วินาที)
$date = new DateTime();
$date_nows = $date->format('Y-m-d H:i:s');

if(empty($_POST['stock_po_id'])){
    $errorMsg=false;
}else{
$number = count($_POST['stock_po_id']);
$randomking = rand(000001,999999);
for($i=0; $i< $number; $i++){  //รับข้อมูลสั่งสินค้าสาขา เพื่อ โอนข้อมูล ไปยังโอนของโดยจัดซื้อ
$stock_id = $_POST["stock_po_id"][$i]; 
$bn_id = $_POST["stock_bn"][$i];
$quantity = $_POST["sum_po"][$i];
$price_stock = $_POST["price"][$i];
$bn_po = $_POST["bn_po"][$i];
$bn_1 = 1;
$user_name = "จัดซื้อส่วนกลาง";
$select_bn = $db->prepare("SELECT bn_acronym FROM branch WHERE bn_id = $bn_id");//ดึงตัวย่อสาขามาเพิ่มทำรหัสโอนของในขั้นตอนรอส่งสินค้า
$select_bn->execute();
$fetch_bn = $select_bn->fetch(PDO::FETCH_ASSOC);

$transfer ="OrderCN".$randomking.$fetch_bn['bn_acronym'];
try {
    if($i+1== $number){
    $insert_transfer = $db->prepare("INSERT INTO transfer (transfer_name) VALUES ('$transfer')");
    $insert_transfer_stock =$db->prepare("INSERT INTO transfer_stock (bn_id_1,bn_id_2,transfer_id,user1,transfer_date,transfer_status,user2,note2) VALUES ('$bn_1',' $bn_id',LAST_INSERT_ID(),'$user_name',NOW(),2,'เจ้าหน้าที่จัดซื้อ','จัดส่งของรอบเดือน')");
        if($insert_transfer->execute()){
            $insert_transfer_stock->execute();
            
        }
    }
    $insert_transfer_stock_log = $db->prepare("INSERT INTO transfer_stock_log (transfer_stock_id,stock_id,transfer_qty,transfer_price) VALUES ('$transfer','$stock_id','".$quantity."','$price_stock')");
    if( $insert_transfer_stock_log->execute()){
        $update_stock = $db->prepare("UPDATE stock_po SET ".$bn_po." = 0 WHERE stock_po_id = '$stock_id'");
        $update_stock->execute();
    }
}catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
}

}
echo $insertMsg = "โอนย้าย รหัสติดตามสถานะพัสดุ ".$transfer;

}
?>