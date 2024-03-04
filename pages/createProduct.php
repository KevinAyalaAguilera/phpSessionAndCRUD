<?php
	session_start();
	include_once "./controller.php";
	if (isset($_SESSION["rol"])) {
		include_once "./header.php";
		if ($_SESSION["rol"] == "admin") {
			echo "<h3>Create product</h3>";
		} else {
			header("location: ./listProducts.php");
		}
	} else header("location: ../index.php");
?>
<form method="post">
	<input type="number" placeholder="ID" name="id">
	<input type="text" placeholder="Name" name="name">
	<input type="text" placeholder="Category" name="cat">
	<input type="number" placeholder="Price" name="price">
	<input type="text" placeholder="Origin" name="origin">
	<input type="submit" value="Create" name="create">
</form>
<?php
	createProduct();
	include_once "./footer.php";
?>