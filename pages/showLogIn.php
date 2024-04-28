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

	<!--- <a class="frontpage-right-btn" href="#ini" style="margin-top: 75vh;">^</a> -->
	<a class="frontpage-right-btn" href="#ini">
		<img src="../img/flecha.png">
	</a>

	<div class="cascade-wrapper first" id="first-cascade-wrapper">
		<div class="frontpage-textblock">
			<p><span>En <b style="font-size: inherit;">Grupo Valbea</b> llevamos 7 años ofreciendo servicios de transporte de calidad y eficientes a nivel local y nacional, lo que demuestra nuestra experiencia y compromiso con los clientes.</span></p>
			<p><span><a class="frontpage-link" href="./singIn.php">Área cliente</a></span></p>
			<p><span><a class="frontpage-link" href="#contact">Contáctanos</a></span></p>
			<p><span><a class="frontpage-link" href="#about">Descubre más sobre nosotros.</a></span></p>
		</div>
	</div>

	<div class="cascade-wrapper" id="contact">
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

	<div class="cascade-wrapper" id="about" style="margin-bottom: 5em;">
		<div class="frontpage-textblock">
			<p><span>Nos enorgullece destacar nuestros valores de transparencia y honestidad, que ayudan a generar confianza en nuestros clientes.</span></p>
			<p><span>Además, nuestra <b style="font-size: inherit;">división de servicios de renovación de hogares</b> se dedica a mejorar los ambientes tanto en el interior como en el exterior de los hogares, lo que demuestra nuestra versatilidad y compromiso en ofrecer soluciones integrales a nuestros clientes.</span></p>
			<p><span>En Grupo Valbea, estamos comprometidos en ofrecer un servicio seguro y confiable a nuestros clientes.</span></p>
			<p><span><b style="font-size: inherit;">¡Gracias por elegirnos!</b></span></p>
			<p><span><a class="frontpage-link" href="./privacy.php">Política de privacidad y cookies</a></span></p>
		</div>
	</div>

</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Obtener los datos del formulario
	$nombre = $_POST['user'];
	$origen = $_POST['origin'];
	$mensaje = $_POST['message'];

	// Configurar el correo electrónico
	$destinatario = "gerencia@grupovalbea.com";
	$asunto = "Nuevo mensaje de contacto desde tu sitio web";
	$contenido = "Nombre: $nombre\n";
	$contenido .= "Origen: $origen\n";
	$contenido .= "Mensaje:\n$mensaje\n";
	$cabeceras = "From: $origen";

	// Enviar el correo electrónico
	if (mail($destinatario, $asunto, $contenido, $cabeceras)) {
		echo "<p id='notificacion'>¡El mensaje ha sido enviado correctamente!</p>";
	} else {
		echo "<p id='notificacion'>Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo más tarde.</p>";
	}
}
?>