<?php 
include 'con_db.php';
if (isset($_GET['del'])) {
	$id = $_GET['del'];
	mysqli_query($conn, "DELETE FROM unit WHERE id=$id"); 
	header('location: add_unit.php');
}
?>