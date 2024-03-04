<?php 
	if (isset($_SESSION["rol"])) {
		echo '<head>';
		echo '<link rel="stylesheet" href="../css/style.css">';
		echo '</head>';
		if ($_SESSION["rol"] == "admin") {
			echo '<div class="header">';
			echo '<h3>Shop (admin '. $_SESSION["user"] . ')</h3>';
			echo '<table><tr>';
			echo '<td><a href="./createUser.php">Create user</a></td>';
			echo '<td><a href="./createProduct.php">Create product</a></td>';
			echo '<td><a href="./deleteProduct.php">Remove product</a></td>';
			echo '<td><a href="./modifyProduct.php">Modify product</a></td>';
			echo '<td><a href="./listProducts.php">Product list</a></td>';
			echo '<td><a href="./logOff.php">Log off</a></td>';
			echo '</tr></table>';
			echo '</div>';
		}
		else {
			echo '<div class="header">';
			echo '<h3>Shop (user '. $_SESSION["user"] . ')</h3>';
			echo '<table><tr>';
			echo '<td><a href="./listProducts.php">Product list</a></td>';
			echo '<td><a href="./logOff.php">Log off</a></td>';
			echo '</tr></table>';
			echo '</div>';
		}
	}
	else {
		echo '<head>';
		echo '<link rel="stylesheet" href="./css/style.css">';
		echo '</head>';
		echo '<div class="header">';
		echo '<h3>Header</h3>';
		echo '</div>';
	}
?>