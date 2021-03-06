<?php
include('database/db.php');
//fetch.php
$page = $_REQUEST['page'];



//หน้า INDEX
if($page == 1){
    $column = array('code_item', 'item_name', 'unit_name', 'price_stock', 'type_name', 'division_name','vendor_name','marque_name','nature_name');

    $query = "SELECT price_stock,stock.marque_id,marque_name,division_name,vendor_name,stock_id,code_item ,item_name,unit_name,type_name,item.exd_date,nature_name FROM stock  
    RIGHT JOIN item ON stock.item_id = item.item_id 
    LEFT JOIN unit ON item.unit_id = unit.unit_id  
    LEFT JOIN nature ON stock.nature_id = nature.nature_id   
    LEFT JOIN type_item ON stock.type_id = type_item.type_id
    LEFT JOIN vendor ON stock.vendor_id = vendor.vendor_id
    LEFT JOIN division ON stock.division_id = division.division_id
    LEFT JOIN marque ON stock.marque_id = marque.marque_id
    ";
    if(isset($_POST['search']['value']))
    {
     $query .= '
     WHERE code_item LIKE "%'.$_POST['search']['value'].'%" 
     OR item_name LIKE "%'.$_POST['search']['value'].'%" 
     OR unit_name LIKE "%'.$_POST['search']['value'].'%"  
     OR price_stock LIKE "%'.$_POST['search']['value'].'%" 
     OR type_name LIKE "%'.$_POST['search']['value'].'%" 
     OR division_name LIKE "%'.$_POST['search']['value'].'%" 
     OR vendor_name LIKE "%'.$_POST['search']['value'].'%" 
     OR marque_name LIKE "%'.$_POST['search']['value'].'%"
     OR nature_name LIKE "%'.$_POST['search']['value'].'%"  
     ';
    }
    
    if(isset($_POST['order']))
    {
     $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
     $query .= 'ORDER BY code_item DESC';
    }
    
    $query1 = '';
    
    if($_POST['length'] != -1)
    {
     $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }
    
    $statement = $db->prepare($query);
    
    $statement->execute();
    
    $number_filter_row = $statement->rowCount();
    
    $statement = $db->prepare($query . $query1);
    
    $statement->execute();
    
    $result = $statement->fetchAll();
     
    $data = array();
    
    foreach($result as $row)
    {
     $sub_array = array();
    //  $sub_array[] = $row['stock_id'];
     $sub_array[] = $row['code_item'];
     $sub_array[] = $row['item_name'];
     $sub_array[] = $row['unit_name'];
     $sub_array[] = number_format($row['price_stock']);
     $sub_array[] = $row['type_name'];
     $sub_array[] = $row['nature_name'];
     $sub_array[] = $row['division_name'];
     $sub_array[] = $row['marque_name'];
     $sub_array[] = $row['vendor_name'];
     $data[] = $sub_array;
    }
    
    function count_all_data($db)
    {
     $query = "SELECT price_stock,stock.marque_id,marque_name,division_name,vendor_name,stock_id,code_item ,item_name,unit_name,type_name,item.exd_date,nature_name FROM stock  
     RIGHT JOIN item ON stock.item_id = item.item_id 
     LEFT JOIN unit ON item.unit_id = unit.unit_id  
     LEFT JOIN nature ON stock.nature_id = nature.nature_id   
     LEFT JOIN type_item ON stock.type_id = type_item.type_id
     LEFT JOIN vendor ON stock.vendor_id = vendor.vendor_id
     LEFT JOIN division ON stock.division_id = division.division_id
     LEFT JOIN marque ON stock.marque_id = marque.marque_id
     ORDER BY code_item DESC";
     $statement = $db->prepare($query);
     $statement->execute();
     return $statement->rowCount();
    }
    
    $output = array(
     'draw'    => intval($_POST['draw']),
     'recordsTotal'  => count_all_data($db),
     'recordsFiltered' => $number_filter_row,
     'data'    => $data
    );
    
    echo json_encode($output);
}
if($page == 2){
    $column = array('code_item','item_name','vendor','unit','price_stock','BN2','BN3','BN4','BN5','BN6','BN7','BN8','BN9','BN10','BN11','BN12','BN1','SUM_BN');
    
    $query = "SELECT
    it.code_item,unit_name,item_name,v.vendor_name,price_stock,
  
    SUM(IF(bn_stock = 1, item_quantity, NULL)) AS BN1,
    SUM(IF(bn_stock = 1, stock_min, NULL)) AS min_BN1,
     SUM(IF(bn_stock = 1, stock_max, NULL)) AS max_BN1,
     COUNT(IF(bn_stock = 1, stock_min, NULL)) AS count_BN1,
     
     SUM(IF(bn_stock = 2, item_quantity, NULL)) AS BN2,
    SUM(IF(bn_stock = 2, stock_min, NULL)) AS min_BN2,
     SUM(IF(bn_stock = 2, stock_max, NULL)) AS max_BN2,
     COUNT(IF(bn_stock = 2, stock_min, NULL)) AS count_BN2,
  
     SUM(IF(bn_stock = 3, item_quantity, NULL)) AS BN3,
    SUM(IF(bn_stock = 3, stock_min, NULL)) AS min_BN3,
     SUM(IF(bn_stock = 3, stock_max, NULL)) AS max_BN3,
     COUNT(IF(bn_stock = 3, stock_min, NULL)) AS count_BN3,
     
     SUM(IF(bn_stock = 4, item_quantity, NULL)) AS BN4,
    SUM(IF(bn_stock = 4, stock_min, NULL)) AS min_BN4,
     SUM(IF(bn_stock = 4, stock_max, NULL)) AS max_BN4,
     COUNT(IF(bn_stock = 4, stock_min, NULL)) AS count_BN4,
  
     SUM(IF(bn_stock = 5, item_quantity, NULL)) AS BN5,
    SUM(IF(bn_stock = 5, stock_min, NULL)) AS min_BN5,
     SUM(IF(bn_stock = 5, stock_max, NULL)) AS max_BN5,
     COUNT(IF(bn_stock = 5, stock_min, NULL)) AS count_BN5,
  
     SUM(IF(bn_stock = 6, item_quantity, NULL)) AS BN6,
    SUM(IF(bn_stock = 6, stock_min, NULL)) AS min_BN6,
     SUM(IF(bn_stock = 6, stock_max, NULL)) AS max_BN6,
     COUNT(IF(bn_stock = 6, stock_min, NULL)) AS count_BN6,
  
     SUM(IF(bn_stock = 7, item_quantity, NULL)) AS BN7,
    SUM(IF(bn_stock = 7, stock_min, NULL)) AS min_BN7,
     SUM(IF(bn_stock = 7, stock_max, NULL)) AS max_BN7,
     COUNT(IF(bn_stock = 7, stock_min, NULL)) AS count_BN7,
  
     SUM(IF(bn_stock = 8, item_quantity, NULL)) AS BN8,
    SUM(IF(bn_stock = 8, stock_min, NULL)) AS min_BN8,
     SUM(IF(bn_stock = 8, stock_max, NULL)) AS max_BN8,
     COUNT(IF(bn_stock = 8, stock_min, NULL)) AS count_BN8,
  
     SUM(IF(bn_stock = 9, item_quantity, NULL)) AS BN9,
    SUM(IF(bn_stock = 9, stock_min, NULL)) AS min_BN9,
     SUM(IF(bn_stock = 9, stock_max, NULL)) AS max_BN9,
     COUNT(IF(bn_stock = 9, stock_min, NULL)) AS count_BN9,
  
     SUM(IF(bn_stock = 10, item_quantity, NULL)) AS BN10,
    SUM(IF(bn_stock = 10, stock_min, NULL)) AS min_BN10,
     SUM(IF(bn_stock = 10, stock_max, NULL)) AS max_BN10,
     COUNT(IF(bn_stock = 10, stock_min, NULL)) AS count_BN10,
     
     SUM(IF(bn_stock = 11, item_quantity, NULL)) AS BN11,
    SUM(IF(bn_stock = 11, stock_min, NULL)) AS min_BN11,
     SUM(IF(bn_stock = 11, stock_max, NULL)) AS max_BN11,
     COUNT(IF(bn_stock = 11, stock_min, NULL)) AS count_BN11,
  
     SUM(IF(bn_stock = 12, item_quantity, NULL)) AS BN12,
    SUM(IF(bn_stock = 12, stock_min, NULL)) AS min_BN12,
     SUM(IF(bn_stock = 12, stock_max, NULL)) AS max_BN12,
     COUNT(IF(bn_stock = 12, stock_min, NULL)) AS count_BN12,
  
     SUM(IF(bn_stock = 13, item_quantity, NULL)) AS BN13,
    SUM(IF(bn_stock = 13, stock_min, NULL)) AS min_BN13,
     SUM(IF(bn_stock = 13, stock_max, NULL)) AS max_BN13,
     COUNT(IF(bn_stock = 13, stock_min, NULL)) AS count_BN13,
  
      SUM(CASE WHEN bn_stock=1 or bn_stock=2 or bn_stock=3 or bn_stock=4 or bn_stock=5 or bn_stock=6 or bn_stock=7 or bn_stock=8 or bn_stock=9 or bn_stock=10 or bn_stock=11 or bn_stock=12 or bn_stock=13 THEN item_quantity ELSE NULL END) AS SUM_BN
    FROM branch_stock bn
    INNER JOIN stock s  on bn.stock_id = s.stock_id
    INNER JOIN vendor v  on s.vendor_id = v.vendor_id
    INNER JOIN item it  on s.item_id = it.item_id
    INNER JOIN unit u  on it.unit_id = u.unit_id
    INNER JOIN  branch_stock_log bsl  on bn.full_stock_id = bsl.full_stock_id_log 
    WHERE bn.bn_stock between 1 and 13";
    if(isset($_POST['search']['value']))
    {
     $query .= ' 
    AND code_item LIKE "%'.$_POST['search']['value'].'%" 
     OR item_name LIKE "%'.$_POST['search']['value'].'%"   
     OR vendor_name LIKE "%'.$_POST['search']['value'].'%"   
     OR unit_name LIKE "%'.$_POST['search']['value'].'%"   
     ';
    }
    if(isset($_POST['GROUP BY']))
    {
     $query .= 'GROUP BY '.$column[$_POST['GROUP']['0']['column']].' '.$_POST['GROUP']['0']['dir'].' ';
    }
    else
    {
     $query .= 'GROUP BY
     it.item_id ';
    }
    
    $statement = $db->prepare($query);
    
    $statement->execute();
    
    $number_filter_row = $statement->rowCount();
    
    $statement = $db->prepare($query);
    
    $statement->execute();
    
    $result = $statement->fetchAll();
    
    $data = array();
    
    foreach($result as $row)
    {
    $sub_array = array();
    $sub_array[]= $row["code_item"]; 
    $sub_array[]= $row["item_name"]; 
    $sub_array[]= $row["unit_name"]; 
    $sub_array[]= $row["vendor_name"];
    $sub_array[]= $row["price_stock"];  
    
   if(!is_null($row['min_BN2'])){
     if($row['BN2'] >= $row['min_BN2']/$row['count_BN2'] && $row['BN2'] <= $row['max_BN2']/$row['count_BN2']){
       $sub_array[]= '<span class="label label-success">'.$row['BN2'].'</span>';
     }
      elseif($row['BN2'] >= $row['max_BN2']/$row['count_BN2']){
        $sub_array[]= '<span class="label label-primary">'.$row['BN2'].'</span>';

      }elseif($row['BN2'] < $row['min_BN2']/$row['count_BN2']){
        $sub_array[]= '<span class="label label-danger">'.$row['BN2'].'</span>';
      }else{
        $sub_array[]= $row['BN2'] ='-';
      }
   }else{
      if($row['BN2'] !=0){
        $sub_array[]= $row['BN2'];
      }else{
        $sub_array[]= '-';
      }
   }
   if(!is_null($row['min_BN3'])){
    if($row['BN3'] >= $row['min_BN3']/$row['count_BN3'] && $row['BN3'] <= $row['max_BN3']/$row['count_BN3']){
      $sub_array[]= '<span class="label label-success">'.$row['BN3'].'</span>';
    }
     elseif($row['BN3'] >= $row['max_BN3']/$row['count_BN3']){
       $sub_array[]= '<span class="label label-primary">'.$row['BN3'].'</span>';

     }elseif($row['BN3'] < $row['min_BN3']/$row['count_BN3']){
       $sub_array[]= '<span class="label label-danger">'.$row['BN3'].'</span>';
     }else{
       $sub_array[]= $row['BN3'] ='-';
     }
  }else{
     if($row['BN3'] !=0){
       $sub_array[]= $row['BN3'];
     }else{
       $sub_array[]= '-';
     }
  }
  if(!is_null($row['min_BN4'])){
    if($row['BN4'] >= $row['min_BN4']/$row['count_BN4'] && $row['BN4'] <= $row['max_BN4']/$row['count_BN4']){
      $sub_array[]= '<span class="label label-success">'.$row['BN4'].'</span>';
    }
     elseif($row['BN4'] >= $row['max_BN4']/$row['count_BN4']){
       $sub_array[]= '<span class="label label-primary">'.$row['BN4'].'</span>';

     }elseif($row['BN4'] < $row['min_BN4']/$row['count_BN4']){
       $sub_array[]= '<span class="label label-danger">'.$row['BN4'].'</span>';
     }else{
       $sub_array[]= $row['BN4'] ='-';
     }
  }else{
     if($row['BN4'] !=0){
       $sub_array[]= $row['BN4'];
     }else{
       $sub_array[]= '-';
     }
  } if(!is_null($row['min_BN5'])){
    if($row['BN5'] >= $row['min_BN5']/$row['count_BN5'] && $row['BN5'] <= $row['max_BN5']/$row['count_BN5']){
      $sub_array[]= '<span class="label label-success">'.$row['BN5'].'</span>';
    }
     elseif($row['BN5'] >= $row['max_BN5']/$row['count_BN5']){
       $sub_array[]= '<span class="label label-primary">'.$row['BN5'].'</span>';

     }elseif($row['BN5'] < $row['min_BN5']/$row['count_BN5']){
       $sub_array[]= '<span class="label label-danger">'.$row['BN5'].'</span>';
     }else{
       $sub_array[]= $row['BN5'] ='-';
     }
  }else{
     if($row['BN5'] !=0){
       $sub_array[]= $row['BN5'];
     }else{
       $sub_array[]= '-';
     }
  }
  if(!is_null($row['min_BN6'])){
    if($row['BN6'] >= $row['min_BN6']/$row['count_BN6'] && $row['BN6'] <= $row['max_BN6']/$row['count_BN6']){
      $sub_array[]= '<span class="label label-success">'.$row['BN6'].'</span>';
    }
     elseif($row['BN6'] >= $row['max_BN6']/$row['count_BN6']){
       $sub_array[]= '<span class="label label-primary">'.$row['BN6'].'</span>';

     }elseif($row['BN6'] < $row['min_BN6']/$row['count_BN6']){
       $sub_array[]= '<span class="label label-danger">'.$row['BN6'].'</span>';
     }else{
       $sub_array[]= $row['BN6'] ='-';
     }
  }else{
     if($row['BN6'] !=0){
       $sub_array[]= $row['BN6'];
     }else{
       $sub_array[]= '-';
     }
  } 
  if(!is_null($row['min_BN7'])){
    if($row['BN7'] >= $row['min_BN7']/$row['count_BN7'] && $row['BN7'] <= $row['max_BN7']/$row['count_BN7']){
      $sub_array[]= '<span class="label label-success">'.$row['BN7'].'</span>';
    }
     elseif($row['BN7'] >= $row['max_BN7']/$row['count_BN7']){
       $sub_array[]= '<span class="label label-primary">'.$row['BN7'].'</span>';

     }elseif($row['BN7'] < $row['min_BN7']/$row['count_BN7']){
       $sub_array[]= '<span class="label label-danger">'.$row['BN7'].'</span>';
     }else{
       $sub_array[]= $row['BN7'] ='-';
     }
  }else{
     if($row['BN7'] !=0){
       $sub_array[]= $row['BN7'];
     }else{
       $sub_array[]= '-';
     }
  }
  if(!is_null($row['min_BN8'])){
    if($row['BN8'] >= $row['min_BN8']/$row['count_BN8'] && $row['BN8'] <= $row['max_BN8']/$row['count_BN8']){
      $sub_array[]= '<span class="label label-success">'.$row['BN8'].'</span>';
    }
     elseif($row['BN8'] >= $row['max_BN8']/$row['count_BN8']){
       $sub_array[]= '<span class="label label-primary">'.$row['BN8'].'</span>';

     }elseif($row['BN8'] < $row['min_BN8']/$row['count_BN8']){
       $sub_array[]= '<span class="label label-danger">'.$row['BN8'].'</span>';
     }else{
       $sub_array[]= $row['BN8'] ='-';
     }
  }else{
     if($row['BN8'] !=0){
       $sub_array[]= $row['BN8'];
     }else{
       $sub_array[]= '-';
     }
  }
  if(!is_null($row['min_BN9'])){
    if($row['BN9'] >= $row['min_BN9']/$row['count_BN9'] && $row['BN9'] <= $row['max_BN9']/$row['count_BN9']){
      $sub_array[]= '<span class="label label-success">'.$row['BN9'].'</span>';
    }
     elseif($row['BN9'] >= $row['max_BN9']/$row['count_BN9']){
       $sub_array[]= '<span class="label label-primary">'.$row['BN9'].'</span>';

     }elseif($row['BN9'] < $row['min_BN9']/$row['count_BN9']){
       $sub_array[]= '<span class="label label-danger">'.$row['BN9'].'</span>';
     }else{
       $sub_array[]= $row['BN9'] ='-';
     }
  }else{
     if($row['BN9'] !=0){
       $sub_array[]= $row['BN9'];
     }else{
       $sub_array[]= '-';
     }
  }
  if(!is_null($row['min_BN10'])){
    if($row['BN10'] >= $row['min_BN10']/$row['count_BN10'] && $row['BN10'] <= $row['max_BN10']/$row['count_BN10']){
      $sub_array[]= '<span class="label label-success">'.$row['BN10'].'</span>';
    }
     elseif($row['BN10'] >= $row['max_BN10']/$row['count_BN10']){
       $sub_array[]= '<span class="label label-primary">'.$row['BN10'].'</span>';

     }elseif($row['BN10'] < $row['min_BN10']/$row['count_BN10']){
       $sub_array[]= '<span class="label label-danger">'.$row['BN10'].'</span>';
     }else{
       $sub_array[]= $row['BN10'] ='-';
     }
  }else{
     if($row['BN10'] !=0){
       $sub_array[]= $row['BN10'];
     }else{
       $sub_array[]= '-';
     }
  }
  if(!is_null($row['min_BN11'])){
    if($row['BN11'] >= $row['min_BN11']/$row['count_BN11'] && $row['BN11'] <= $row['max_BN11']/$row['count_BN11']){
      $sub_array[]= '<span class="label label-success">'.$row['BN11'].'</span>';
    }
     elseif($row['BN11'] >= $row['max_BN11']/$row['count_BN11']){
       $sub_array[]= '<span class="label label-primary">'.$row['BN11'].'</span>';

     }elseif($row['BN11'] < $row['min_BN11']/$row['count_BN11']){
       $sub_array[]= '<span class="label label-danger">'.$row['BN11'].'</span>';
     }else{
       $sub_array[]= $row['BN11'] ='-';
     }
  }else{
     if($row['BN11'] !=0){
       $sub_array[]= $row['BN11'];
     }else{
       $sub_array[]= '-';
     }
  }
  if(!is_null($row['min_BN12'])){
    if($row['BN12'] >= $row['min_BN12']/$row['count_BN12'] && $row['BN12'] <= $row['max_BN12']/$row['count_BN12']){
      $sub_array[]= '<span class="label label-success">'.$row['BN12'].'</span>';
    }
     elseif($row['BN12'] >= $row['max_BN12']/$row['count_BN12']){
       $sub_array[]= '<span class="label label-primary">'.$row['BN12'].'</span>';

     }elseif($row['BN12'] < $row['min_BN12']/$row['count_BN12']){
       $sub_array[]= '<span class="label label-danger">'.$row['BN12'].'</span>';
     }else{
       $sub_array[]= $row['BN12'] ='-';
     }
  }else{
     if($row['BN12'] !=0){
       $sub_array[]= $row['BN12'];
     }else{
       $sub_array[]= '-';
     }
  }
  if(!is_null($row['min_BN13'])){
    if($row['BN13'] >= $row['min_BN13']/$row['count_BN13'] && $row['BN13'] <= $row['max_BN13']/$row['count_BN13']){
      $sub_array[]= '<span class="label label-success">'.$row['BN13'].'</span>';
    }
     elseif($row['BN13'] >= $row['max_BN13']/$row['count_BN13']){
       $sub_array[]= '<span class="label label-primary">'.$row['BN13'].'</span>';

     }elseif($row['BN13'] < $row['min_BN13']/$row['count_BN13']){
       $sub_array[]= '<span class="label label-danger">'.$row['BN13'].'</span>';
     }else{
       $sub_array[]= $row['BN13'] ='-';
     }
  }else{
     if($row['BN13'] !=0){
       $sub_array[]= $row['BN13'];
     }else{
       $sub_array[]= '-';
     }
  }
  if(!is_null($row['min_BN1'])){
    if($row['BN1'] >= $row['min_BN1']/$row['count_BN1'] && $row['BN1'] <= $row['max_BN1']/$row['count_BN1']){
      $sub_array[]= '<span class="label label-success">'.$row['BN1'].'</span>';
    }
     elseif($row['BN1'] >= $row['max_BN1']/$row['count_BN1']){
       $sub_array[]= '<span class="label label-primary">'.$row['BN1'].'</span>';

     }elseif($row['BN1'] < $row['min_BN1']/$row['count_BN1']){
       $sub_array[]= '<span class="label label-danger">'.$row['BN1'].'</span>';
     }else{
       $sub_array[]= $row['BN1'] ='-';
     }
  }else{
     if($row['BN1'] !=0){
       $sub_array[]= $row['BN1'];
     }else{
       $sub_array[]= '-';
     }
  }
    if($row["SUM_BN"]<=12){
    $sub_array[]= '<span class="label label-danger">'.$row['SUM_BN'].'</span>';
    }else{
    $sub_array[]= '<span class="label label-success">'.$row['SUM_BN'].'</span>';
    }
     $data[] = $sub_array;
    }
    
    function count_all_data($db)
    {
     $query = "SELECT
     it.code_item,unit_name,item_name,v.vendor_name,price_stock,
   
     SUM(IF(bn_stock = 1, item_quantity, NULL)) AS BN1,
     SUM(IF(bn_stock = 1, stock_min, NULL)) AS min_BN1,
      SUM(IF(bn_stock = 1, stock_max, NULL)) AS max_BN1,
      COUNT(IF(bn_stock = 1, stock_min, NULL)) AS count_BN1,
      
      SUM(IF(bn_stock = 2, item_quantity, NULL)) AS BN2,
     SUM(IF(bn_stock = 2, stock_min, NULL)) AS min_BN2,
      SUM(IF(bn_stock = 2, stock_max, NULL)) AS max_BN2,
      COUNT(IF(bn_stock = 2, stock_min, NULL)) AS count_BN2,
   
      SUM(IF(bn_stock = 3, item_quantity, NULL)) AS BN3,
     SUM(IF(bn_stock = 3, stock_min, NULL)) AS min_BN3,
      SUM(IF(bn_stock = 3, stock_max, NULL)) AS max_BN3,
      COUNT(IF(bn_stock = 3, stock_min, NULL)) AS count_BN3,
      
      SUM(IF(bn_stock = 4, item_quantity, NULL)) AS BN4,
     SUM(IF(bn_stock = 4, stock_min, NULL)) AS min_BN4,
      SUM(IF(bn_stock = 4, stock_max, NULL)) AS max_BN4,
      COUNT(IF(bn_stock = 4, stock_min, NULL)) AS count_BN4,
   
      SUM(IF(bn_stock = 5, item_quantity, NULL)) AS BN5,
     SUM(IF(bn_stock = 5, stock_min, NULL)) AS min_BN5,
      SUM(IF(bn_stock = 5, stock_max, NULL)) AS max_BN5,
      COUNT(IF(bn_stock = 5, stock_min, NULL)) AS count_BN5,
   
      SUM(IF(bn_stock = 6, item_quantity, NULL)) AS BN6,
     SUM(IF(bn_stock = 6, stock_min, NULL)) AS min_BN6,
      SUM(IF(bn_stock = 6, stock_max, NULL)) AS max_BN6,
      COUNT(IF(bn_stock = 6, stock_min, NULL)) AS count_BN6,
   
      SUM(IF(bn_stock = 7, item_quantity, NULL)) AS BN7,
     SUM(IF(bn_stock = 7, stock_min, NULL)) AS min_BN7,
      SUM(IF(bn_stock = 7, stock_max, NULL)) AS max_BN7,
      COUNT(IF(bn_stock = 7, stock_min, NULL)) AS count_BN7,
   
      SUM(IF(bn_stock = 8, item_quantity, NULL)) AS BN8,
     SUM(IF(bn_stock = 8, stock_min, NULL)) AS min_BN8,
      SUM(IF(bn_stock = 8, stock_max, NULL)) AS max_BN8,
      COUNT(IF(bn_stock = 8, stock_min, NULL)) AS count_BN8,
   
      SUM(IF(bn_stock = 9, item_quantity, NULL)) AS BN9,
     SUM(IF(bn_stock = 9, stock_min, NULL)) AS min_BN9,
      SUM(IF(bn_stock = 9, stock_max, NULL)) AS max_BN9,
      COUNT(IF(bn_stock = 9, stock_min, NULL)) AS count_BN9,
   
      SUM(IF(bn_stock = 10, item_quantity, NULL)) AS BN10,
     SUM(IF(bn_stock = 10, stock_min, NULL)) AS min_BN10,
      SUM(IF(bn_stock = 10, stock_max, NULL)) AS max_BN10,
      COUNT(IF(bn_stock = 10, stock_min, NULL)) AS count_BN10,
      
      SUM(IF(bn_stock = 11, item_quantity, NULL)) AS BN11,
     SUM(IF(bn_stock = 11, stock_min, NULL)) AS min_BN11,
      SUM(IF(bn_stock = 11, stock_max, NULL)) AS max_BN11,
      COUNT(IF(bn_stock = 11, stock_min, NULL)) AS count_BN11,
   
      SUM(IF(bn_stock = 12, item_quantity, NULL)) AS BN12,
     SUM(IF(bn_stock = 12, stock_min, NULL)) AS min_BN12,
      SUM(IF(bn_stock = 12, stock_max, NULL)) AS max_BN12,
      COUNT(IF(bn_stock = 12, stock_min, NULL)) AS count_BN12,
   
      SUM(IF(bn_stock = 13, item_quantity, NULL)) AS BN13,
     SUM(IF(bn_stock = 13, stock_min, NULL)) AS min_BN13,
      SUM(IF(bn_stock = 13, stock_max, NULL)) AS max_BN13,
      COUNT(IF(bn_stock = 13, stock_min, NULL)) AS count_BN13,
   
       SUM(CASE WHEN bn_stock=1 or bn_stock=2 or bn_stock=3 or bn_stock=4 or bn_stock=5 or bn_stock=6 or bn_stock=7 or bn_stock=8 or bn_stock=9 or bn_stock=10 or bn_stock=11 or bn_stock=12 or bn_stock=13 THEN item_quantity ELSE NULL END) AS SUM_BN
     FROM branch_stock bn
     INNER JOIN stock s  on bn.stock_id = s.stock_id
     INNER JOIN vendor v  on s.vendor_id = v.vendor_id
     INNER JOIN item it  on s.item_id = it.item_id
     INNER JOIN unit u  on it.unit_id = u.unit_id
     INNER JOIN  branch_stock_log bsl  on bn.full_stock_id = bsl.full_stock_id_log 
     WHERE bn.bn_stock between 1 and 13
     ";
     $statement = $db->prepare($query);
     $statement->execute();
     return $statement->rowCount();
    }
    
    $output = array(
     'draw'    => intval($_POST['draw']),
     'recordsTotal'  => count_all_data($db),
     'recordsFiltered' => $number_filter_row,
     'data'    => $data
    );
    
    echo json_encode($output);
  }
  //หน้ารายการคลังทุกสาขา===================================================>
  if($page == 3){
    $column = array('full_stock_id','code_item','item_name', 'unit_name','item_quantity','bn_name', 'type_name','nature_name','division_name');

    $query = "SELECT division_name,full_stock_id,unit_name,code_item,item_name,SUM(branch_stock_log.item_quantity) as sum,type_name,branch.bn_name,nature_name FROM branch_stock  
    INNER JOIN stock ON branch_stock.stock_id = stock.stock_id
    INNER JOIN item ON stock.item_id = item.item_id
    INNER JOIN division ON stock.division_id = division.division_id
    INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
    INNER JOIN unit ON  item.unit_id = unit.unit_id
    INNER JOIN type_item ON stock.type_id = type_item.type_id
    INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
    INNER JOIN nature ON stock.nature_id = nature.nature_id
    WHERE branch_stock_log.item_quantity !=0
    GROUP BY code_item , bn_name 
    ";
    if(isset($_POST['search']['value']))
    {
      
     $query .= '
     
     AND code_item LIKE "%'.$_POST['search']['value'].'%" 
     OR item_name LIKE "%'.$_POST['search']['value'].'%" 
     OR unit_name LIKE "%'.$_POST['search']['value'].'%" 
     OR type_name LIKE "%'.$_POST['search']['value'].'%" 
     OR nature_name LIKE "%'.$_POST['search']['value'].'%" 
     OR division_name LIKE "%'.$_POST['search']['value'].'%"  
     OR nature_name LIKE "%'.$_POST['search']['value'].'%"   
     ';
    }
    
    if(isset($_POST['order']))
    {
     $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
     $query .= 'ORDER BY code_item ASC ';
    }
    
    $query1 = '';
    
    if($_POST['length'] != -1)
    {
     $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }
    
    if($_POST['length'] != -1)
    {
     $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }
    
    $statement = $db->prepare($query);
    
    $statement->execute();
    
    $number_filter_row = $statement->rowCount();
    
    $statement = $db->prepare($query. $query1);
    
    $statement->execute();
    
    $result = $statement->fetchAll();
    
    $data = array();
    
    foreach($result as $row)
    {
     $sub_array = array();
     $sub_array[] = $row['code_item'];
     $sub_array[] = $row['item_name'];
     $sub_array[] = $row['sum'];
     $sub_array[] = $row['unit_name'];
     $sub_array[] = $row['type_name'];
     $sub_array[] = $row['nature_name'];
     $sub_array[] = $row['division_name'];
     $sub_array[] = $row['bn_name'];
    
     $data[] = $sub_array;
    }
    
    function count_all_data($db)
    {
     $query = "SELECT division_name,full_stock_id,unit_name,code_item,item_name,SUM(branch_stock_log.item_quantity) as sum,type_name,branch.bn_name,nature_name FROM branch_stock  
     INNER JOIN stock ON branch_stock.stock_id = stock.stock_id
     INNER JOIN item ON stock.item_id = item.item_id
     INNER JOIN division ON stock.division_id = division.division_id
     INNER JOIN branch ON branch_stock.bn_stock = branch.bn_id
     INNER JOIN unit ON  item.unit_id = unit.unit_id
     INNER JOIN type_item ON stock.type_id = type_item.type_id
     INNER JOIN branch_stock_log ON branch_stock.full_stock_id = branch_stock_log.full_stock_id_log
     INNER JOIN nature ON stock.nature_id = nature.nature_id
     WHERE branch_stock_log.item_quantity !=0";
     $statement = $db->prepare($query);
     $statement->execute();
     return $statement->rowCount();
    }
    
    $output = array(
     'draw'    => intval($_POST['draw']),
     'recordsTotal'  => count_all_data($db),
     'recordsFiltered' => $number_filter_row,
     'data'    => $data
    );
    echo json_encode($output);
  }
  if($page == 4){
    $column = array('code_item','item_name','vendor_name','unit_name','price_stock');
    
    $query = "SELECT
    it.code_item,unit_name,item_name,v.vendor_name,price_stock,
    SUM(IF(bn_id = 1, quantity, 0)) AS BN1,
    SUM(IF(bn_id = 2, quantity, 0)) AS BN2,
    SUM(IF(bn_id = 3, quantity, 0)) AS BN3,
      SUM(IF(bn_id = 4, quantity, 0)) AS BN4,
      SUM(IF(bn_id = 5, quantity, 0)) AS BN5,
      SUM(IF(bn_id = 6, quantity, 0)) AS BN6,
      SUM(IF(bn_id = 7, quantity, 0)) AS BN7,
      SUM(IF(bn_id = 8, quantity, 0)) AS BN8,
      SUM(IF(bn_id = 9, quantity, 0)) AS BN9,
      SUM(IF(bn_id = 10, quantity, 0)) AS BN10,
      SUM(IF(bn_id = 11, quantity, 0)) AS BN11,
      SUM(IF(bn_id = 12, quantity, 0)) AS BN12,
      SUM(IF(bn_id = 13, quantity, 0)) AS BN13,
      SUM(CASE WHEN bn_id=1 or bn_id=2 or bn_id=3 or bn_id=4 or bn_id=5 or bn_id=6 or bn_id=7 or bn_id=8 or bn_id=9 or bn_id=10 or bn_id=11 or bn_id=12 or bn_id=13 THEN quantity ELSE NULL END) AS SUM_BN
    FROM cut_stock_log cut
    LEFT JOIN stock s  on cut.stock_id = s.stock_id
    INNER JOIN vendor v  on s.vendor_id = v.vendor_id
    INNER JOIN item it  on s.item_id = it.item_id
    INNER JOIN unit u  on it.unit_id = u.unit_id
    WHERE cut.stock_id = 1
    ";
    if(isset($_POST['search']['value']))
    {
     $query .= '
    AND code_item LIKE "%'.$_POST['search']['value'].'%" 
     OR item_name LIKE "%'.$_POST['search']['value'].'%"   
     OR vendor_name LIKE "%'.$_POST['search']['value'].'%"   
     OR unit_name LIKE "%'.$_POST['search']['value'].'%"   
     ';
    }
    if(isset($_POST['GROUP BY']))
    {
     $query .= 'GROUP BY '.$column[$_POST['GROUP']['0']['column']].' '.$_POST['GROUP']['0']['dir'].' ';
    }
    else
    {
     $query .= 'GROUP BY
     it.item_id ';
    }
    
    $statement = $db->prepare($query);
    
    $statement->execute();
    
    $number_filter_row = $statement->rowCount();
    
    $statement = $db->prepare($query);
    
    $statement->execute();
    
    $result = $statement->fetchAll();
    
    $data = array();
    
    foreach($result as $row)
    {
    $sub_array = array();
    $sub_array[]= $row["code_item"]; 
    $sub_array[]= $row["item_name"]; 
    $sub_array[]= $row["unit_name"]; 
    $sub_array[]= $row["vendor_name"];
    $sub_array[]= $row["price_stock"];  
    if($row["BN2"]==0){
      $row["BN2"]='-';
      $sub_array[]= $row["BN2"];
    }else{
      $sub_array[]= $row["BN2"];
    }
    if($row["BN3"]==0){
      $row["BN3"]='-';
      $sub_array[]= $row["BN3"];
    }else{
      $sub_array[]= $row["BN3"];
    }
    if($row["BN4"]==0){
      $row["BN4"]='-';
      $sub_array[]= $row["BN4"];
    }else{
      $sub_array[]= $row["BN4"];
    }
    if($row["BN5"]==0){
      $row["BN5"]='-';
      $sub_array[]= $row["BN5"];
    }else{
      $sub_array[]= $row["BN5"];
    }
    if($row["BN6"]==0){
      $row["BN6"]='-';
      $sub_array[]= $row["BN6"];
    }else{
      $sub_array[]= $row["BN6"];
    }
    if($row["BN7"]==0){
      $row["BN7"]='-';
      $sub_array[]= $row["BN7"];
    }else{
      $sub_array[]= $row["BN7"];
    }
    if($row["BN8"]==0){
      $row["BN8"]='-';
      $sub_array[]= $row["BN8"];
    }else{
      $sub_array[]= $row["BN8"];
    }
    if($row["BN9"]==0){
      $row["BN9"]='-';
      $sub_array[]= $row["BN9"];
    }else{
      $sub_array[]= $row["BN9"];
    }
    if($row["BN10"]==0){
      $row["BN10"]='-';
      $sub_array[]= $row["BN10"];
    }else{
      $sub_array[]= $row["BN10"];
    }
    if($row["BN11"]==0){
      $row["BN11"]='-';
      $sub_array[]= $row["BN11"];
    }else{
      $sub_array[]= $row["BN11"];
    }
    if($row["BN12"]==0){
      $row["BN12"]='-';
      $sub_array[]= $row["BN12"];
    }else{
      $sub_array[]= $row["BN12"];
    }
    if($row["BN13"]==0){
      $row["BN13"]='-';
      $sub_array[]= $row["BN13"];
    }else{
      $sub_array[]= $row["BN13"];
    } 
    if($row["BN1"]==0){
      $row["BN1"]='-';
      $sub_array[]= $row["BN1"];
    }else{
      $sub_array[]= $row["BN1"];
    } 
    if($row["SUM_BN"]<=12){
    $sub_array[]= '<div style="background-color: #EA3C04;color:#fff;">'.$row["SUM_BN"].'</div>';
    }else{
    $sub_array[]= '<div style="background-color: #93C47C;color:#fff;">'.$row["SUM_BN"].'</div>';
    }
     $data[] = $sub_array;
    }
    
    function count_all_data($db)
    {
     $query = "SELECT
     it.code_item,unit_name,item_name,v.vendor_name,price_stock,
     SUM(IF(bn_id = 1, quantity, 0)) AS BN1,
     SUM(IF(bn_id = 2, quantity, 0)) AS BN2,
     SUM(IF(bn_id = 3, quantity, 0)) AS BN3,
       SUM(IF(bn_id = 4, quantity, 0)) AS BN4,
       SUM(IF(bn_id = 5, quantity, 0)) AS BN5,
       SUM(IF(bn_id = 6, quantity, 0)) AS BN6,
       SUM(IF(bn_id = 7, quantity, 0)) AS BN7,
       SUM(IF(bn_id = 8, quantity, 0)) AS BN8,
       SUM(IF(bn_id = 9, quantity, 0)) AS BN9,
       SUM(IF(bn_id = 10, quantity, 0)) AS BN10,
       SUM(IF(bn_id = 11, quantity, 0)) AS BN11,
       SUM(IF(bn_id = 12, quantity, 0)) AS BN12,
       SUM(IF(bn_id = 13, quantity, 0)) AS BN13,
       SUM(CASE WHEN bn_id=1 or bn_id=2 or bn_id=3 or bn_id=4 or bn_id=5 or bn_id=6 or bn_id=7 or bn_id=8 or bn_id=9 or bn_id=10 or bn_id=11 or bn_id=12 THEN quantity ELSE NULL END) AS SUM_BN
     FROM cut_stock_log cut
     INNER JOIN stock s  on cut.stock_id = s.stock_id
     INNER JOIN vendor v  on s.vendor_id = v.vendor_id
     INNER JOIN item it  on s.item_id = it.item_id
     INNER JOIN unit u  on it.unit_id = u.unit_id
     
     ";
     $statement = $db->prepare($query);
     $statement->execute();
     return $statement->rowCount();
    }
    
    $output = array(
     'draw'    => intval($_POST['draw']),
     'recordsTotal'  => count_all_data($db),
     'recordsFiltered' => $number_filter_row,
     'data'    => $data
    );
    
    echo json_encode($output);
  }
 
  //function select date to date
?>