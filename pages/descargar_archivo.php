<?php
include_once "../controller/controller.php";
if (!isset($userROL)) {
	header("location: ../index.php");
	exit();
}

$conexion = connectDB();

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener el nombre del archivo desde la URL (asegúrate de validar y sanear esta entrada)
$nombre_archivo = $_GET['nombre_archivo'];

// Ruta donde se almacenan los archivos en el servidor
$ruta_archivos = $_SERVER['DOCUMENT_ROOT'] . "/valbeadocs/";

// Ruta completa del archivo
$ruta_completa = $ruta_archivos . $nombre_archivo;

// Verificar si el archivo existe
if (file_exists($ruta_completa)) {
    // Obtener la extensión del archivo
    $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);

    // Definir el tipo MIME según la extensión del archivo
    $mime_types = array(
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
    );

    // Verificar si se conoce el tipo MIME de la extensión del archivo
    $content_type = isset($mime_types[$extension]) ? $mime_types[$extension] : 'application/octet-stream';

    // Enviar el archivo al navegador
    header("Content-type: $content_type");
    header("Content-Disposition: attachment; filename=$nombre_archivo");
    readfile($ruta_completa);
} else {
    echo "Archivo no encontrado.";
}

// Cerrar conexión
$conexion->close();
?>