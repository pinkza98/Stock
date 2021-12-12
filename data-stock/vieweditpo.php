
<!-- Modal -->
<?php 
include('../database/db.php');


?>
<div class="modal fade" id="dataModal_po" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Stock PO</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body" id="detail_po">
          ....
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
<?php 
if (isset($_REQUEST['submit'])) {
    if($row_session['user_bn']==1){ //แปลงเลขสาขา เป็นตัวอักษร 
        $user_bn = "cn";
      }elseif($row_session['user_bn']==2){
        $user_bn = "ra";
      }elseif($row_session['user_bn']==3){
        $user_bn = "ar";
      }elseif($row_session['user_bn']==4){
        $user_bn = "sa";
      }elseif($row_session['user_bn']==5){
        $user_bn = "as_1";
      }elseif($row_session['user_bn']==6){
        $user_bn = "on_1";
      }elseif($row_session['user_bn']==7){
        $user_bn = "ud";
      }elseif($row_session['user_bn']==8){
        $user_bn = "nw";
      }elseif($row_session['user_bn']==9){
        $user_bn = "cw";
      }elseif($row_session['user_bn']==10){
        $user_bn = "r2";
      }elseif($row_session['user_bn']==11){
        $user_bn = "lb";
      }elseif($row_session['user_bn']==12){
        $user_bn = "bk";
      }elseif($row_session['user_bn']==13){
        $user_bn = "hq";
      }
    $stock_id=$_REQUEST['stock_po_id'];
    $bn_id=$_REQUEST['bn_id'];
    $sum=$_REQUEST['sum'];
    $update_stock_po = $db->prepare("UPDATE stock_po SET $user_bn = $sum WHERE stock_po_id = $stock_id ");
    if($update_stock_po->execute()){
        // @@header("Refresh:2; url=stock_bn_po.php");
    }
  }
?>