<?php
include_once "../model/model.php";
if (isset($_POST["login"])) logIn();
else if (isset($_SESSION["user"])) {
    return;
} 
else if($_SERVER['REQUEST_URI'] != '/pages/showLogIn.php' && $_SERVER['REQUEST_URI'] != '/pages/privacy.php') header("location: ./showLogIn.php");
?>
