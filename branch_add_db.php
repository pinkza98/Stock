<?php
include 'con_db.php';
if (isset($_POST['save'])) {
    $branch_name = $_POST['branch_name'];
    mysqli_query($conn, "INSERT INTO branch (branch_name) VALUES ('$branch_name')"); 
    header('location: branch_add.php');
}
?>