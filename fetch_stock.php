<?php

//fetch.php

include('database/db.php');

$column = array('code_item', 'item_name', 'unit_name', 'price_stock', 'type_name', 'catagories_name','vendor_name','cotton_name','nature_name');

$query = "SELECT stock_id,code_item,item_name,unit_name,item.price_stock,type_name,catagories_name,vendor_name,cotton_name,nature_name FROM stock  
INNER JOIN item ON stock.item_id = item.item_id  
INNER JOIN unit ON item.unit = unit.unit_id  
INNER JOIN vendor ON stock.vendor = vendor.vendor_id
INNER JOIN catagories ON stock.type_catagories = catagories.catagories_id   
INNER JOIN type_name ON stock.type_item = type_name.type_id
INNER JOIN cotton ON stock.cotton_id = cotton.cotton_id
INNER JOIN nature ON stock.nature_id = nature.nature_id";

if(isset($_POST['search']['value']))
{
 $query .= '
 WHERE code_item LIKE "%'.$_POST['search']['value'].'%" 
 OR item_name LIKE "%'.$_POST['search']['value'].'%" 
 OR unit_name LIKE "%'.$_POST['search']['value'].'%" 
 OR price_stock LIKE "%'.$_POST['search']['value'].'%" 
 OR type_name LIKE "%'.$_POST['search']['value'].'%" 
 OR catagories_name LIKE "%'.$_POST['search']['value'].'%" 
 OR vendor_name LIKE "%'.$_POST['search']['value'].'%" 
 OR cotton_name LIKE "%'.$_POST['search']['value'].'%"
 OR nature_name LIKE "%'.$_POST['search']['value'].'%"  
 ';
}

if(isset($_POST['order']))
{
 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= 'ORDER BY stock_id DESC ';
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
 $sub_array[] = $row['code_item'];
 $sub_array[] = $row['item_name'];
 $sub_array[] = $row['unit_name'];
 $sub_array[] = $row['price_stock'];
 $sub_array[] = $row['type_name'];
 $sub_array[] = $row['catagories_name'];
 $sub_array[] = $row['vendor_name'];
 $sub_array[] = $row['cotton_name'];
 $sub_array[] = $row['nature_name'];
 $data[] = $sub_array;
}

function count_all_data($db)
{
 $query = "SELECT stock_id,code_item,item_name,unit_name,item.price_stock,type_name,catagories_name,vendor_name,cotton_name,nature_name FROM stock  
 INNER JOIN item ON stock.item_id = item.item_id  
 INNER JOIN unit ON item.unit = unit.unit_id  
 INNER JOIN vendor ON stock.vendor = vendor.vendor_id
 INNER JOIN catagories ON stock.type_catagories = catagories.catagories_id   
 INNER JOIN type_name ON stock.type_item = type_name.type_id
 INNER JOIN cotton ON stock.cotton_id = cotton.cotton_id
 INNER JOIN nature ON stock.nature_id = nature.nature_id";
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

?>