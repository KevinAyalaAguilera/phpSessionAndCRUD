<?php
	include_once "./controller/controller.php";
	if (isset($_SESSION["user"])) header("location: ./pages/listServices.php");
	else header("location: ./pages/showLogIn.php");
?>
