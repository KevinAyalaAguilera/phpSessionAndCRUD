<?php
	session_start();
	include_once "./controller.php";
	if (isset($_SESSION["rol"])) {
		include_once "./header.php";
		if ($_SESSION["rol"] == "admin") {
				echo "<h3>Modify product</h3>";
		} else {
			header("location: ./listProducts.php");
		}
		modifyProduct();
		include_once "./footer.php";
	} else header("location: ../index.php");
?>