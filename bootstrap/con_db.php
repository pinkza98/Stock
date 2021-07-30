<?php 

    $db_host = 'localhost';
    $db_name = 'id17334380_warehouse';
    $db_user = 'id17334380_root';
    $db_password = '%&EFAxk$Vo1HE9}n';

    try {
        $con = new PDO("mysql:host=$db_host;dbname=$db_name","$db_user","$db_password",
        array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
        echo 'Connected PDO SQL Pass!' ;
           }
      
      catch(PDOException $error) {
        echo 'Error Cannot Connected PDO SQL<br>';
        echo $error -> getMessage() ;
      }
      
      
      
      ?>