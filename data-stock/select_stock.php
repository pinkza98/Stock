<?php 
$id = $_POST['uid'];
include('../database/db.php');
$select_stmt = $db->prepare("SELECT stock_id,price_stock,stock.marque_id,ifnull(marque_name,'ไม่มี') as marque ,division_name,vendor_name,stock_id,code_item ,item_name,unit_name,type_name,item.exd_date,nature_name,img_stock FROM stock  
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
@@$outp.='';
        
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>รหัสบาร์โค้ด</label> :<td> '.$code_item.'</td></td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>ชื่อรายการ</label> :<td>  '.$item_name.'</td></td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>หน่วย</label> :<td>  '.$unit_name.'</td></td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>ราคา</label> :<td>  '.$price_stock.'</td></td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>ประเภท</label> :<td>  '.$type_name.'</td></td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>ลักษณะ</label> :<td>  '.$nature_name.'</td></td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>แผนก</label> :<td>  '.$division_name.'</td></td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>ผู้ขาย</label> :<td>  '.$vendor_name.'</td></td>
        </tr>';
@@$outp.='<tr class="table-light">
        <td class="control-form"><label>ยี่ห้อ</label> :<td>  '.$marque.'</td></td>
        </tr>';
@@$outp.='<tr class="table-light mt-2">
        <td><td><img src="img_stock/'.$img_stock.'" width="auto" height="120"></td></td>
        </tr>';
@@$outp.="";
echo $outp;
?>