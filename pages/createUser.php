<?php
include_once "../controller/controller.php";
if (isset($_SESSION["rol"])) {
	include_once "./header.php";
	if ($_SESSION["rol"] != "superadmin") {
		header("location: ../index.php");
	}
} else header("location: ../index.php");

if (isset($_POST['userEliminar'])) {
	$userEliminado = $_POST['user'];
	$conexion = connectDB();

	$stmt_delete = $conexion->prepare("DELETE FROM users WHERE id = ?");
	$stmt_delete->bind_param("i", $userEliminado);
	$stmt_delete->execute();
	$stmt_delete->close();

	$conexion->close();
	notificacion("Usuario eliminado correctamente.");
}

?>
<form method="post" class="lineasFilter">
	<h3>Crear usuario</h3>
	<input type="text" placeholder="Nombre" name="user" class="btn input" required>
	<input type="text" placeholder="Contraseña" name="password" class="btn input" required>
	<select name="rol" placeholder="Usuario" class="btn input" required>
		<option value="user">Usuario</option>
		<option value="admin">Admin</option>
		<option value="superadmin">Super Admin</option>
	</select>
	<select name="empresa" placeholder="Empresa" class="btn input" required>
		<option value="1">Empresa</option>
		<?php
		$empresas = getArrayEmpresas();
		for ($i = 0; $i < count($empresas); $i++) {
			echo '<option value="' . $empresas[$i]['id'] . '">' . $empresas[$i]['name'] . '</option>';
		}
		?>
	</select>
	<input type="submit" value="Crear" class="btn button" name="create">
	<p id="notificacion"></p>
</form>
<svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" fill="rgb(13, 97, 247, 0.2)" class="bi bi-person-circle" viewBox="0 0 16 16">
	<path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
	<path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
</svg>
<?php
createUser();
listUsers();
include_once "./footer.php";
?>
<script>
	document.getElementById("header-btn-cuser").classList.add("header-btn-selected")
</script>
