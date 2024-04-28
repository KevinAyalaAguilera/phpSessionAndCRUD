<?php
include_once "../controller/controller.php";
if (isset($userROL)) {
	include_once "./header.php";
	if ($userROL != "superadmin") {
		header("location: ../index.php");
		exit();
	}
} else {
	header("location: ../index.php");
	exit();
}

if (isset($_POST['userEliminar'])) {
	$userEliminado = $_POST['userEliminar'];
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
<?php
if (isset($_POST['create'])) {
	createUser();
}
listUsers();
include_once "./footer.php";
?>
<script>
	document.getElementById("header-btn-cuser").classList.add("header-btn-selected")
</script>