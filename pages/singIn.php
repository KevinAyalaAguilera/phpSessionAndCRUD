<?php
include_once "../controller/controller.php";
include_once "./header.php";
if (isset($userROL)) {
	header("location: ../pages/listServices.php");
	exit();
}
?>
<link rel="stylesheet" href="../css/frontpage.css<?php echo '?' . mt_rand(); ?>">
<div class="background-container">
	<img src="../img/pexels/pexels-photo-5025494.jpg" class="background-image soloMovil">
	<img src="../img/pexels/pexels-photo-4391470.jpg" class="background-image soloDesktop">
</div>
<div class="content">


	<div class="frontpage" id="ini">
		<h4 class="frontpage" style="font-size: 1.4em;">GRUPO</h4>
		<img src="../img/cropped-Logo-valbea-300x277.png" class="mainlogo-frontpage">
		<h4 class="frontpage" style="font-size: 1.4em;">VALBEA</h4>
	</div>

	<div class="cascade-wrapper" id="flogin">
		<div class="frontpage-textblock">
			<form method="POST" action="listServices.php" class="login" id="login">
				<h4 class="frontpage-h4">Área Cliente:</h4>
				<input class="btn input" type="text" placeholder=" Usuario" name="user" autocomplete="username" required>
				<input class="btn input" type="password" placeholder=" Contraseña" name="password" autocomplete="current-password" required>
				<input class="btn button" type="submit" name="login" value="Iniciar sesión">
				<p id="notificacion"></p>
			</form>
		</div>
	</div>

</div>