<?php
include_once "../controller/controller.php";
if (isset($_SESSION["rol"])) {
	include_once "./header.php";
} else header("location: ../index.php");
?>
<form method="post" class="lineasFilter">
	<input type="text" placeholder="Nombre" name="name" class="btn input" required>
	<input type="text" placeholder="Calle" class="calle btn input" name="calle" required>
	<input type="text" placeholder="Población" class="btn input" name="poblacion" required>
	<input type="text" placeholder="Teléfono" class="btn input" name="telf" required>
	<input type="text" placeholder="Nota" class="btn input" name="nota" required>
	<input type="date" name="date" class="btn input" required>
<?php

if ($userEmpresaID == $idValbea) {
	echo '<select class="admin btn input" name="empresa" placeholder="Empresa" required>';
	echo '<option value="">Empresa</option>';
	$empresas = getArrayEmpresas();
	for ($i = 0; $i < count($empresas); $i++) {
		echo '<option value="' . $empresas[$i]['id'] . '">' . $empresas[$i]['name'] . '</option>';
	}
	echo '</select>';
} else echo '<input type="hidden" name="empresa" value="' . $userEmpresaID . '"></label>';

?>
	<input type="submit" value="Crear" class="btn button" name="create">
	<p id="notificacion"></p>
</form>
<svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" fill="cyan" class="bi bi-box-seam" viewBox="0 0 16 16">
	<path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z" />
</svg>
<?php
createService();
include_once "./footer.php";
?>
<script>
	document.getElementById("header-btn-cservice").classList.add("header-btn-selected");
</script>
</body>