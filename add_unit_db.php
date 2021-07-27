<?php 
    include 'con_db.php';

	if (isset($_POST['save'])) {
        
		$unit_name = $_POST['unit_name'];
		
		mysqli_query($conn, "INSERT INTO unit (unit_name) VALUES ('$unit_name')"); 
		header('location: add_unit.php');
	}
    ?>