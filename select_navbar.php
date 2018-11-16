<?php

session_start();

if(!isset($_SESSION["login"])){
    header("Location: ./login.php");
    die("ERROR: Access to page is denied");

}
if(isset($_SESSION["permission_type"])){
    if($_SESSION["permission_type"] == 0){
        include "admin_navbar.php";
    }
    else if($_SESSION["permission_type"] == 1){
        include "merchant_navbar.php";
    }
    
}


?>