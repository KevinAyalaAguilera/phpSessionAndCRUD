<?php
include_once "../controller/controller.php";
if (isset($userROL)) {
	include_once "./header.php";
	if ($userROL != "superadmin") {
		header("location: ../index.php");
	}
} else header("location: ../index.php");

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
	<input style="width: 100%;" type="submit" value="Forzar actualización de estados" class="btn button" name="estados">
</form>
<form method="post" class="lineasFilter">
	<input style="width: 100%;" type="submit" value="Eliminar archivos de más de 40 días" class="btn button" name="archivos">
</form>
<form method="post" class="lineasFilter">
	<input style="width: 100%;" type="submit" value="Borrar entradas en el registro de más de 40 días" class="btn button" name="registro">
</form>
<div class="lineasFilter">
	<p id="notificacion"></p>
</div>
<svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" fill="rgb(13, 97, 247, 0.2)" class="bi bi-person-circle" viewBox="0 0 16 16">
	<path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
</svg>

<?php
include_once "./footer.php";
?>
<script>
	document.getElementById("header-btn-cconfig").classList.add("header-btn-selected")
</script>