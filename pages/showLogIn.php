<?php
include_once "../controller/controller.php";
include_once "./header.php";
if (isset($userROL)) {
	header("location: ../pages/listServices.php");
	exit();
}
?>
<link rel="stylesheet" href="../css/frontpage.css?2211">
<div class="frontpage">
	<h4 class="frontpage">GRUPO</h4>
	<img src="../img/cropped-Logo-valbea-300x277.png" class="mainlogo-frontpage">
	<h4 class="frontpage">VALBEA</h4>
</div>

<a class="frontpage-right-btn" href="#first-cascade-wrapper" style="margin-top: 75vh;">^</a>

<!-- <img class="frontpage soloMovil main-background" src="../img/pexels/pexels-photo-5025494.jpeg"> -->
<!-- <img class="frontpage soloDesktop main-background" src="../img/pexels/pexels-photo-4391470.jpeg"> -->

<div class="cascade-wrapper first" id="first-cascade-wrapper">
	<!-- <img class="frontpage soloMovil" src="../img/pexels/pexels-photo-5025494.jpeg"> -->
	<!-- <img class="frontpage soloDesktop" src="../img/pexels/pexels-photo-4391470.jpeg"> -->
	<div class="frontpage-textblock">
		<p><span>En <b style="font-size: inherit;">Grupo Valbea</b> llevamos 7 años ofreciendo servicios de transporte de calidad y eficientes a nivel local y nacional, lo que demuestra nuestra experiencia y compromiso con los clientes.</span></p>
		<p><span><a class="frontpage-link" href="#about">Descubre más sobre nosotros.</a></span></p>
		<p><span><a class="frontpage-link" href="#flogin">Área cliente</a></span></p>
		<p><span><a class="frontpage-link" href="#contact">Contáctanos</a></span></p>
	</div>
</div>

<div class="cascade-wrapper" id="about">
	<!-- <img class="frontpage soloMovil" src="../img/pexels/pexels-photo-5025517.jpeg"> -->
	<!-- <img class="frontpage soloDesktop" src="../img/pexels/pexels-photo-4246120.jpeg"> -->
	<div class="frontpage-textblock">
		<p><span>Nos enorgullece destacar nuestros valores de transparencia y honestidad, que ayudan a generar confianza en nuestros clientes.</span></p>
		<p><span>Además, nuestra <b style="font-size: inherit;">división de servicios de renovación de hogares</b> se dedica a mejorar los ambientes tanto en el interior como en el exterior de los hogares, lo que demuestra nuestra versatilidad y compromiso en ofrecer soluciones integrales a nuestros clientes.</span></p>
		<p><span>En Grupo Valbea, estamos comprometidos en ofrecer un servicio seguro y confiable a nuestros clientes.</span></p>
		<p><span><b style="font-size: inherit;">¡Gracias por elegirnos!</b></span></p>
	</div>
</div>

<div class="cascade-wrapper" id="flogin">
	<!-- <img class="frontpage soloMovil" src="../img/pexels/pexels-photo-4498136.jpeg"> -->
	<!-- <img class="frontpage soloDesktop" src="../img/pexels/pexels-photo-5691515.jpeg"> -->
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

<div class="cascade-wrapper" id="contact">
	<!-- <img class="frontpage soloMovil" src="../img/pexels/pexels-photo-4498132.jpg"> -->
	<!-- <img class="frontpage soloDesktop" src="../img/pexels/pexels-photo-5217124.jpeg"> -->
	<div class="frontpage-textblock">
		<form method="POST" class="login">
			<h4 class="frontpage-h4">Contacto:</h4>
			<input class="btn input" type="text" placeholder=" Nombre" name="user" required>
			<input class="btn input" type="text" placeholder=" Email o Teléfono" name="origin" required>
			<textarea class="btn input" rows="4" cols="50" placeholder=" Mensaje" name="message" required></textarea>
			<input class="btn button" type="submit" name="login" value="Enviar">
			<p id="notificacion"></p>
		</form>
	</div>
</div>

