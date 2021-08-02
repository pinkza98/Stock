<?php

include_once('../database/db.php');

if(isset($_POST["type"]))
{
 if($_POST["type"] == "category_data")
 {
  $query = "SELECT * FROM unit ORDER BY unit_name ASC";
  $statement = $db->prepare($query);
  $statement->execute();
  $data = $statement->fetchAll();
  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["unit_id"],
    'name'  => $row["unit_name"]
   );
  }
  echo json_encode($output);
 }
 else
 {
  $query = "SELECT * FROM type_item WHERE unit_id = '".$_POST["type_unit"]."' ORDER BY type_id ASC";
  $statement = $db->prepare($query);
  $statement->execute();
  $data = $statement->fetchAll();
  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["type_id"],
    'name'  => $row["type_name"]
   );
  }
  echo json_encode($output);
 }
}
?>