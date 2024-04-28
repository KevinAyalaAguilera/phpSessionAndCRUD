<?php
include_once "../controller/controller.php";
if (isset($_SESSION["rol"])) {
	include_once "./header.php";
} else {
	header("location: ../index.php");
	exit();
}

if ($userEmpresaID != $idValbea) {
	header("location: ../index.php");
	exit();
}

echo '<form method="POST" class="lineasFilter serviceModify">';
echo '<h3 style="width: 100%">Aplazando Servicio</h3>';
echo '<input type="hidden" name="id" value="' . $_GET['service'] . '">';

// Aplazar

echo '<label>Aplazando entrega ' . $_GET['service'] . '</label>';
echo '<label>Intrdoduce nueva fecha de entrega:</label>';
echo '<input class="btn input" type="date" name="nuevaFecha" required>';

echo '<div class="separadorInvisible" id="separadorInvisible"></div>';


echo '<input type="submit" value="Aceptar" id="submitButton" class="serviceModifySubmit admin btn button">';
echo '<p id="notificacion"></p>';
echo '</form>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Recuperar los datos del formulario
	$oldService = getRowBy('services', 'id', $_GET['service']);
	echo $oldService['nombreCliente'];

	$conexion = connectDB();
	$sql = "UPDATE services SET estado = 5 WHERE id = '" . $_GET['service'] . "';";
	$conexion->query($sql);

	// Preparar la consulta para verificar IDs existentes
	$sql = "SELECT id FROM Services";
	$result = $conexion->query($sql);
	$existingIds = array();
	while ($row = $result->fetch_assoc()) {
		$existingIds[] = $row['id'];
	}

	do {
		$id = generarID();
		$fecha = DateTime::createFromFormat('Y-m-d', $_POST["nuevaFecha"]); // Convertir a objeto DateTime
		$id = $fecha->format("Y") . $fecha->format("m") . $fecha->format("d") . '-' . $id; // Formatear la fecha correctamente
	} while (in_array($id, $existingIds));


	$nuevoEstado = 1; // sin asignar
	$nota = 'Viene de ' . $_GET['service'] . ' aplazada.';
	// Insertar el servicio utilizando una consulta preparada
	$stmt = $conexion->prepare("INSERT INTO Services (id, nombreCliente, calleCliente, poblacionCliente, telefonoCliente, fechaServicio, idEmpresa, estado, comentarioExterno) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssssiis", $id, $oldService["nombreCliente"], $oldService["calleCliente"], $oldService["poblacionCliente"], $oldService["telefonoCliente"], $_POST["nuevaFecha"], $oldService["idEmpresa"], $nuevoEstado, $nota);

	if ($stmt->execute()) {
		notificacion('Servicio creado con éxito.');
		insertarLog('Genera servicio aplazado ' . $id . ' que viene de ' . $oldService["id"] . '.', $conexion);
	} else {
		notificacion('Error al crear el servicio.');
	}

	// Cerrar la conexión y liberar recursos
	$stmt->close();
	$conexion->close();

	header("location: ../pages/modifyService.php?service=" . $id);
}


include_once "./footer.php";
