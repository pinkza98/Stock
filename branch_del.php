<?php 
include 'con_db.php';
if (isset($_GET['del'])) {
	$id = $_GET['del'];
	mysqli_query($conn, "DELETE FROM branch WHERE id=$id");

	header('location: branch_add.php');
}
?>