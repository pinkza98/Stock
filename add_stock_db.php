<?php 
    include 'con_db.php';

	if (isset($_POST['save'])) {
        
		$order_f = $_POST['order_f'];
        $code_stock = $_POST['code_stock'];
        $list_name = $_POST['list_name'];
        $unit = $_POST['unit_id'];

     
       
		mysqli_query($conn, "INSERT INTO stock (order_f,code_stock,list_name,unit) VALUES ('$order_f','$code_stock','$list_name','$unit')"); 
		header('location: add_stock.php');
	}
    ?>