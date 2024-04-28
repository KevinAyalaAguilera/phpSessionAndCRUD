<?php
include_once "../controller/controller.php";
if (!isset($_SESSION["rol"])) {
    header("location: ../index.php");
    exit();
}

// Ejemplo de datos ficticios
$datos = $_SESSION['excel'];

// Generar el contenido del archivo CSV
$csv_content = 'ID,NOMBRE,CALLE,POBLACIÓN,TELF,FECHA_ENTREGA,HORA_REALIZACIÓN,EMPRESA,ESTADO,TRABAJADOR,INCIDENCIA,NOTA,NOTA2' . "\n";
foreach ($datos as $fila) {
	$fila['estado'] = getBy('name', 'estados', 'id', $fila['estado']);
	$fila['asignadoA'] = getBy('name', 'users', 'id', $fila['asignadoA']);
	$fila['idEmpresa'] = getBy('name', 'empresas', 'id', $fila['idEmpresa']);
	if ($fila['incidencia'] == 0) $fila['incidencia'] = '';
	else $fila['incidencia'] == 'SI';
	if ($userEmpresaID != 1 || $_SESSION['rol'] != "superadmin") $fila['comentarioInterno'] = '';
    $csv_content .= implode(',', $fila) . "\n";
}

// Encabezados HTTP para indicar que se está devolviendo un archivo CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="datos.csv"');

// Imprimir el contenido del archivo CSV, que será devuelto como respuesta a la solicitud AJAX
echo $csv_content;
?>