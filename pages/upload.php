<?php
include_once "../controller/controller.php";
if (!isset($userROL)) {
	header("location: ../index.php");
	exit();
}
// Verificamos si se ha enviado un archivo
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Ruta donde se guardarán las imágenes (ajusta esta ruta según tu configuración)
    $uploadDirectory = '../valbeadocs/';

    // Nombre del archivo
    //$filename = $_FILES['file']['name'];
	$filename = $_POST['id'] . '-USER-' . $_SESSION['user'] . '-ID-'. generarID() . '.' . explode('.', $_FILES['file']['name'])[1];

    if (isset($_POST['inc'])) {
        setServiceIncidence($_POST['id'], 1);
        $filename = 'INC-' . $filename;
    } else {
        $filename = 'OK-' . $filename;
    }

    // Movemos el archivo desde el directorio temporal al directorio de destino
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadDirectory . $filename)) {
        // La imagen se ha subido correctamente
        insertIntoFileLog($_POST['id'], $filename);
        notificacion("Se ha subido correctamente.");
    } else {
        // Ocurrió un error al mover el archivo
        notificacion("Error al subir.");
    }
} else {
    // Ocurrió un error al cargar el archivo
    notificacion("Error al cargar el archivo.");
}
?>