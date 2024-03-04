<?php
	session_start();
	include_once "./controller.php";
	if (isset($_SESSION["rol"])) {
		include_once "./header.php";
		if ($_SESSION["rol"] == "admin") {
				echo "<h3>Delete product</h3>";
			} else {
				header("location: ./listProducts.php");
			}
	} else header("location: ../index.php");
?>
<?php
	deleteProduct();
?>
<?php
	include_once "./footer.php";
?>