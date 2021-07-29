<?php

include_once('con_db.php');

if(isset($_POST["type"]))
{
 if($_POST["type"] == "category_data")
 {
  $query = "
  SELECT * FROM unit 
  ORDER BY unit_name ASC
  ";
  $statement = $db->prepare($query);
  $statement->execute();
  $data = $statement->fetchAll();
  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["id"],
    'name'  => $row["unit_name"]
   );
  }
  echo json_encode($output);
 }
 else
 {
  $query = "
  SELECT * FROM item 
  WHERE unit = '".$_POST["category_id"]."' 
  ORDER BY item_name ASC
  ";
  $statement = $db->prepare($query);
  $statement->execute();
  $data = $statement->fetchAll();
  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["id"],
    'name'  => $row["item_name"]
   );
  }
  echo json_encode($output);
 }
}

?>
