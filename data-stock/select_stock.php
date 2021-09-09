<?php 
$id = $_POST['uid'];
include('../database/db.php');
$select_stmt = $db->prepare("SELECT stock_id,price_stock,stock.marque_id,ifnull(marque_name,'ไม่มี') as marque ,division_name,vendor_name,stock_id,code_item ,item_name,unit_name,type_name,item.exd_date,nature_name FROM stock  
        INNER JOIN item ON stock.item_id = item.item_id 
        INNER JOIN unit ON item.unit_id = unit.unit_id  
        INNER JOIN nature ON stock.nature_id = nature.nature_id   
        INNER JOIN type_item ON stock.type_id = type_item.type_id
        INNER JOIN vendor ON stock.vendor_id = vendor.vendor_id
        INNER JOIN division ON stock.division_id = division.division_id
        LEFT JOIN marque ON stock.marque_id = marque.marque_id
        WHERE stock_id ='$id'");
        $select_stmt->execute();
        $row_stock = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row_stock);
@@$outp.='<table class="table table-hover">';
        
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>รหัสบาร์โค้ด</label> : '.$code_item.'</td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>ชื่อรายการ</label> : '.$item_name.'</td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>หน่วย</label> : '.$unit_name.'</td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>ราคา</label> : '.$price_stock.'</td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>ประเภท</label> : '.$type_name.'</td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>ลักษณะ</label> : '.$nature_name.'</td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>แผนก</label> : '.$division_name.'</td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>ผู้ขาย</label> : '.$vendor_name.'</td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>ยี่ห้อ</label> : '.$marque.'</td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td><img src="'.$img_stock.'/>" width="auto" height="auto"><td>
        </tr>';
@@$outp.="</table>";
echo $outp;
?>