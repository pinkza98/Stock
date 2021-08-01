<?php 

    $db_host = "localhost";
    $db_user = "id16055227_poniaza";
    $db_password = "x}p1#qOZtS1@1mC2";
    $db_name = "id16055227_warehouse";

    try {
        $db = new PDO("mysql:host={$db_host}; dbname={$db_name}", $db_user, $db_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch(PDOEXCEPTION $e) {
        $e->getMessage();
    }

?>