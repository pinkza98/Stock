<?php 
include('../database/db.php');
$id = $_POST['uid'];
$bn_id=$_POST['bn_id'];
if($_POST['bn_id']==1){
  $bn_id = "cn";
}elseif($_POST['bn_id']==2){
  $bn_id = "ra";
}elseif($_POST['bn_id']==3){
  $bn_id = "ar";
}elseif($_POST['bn_id']==4){
  $bn_id = "sa";
}elseif($_POST['bn_id']==5){
  $bn_id = "as_1";
}elseif($_POST['bn_id']==6){
  $bn_id = "on_1";
}elseif($_POST['bn_id']==7){
  $bn_id = "ud";
}elseif($_POST['bn_id']==8){
  $bn_id = "nw";
}elseif($_POST['bn_id']==9){
  $bn_id = "cw";
}elseif($_POST['bn_id']==10){
  $bn_id = "r2";
}elseif($_POST['bn_id']==11){
  $bn_id = "lb";
}elseif($_POST['bn_id']==12){
  $bn_id = "bk";
}elseif($_POST['bn_id']==13){
  $bn_id = "hq";
}
$select_stock_po = $db->prepare("SELECT stock_po_id,$bn_id as sum_bn,$bn_id as bn_id FROM stock_po WHERE stock_po_id ='$id'");
        $select_stock_po->execute();
        $row_stock_po = $select_stock_po->fetch(PDO::FETCH_ASSOC);
@@$outp.='';
@@$outp.='<form id="update_po" method="post">';
@@$outp.='<tr class="table-light">
        <td> <input text="text" class="form-control" name="stock_po_id" value="'.$row_stock_po['stock_po_id'].'" hidden/></td>
        <td><input text="text" class="form-control" name="bn_id" value="'.$row_stock_po['bn_id'].'"  hidden/><td>
        <td class="control-form m-auto"><label>จำนวนที่ต้องการเบิก </label>  <td><input text="number" class="form-control text-center" name="sum" value="'.$row_stock_po['sum_bn'].'"/></td></td>
        <br>
        <input type="submit" name="submit"  class="btn btn-primary"/>
        </tr>';
@@$outp.='</form>';
@@$outp.="";
echo $outp;

?>