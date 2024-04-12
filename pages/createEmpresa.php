<?php
	include_once "../controller/controller.php";
	if (isset($userROL)) {
		include_once "./header.php";
		if ($userROL != "superadmin") {
			header("location: ../index.php");
		}
	} else header("location: ../index.php");
?>
<form method="post" class="lineasFilter">
	<h3>Empresas cliente</h3>
	<input type="text" placeholder="Nombre" name="nombreEmpresa" class="btn input" required>
	<input type="text" placeholder="CIF" name="cifEmpresa" class="btn input" required>
	<input type="text" placeholder="Dirección" name="direccionEmpresa" class="btn input" required>
	<input type="submit" value="Crear" class="btn button" name="createEmpresa">
	<p id="notificacion"></p>
</form>
<svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" fill="cyan" class="bi bi-shop" viewBox="0 0 16 16">
  <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z"/>
</svg>
<?php
	createEmpresa();
	listEmpresas();
	include_once "./footer.php";
?>
<script>document.getElementById("header-btn-cempresa").classList.add("header-btn-selected")</script>