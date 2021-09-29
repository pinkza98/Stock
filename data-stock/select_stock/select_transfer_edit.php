<?php 
$id = $_POST['uid'];
include('../../database/db.php');
$select_transfer_stock = $db->prepare("SELECT code_item,item_name,SUM(transfer_qty)as sum_qty,transfer_price,SUM(transfer_qty_set)as sum_qty_set  FROM transfer_stock_log INNER JOIN stock ON transfer_stock_log.stock_id = stock.stock_id
INNER JOIN item ON stock.item_id = item.item_id
 WHERE transfer_stock_id='$id'
 GROUP BY code_item
 ");
        $select_transfer_stock->execute();
       
@@$outp.='';
@@$outp.='<table class="table table">';
$i=1;
@@$outp.='<thead class="table" id="transfer">
                <tr class="table-active">
                    <th>NO.</th>
                    <th>รหัส</th>
                    <th>รายการ</th>
                    <th>จำนวนส่ง</th>
                    <th>จำนวนที่รับ</th>
                    <th>ราคา</th>
                </tr>
            </thead>';
while ($row_transfer = $select_transfer_stock->fetch(PDO::FETCH_ASSOC)) {
@@$outp.='<td >'.$i.'</td>';
@@$outp.='<td >'.$row_transfer['code_item'].'</td>';
@@$outp.='<td >'.$row_transfer['item_name'].'</td>';
@@$outp.='<td >'.$row_transfer['sum_qty'].'</td>';
if(IS_NULL($row_transfer['sum_qty_set'])){
    @@$outp.='<td >0</td>';
}else{
    @@$outp.='<td >'.$row_transfer['sum_qty_set'].'</td>';
}

@@$outp.='<td >'.$row_transfer['transfer_price'].'</td>';
@@$outp.='<tr class="table-light mt-2">';
        $i++;
        }
@@$outp.='</table>';
echo $outp;
?>