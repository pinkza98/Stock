<?php 

    $db_host = "localhost";
    $db_user = "plusdental_warehouse";
    $db_password = "P@ssw0rd123!@#";
    $db_name = "plusdental_warehouse";

    try {
        $db = new PDO("mysql:host={$db_host}; dbname={$db_name}", $db_user, $db_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch(PDOEXCEPTION $e) {
        $e->getMessage();
    }

?>