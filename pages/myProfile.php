<?php
include_once "../controller/controller.php";
if (isset($_SESSION["rol"])) {
	include_once "./header.php";
} else {
    header("location: ../index.php");
	exit();
}
if ($_SESSION['userId'] != $_GET['id']) {
    header("location: ../index.php");
	exit();
}
?>
<form method="post" class="lineasFilter">
	<h3>Cambiar contraseña</h3>
	<input type="hidden" name="user" value="<?php echo $_SESSION["user"]; ?>">
	<input type="password" placeholder="Anterior contraseña" name="old_password" class="btn input" required>
  <input type="password" placeholder="Nueva contraseña" name="new_password" class="btn input" required>
	<input type="submit" value="Actualizar" class="btn button" name="change_password">
	<p id="notificacion"></p>
</form>

<?php
	changePassword();
	include_once "./footer.php";
?>
<script>document.getElementById("header-btn-cme").classList.add("header-btn-selected")</script>