<?php

require_once "dbconnect.php";

ini_set("display_errors", 1);

if(!isset($_SESSION)){
    session_start();
}

if($_SESSION){
    $email = $_SESSION['email'];
    session_destroy();
    header("Location: homepage.php");
}
    
?>