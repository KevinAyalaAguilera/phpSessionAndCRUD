<?php
include_once "../controller/controller.php";
if (isset($userROL)) {
	include_once "./header.php";
} else {
	header("location: ../index.php");
	exit();
}

// Obtener el ID del elemento que se va a editar
$id = isset($_GET['service']) ? $_GET['service'] : null;

if ($id === null) {
	// Manejar el caso en que no se proporciona un ID de servicio válido

	// Podrías mostrar un mensaje de error o redirigir a una página de error.
	exit("ID de servicio no proporcionado");
}

// Obtener los datos del servicio a editar
$service = getRowBy('services', 'id', $id); // Debes tener una función similar en tu controlador que obtenga los datos del servicio por ID.

// Verificar si el servicio existe
if (!$service) {
	// Manejar el caso en que el servicio no existe
	header("location: ./listServices.php");
}

// Si la empresa del servicio no es igual a la empresa de la sesión y la empresa del servicio no es igual a valbea, se le envía a listServices
if ($service['idEmpresa'] != $userEmpresaID && $userEmpresaID != $idValbea) {
	header("location: ./listServices.php");
	exit();
}

if ($service['horaRealizacion'] == '00:00:00') $service['horaRealizacion'] = '';

// SI ERES user DE VALBEA
if ($userEmpresaID == $idValbea && $userROL == "user") include_once "./modifyServiceUser.php";

// SI ERES DE OTRA EMPRESA
if ($userEmpresaID == $service['idEmpresa']) include_once "./modifyServiceEmpresa.php";

// SI ERES SUPER ADMIN O SUPERADMIN
if ($userEmpresaID == $idValbea && ($userROL == "superadmin" || $userROL == "admin")) include_once "./modifyServiceAdmin.php";

?>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var notificacion = document.getElementById("notificacion");
		var inputs = document.querySelectorAll('.inputfile');
		var loadedDocument = false;
		Array.prototype.forEach.call(inputs, function(input) {

			input.addEventListener('change', function(e) {
				var fileName = '';
				if (this.files && this.files.length > 1)
					fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
				else
					fileName = e.target.value.split('\\').pop();

				// Activar automáticamente el envío del formulario correspondiente cuando se seleccione un archivo
				if (input.id === 'fileInput') {
					document.getElementById("submitBtnOk").click();
				} else if (input.id === 'fileInput2') {
					document.getElementById("submitBtnInc").click();
					var checkbox = document.getElementById('incidencia');
					checkbox.checked = true;
				}
			});
		});

		var forms = document.querySelectorAll('.uploadForm');
		forms.forEach(function(form) {
			form.addEventListener('submit', function(event) {
				event.preventDefault(); // Evita que el formulario se envíe de forma sincrónica

				var formData = new FormData(this); // Crea un objeto FormData con los datos del formulario
				var xhr = new XMLHttpRequest(); // Crea una nueva solicitud AJAX

				// Configura la solicitud AJAX
				xhr.open('POST', 'upload.php', true);

				// Define la función a ejecutar cuando se complete la solicitud AJAX
				xhr.onload = function() {
					if (xhr.status === 200) {
						//console.log(xhr.responseText);
					} else {
						document.getElementById("notificacion").innerText = "Error al subir archivo/imagen.";
					}
				};

				// Envía la solicitud AJAX con los datos del formulario
				xhr.send(formData);
				notificacion.innerText = "Archivo o imagen subido.";
				setTimeout(function() {
					window.location.reload();
				}, 2000);
			});
		});

	});
</script>


<?php
echo '<div id="modifyService-bu" class="modifyService-documentManagement">';


// MOSTRAR ARCHIVOS

$conexion = connectDB();

// Consulta para seleccionar los archivos asociados al servicio específico
$id_servicio = $service["id"];

// Consulta para seleccionar los archivos asociados al servicio específico
$sql = "SELECT nombre_archivo FROM archivos WHERE id_servicio = '$id_servicio'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
	echo "<p>Archivos asociados a este servicio:</p>";
	echo "<ul>";
	while ($row = $result->fetch_assoc()) {
		$n_a = explode('-', $row['nombre_archivo']);
		$nombre_final = $n_a[0] . '-' . $n_a[2] . '-' . $n_a[4] . '-' . $n_a[6];
		// Mostrar cada archivo como un elemento de lista con un enlace de descarga
		echo "<li><a href='descargar_archivo.php?nombre_archivo=" . $row['nombre_archivo'] . "'>" . $nombre_final . "</a></li>";
	}
	echo "</ul>";
}

echo '</div>';


echo '<p id="notificacion"></p>';
?>


<?php
include_once "./footer.php";
?>