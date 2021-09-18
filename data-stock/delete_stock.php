<?php 
    require_once('../database/db.php');
    if (isset($_REQUEST['delete_id'])) {
      $stock_id = $_REQUEST['delete_id'];
      $result_note = $_REQUEST['result'];
      $user_name = $_REQUEST['user'];
      $select_stmt = $db->prepare("SELECT stock_log_id FROM branch_stock_log WHERE stock_log_id  = :new_stock_id");
      $select_stmt->bindParam(':new_stock_id', $stock_id);
      $select_stmt->execute();
      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
      // Delete an original record from db
      $delete_branch_stock = $db->prepare('DELETE FROM branch_stock WHERE full_stock_id  = :new_stock_id');
      $delete_branch_stock->bindParam(':new_stock_id', $stock_id);
      $delete_branch_stock_log = $db->prepare('DELETE FROM branch_stock_log WHERE stock_log_id  = :new_stock_id');
      $delete_branch_stock_log->bindParam(':new_stock_id', $stock_id);
      if($delete_branch_stock_log->execute()){
          $delete_branch_stock->execute();
        $insertMsg = "ลบข้อมูลสำเร็จ...";
      }
        // header('Location:sub_list_stock_branch.php');
    }
?>