<?php
include 'con_db.php';
if (isset($_POST['save'])) {
    $item_name = $_POST['category_item'];
    $unit = $_POST['sub_category_item'];
    $price = $_POST['price'];
    mysqli_query($conn, "INSERT INTO stock (item_name,unit,price) VALUES ('$item_name','$unit')"); 
       header('location: item_add.php');
       echo $price;
}
?>