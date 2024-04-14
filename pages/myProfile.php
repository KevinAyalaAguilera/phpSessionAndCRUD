<?php
include_once "../controller/controller.php";
if (isset($_SESSION["rol"])) {
	include_once "./header.php";
} else header("location: ../index.php");
if ($_SESSION['userId'] != $_GET['id']) {
    header("location: ../index.php");
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
<svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" fill="cyan" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
</svg>
<?php
	changePassword();
	include_once "./footer.php";
?>
<script>document.getElementById("header-btn-cme").classList.add("header-btn-selected")</script>