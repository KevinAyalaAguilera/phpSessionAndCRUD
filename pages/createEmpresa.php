<?php
	include_once "../controller/controller.php";
	if (isset($userROL)) {
		include_once "./header.php";
		if ($userROL != "superadmin") {
			header("location: ../index.php");
		}
	} else header("location: ../index.php");

	if (isset($_POST['empresaEliminar'])) {
		$empresaEliminado = $_POST['empresaEliminar'];
		$conexion = connectDB();
	
		$stmt_delete = $conexion->prepare("DELETE FROM empresas WHERE id = ?");
		$stmt_delete->bind_param("i", $empresaEliminado);
		$stmt_delete->execute();
		$stmt_delete->close();
	
		$conexion->close();
		notificacion("Empresa eliminada correctamente.");
	}
?>
<form method="post" class="lineasFilter">
	<h3>Empresas cliente</h3>
	<input type="text" placeholder="Nombre" name="nombreEmpresa" class="btn input" required>
	<input type="text" placeholder="CIF" name="cifEmpresa" class="btn input" required>
	<input type="text" placeholder="Dirección" name="direccionEmpresa" class="btn input" required>
	<input type="submit" value="Crear" class="btn button" name="createEmpresa">
	<p id="notificacion"></p>
</form>

<?php
	if (isset($_POST['createEmpresa'])) {
		createEmpresa();
	}
	listEmpresas();
	include_once "./footer.php";
?>
<script>
	document.getElementById("header-btn-cempresa").classList.add("header-btn-selected")
</script>