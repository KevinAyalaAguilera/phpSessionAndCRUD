<?php
	session_start();
	include_once "./controller.php";
	if (isset($_SESSION["rol"])) {
		include_once "./header.php";
		if ($_SESSION["rol"] == "admin") {
			echo "<h3>Create user</h3>";
		} else {
			header("location: ./listProducts.php");
		}
	} else header("location: ../index.php");
?>
<form method="post">
	<input type="number" placeholder="ID" name="id">
	<input type="text" placeholder="User" name="user">
	<input type="password" placeholder="Password" name="password">
	<input type="text" placeholder="admin / normal" name="rol">
	<input type="submit" value="Create" name="create">
</form>
<?php
	createUser();
	include_once "./footer.php";
?>