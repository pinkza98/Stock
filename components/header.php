<?php  
session_start();  
  if(isset($_SESSION["user_login"]))  {  
      
  }  
  else{  
      header("location:login.php");  
      }  
?>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style type="text/css">
    @import 'https://fonts.googleapis.com/css?family=Kanit|Prompt';

    html,
    body {
        height: 100%;
        /* ให้ html และ body สูงเต็มจอภาพไว้ก่อน */
        margin: 0;
        padding: 0;
    }

    div.img-resize img {
        width: 75px;
        height: auto;
    }

    div.img-resize {
        width: 100px;
        height: 60px;
        overflow: hidden;
        text-align: center;
    }

    html {

        font-family: 'Kanit', sans-serif;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    a {
        font-family: 'Kanit', sans-serif;

    }

    p,
    a {
        font-size: 15px;
    }

    header {
        height: 50px;
    }

    footer {
        height: 60px;
        background: black;
    }

    /**** Trick: ****/
    body {
        display: table;
        width: 100%;
    }

    footer {
        display: table-row;
    }

    .tableFixHead {
        overflow-y: auto;
        height: 100%;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .tableFixHead tbody th {
        position: sticky;
        left: 0;
    }
    </style>
   