<?php
	session_start();
	include_once "./pages/controller.php";
	include_once "./pages/header.php";
	if (!isset($_SESSION["user"])) showLogIn();
	if (isset($_POST["login"])) logIn();
	include_once "./pages/footer.php";
?>
