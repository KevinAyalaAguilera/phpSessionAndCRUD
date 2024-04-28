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

if (isset($_POST["estados"])) {
	actualizarSinAsignarAsignado();
	actualizarEstadosServicios();
	notificacion("Estados actualizados.");
}
if (isset($_POST["archivos"])) {
	eliminarArchivosAntiguos();
	notificacion("Archivos de más de 40 días eliminados.");
}
if (isset($_POST["registro"])) {
	borrarLogAntiguo();
	notificacion("Log de más de 40 días borrado.");
}

?>
<form method="post" class="lineasFilter">
	<input style="width: 100%;" type="submit" value="Forzar actualización de estados" class="configBTN" name="estados">
</form>
<form method="post" class="lineasFilter">
	<input style="width: 100%;" type="submit" value="Eliminar archivos de más de 40 días" class="configBTN" name="archivos">
</form>
<form method="post" class="lineasFilter">
	<input style="width: 100%;" type="submit" value="Borrar entradas en el registro de más de 40 días" class="configBTN" name="registro">
</form>
<div class="lineasFilter">
	<p id="notificacion"></p>
</div>

<?php
include_once "./footer.php";
?>
<script>
	document.getElementById("header-btn-cconfig").classList.add("header-btn-selected")
</script>