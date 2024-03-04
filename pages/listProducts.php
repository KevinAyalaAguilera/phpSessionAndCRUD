<?php
	session_start();
	include_once "./controller.php";
	if (isset($_SESSION["rol"])) {
		include_once "./header.php";
		echo "<h3>List of products (showing 3 per page):</h3>";
		listProducts();
		include_once "./footer.php";
	} else header("location: ../index.php");
?>