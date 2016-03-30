<?php
    
    $cookie_name="notapp_username";
    setcookie($cookie_name, "" , time() - (86400), "/");
    header( "Location:index.php");
    exit();
?>