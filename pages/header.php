<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, orientation=portrait">
	<link rel="stylesheet" href="../css/style.css<?php echo '?' .mt_rand(); ?>">
	<title>Grupo Valbea</title>
	<link rel="icon" href="../img/cropped-Logo-valbea-1-32x32.png" sizes="32x32">
</head>
<?php
if (isset($userROL)) {
	if ($userEmpresaID == $idValbea) {
		if ($userROL == "superadmin") {
			// superadmin
			echo '<div class="header">';
			echo '<div class="headerMenu">';
			echo '<img src="../img/cropped-Logo-valbea-300x277.png" class="mainlogo">';
			echo '<a class="btn button" id="header-btn-cme" href="./myProfile.php?id=' . $_SESSION['userId'] . '">' . ucfirst($userName) . '</a>';
			echo '<a class="btn button" id="header-btn-clist" href="./listServices.php">Servicios</a>';
			echo '<a class="btn button" id="header-btn-cservice" href="./createService.php">Crear Servicio</a>';
			echo '<a class="btn button" id="header-btn-cuser" class="superadmin" href="./createUser.php">Usuarios</a>';
			echo '<a class="btn button" id="header-btn-cempresa" class="superadmin" href="./createEmpresa.php">Empresas</a>';
			echo '<a class="btn button" id="header-btn-clog" class="superadmin" href="./mostrarLog.php">Registro</a>';
			echo '<a class="btn button" id="header-btn-cconfig" class="superadmin" href="./config.php">Configuración</a>';
			echo '<a class="btn button" href="./logOff.php">Salir</a>';
			echo '</div>';
			echo '</div>';
		} else if ($userROL == "admin") {
			// admin
			echo '<div class="header">';
			echo '<div class="headerMenu">';
			echo '<img src="../img/cropped-Logo-valbea-300x277.png" class="mainlogo">';
			echo '<a class="btn button" id="header-btn-cme" href="./myProfile.php?id=' . $_SESSION['userId'] . '">' . ucfirst($userName) . '</a>';
			echo '<a class="btn button" id="header-btn-clist" href="./listServices.php">Servicios</a>';
			echo '<a class="btn button" id="header-btn-cservice" href="./createService.php">Crear Servicio</a>';
			echo '<a class="btn button" href="./logOff.php">Salir</a>';
			echo '</div>';
			echo '</div>';
		} else {
			// user
			echo '<div class="header">';
			echo '<div class="headerMenu">';
			echo '<img src="../img/cropped-Logo-valbea-300x277.png" class="mainlogo">';
			echo '<a class="btn button" id="header-btn-cme" href="./myProfile.php?id=' . $_SESSION['userId'] . '">' . ucfirst($userName) . '</a>';
			echo '<a class="btn button" id="header-btn-clist" href="./listServices.php">Servicios</a>';
			echo '<a class="btn button" href="./logOff.php">Salir</a>';
			echo '</div>';
			echo '</div>';
		}
	} else {
		// empresa externa
		echo '<div class="header">';
		echo '<div class="headerMenu">';
		echo '<img src="../img/cropped-Logo-valbea-300x277.png" class="mainlogo">';
		echo '<a class="btn button" id="header-btn-cme" href="./myProfile.php?id=' . $_SESSION['userId'] . '">' . ucfirst($userName) . '</a>';
		echo '<a class="btn button" id="header-btn-clist" href="./listServices.php">Servicios</a>';
		echo '<a class="btn button" id="header-btn-cservice" href="./createService.php">Crear Servicio</a>';
		echo '<a class="btn button" href="./logOff.php">Salir</a>';
		echo '</div>';
		echo '</div>';
	}
} else {
	// iniciar sesión

}
?>
