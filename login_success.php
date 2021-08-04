<?php  
 //login_success.php  
 session_start();  
 if(isset($_SESSION["username"]))  {  
 }  
 else  
 {  
      header("location:login.php");  
 }  
 ?>  