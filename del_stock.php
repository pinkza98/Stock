<?php 
include 'con_db.php';
if (isset($_GET['del'])) {
	$id = $_GET['del'];
	mysqli_query($conn, "DELETE FROM stock WHERE id=$id"); 
	header('location: add_stock.php');
}
?>