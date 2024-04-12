<?php
include_once "../controller/controller.php";
if (!isset($_SESSION["rol"])) header("location: ../index.php");

// Ejemplo de datos ficticios
$datos = $_SESSION['excel'];

// Agrupar los datos por el valor de $fila['asignadoA']
$datos_agrupados = array();
foreach ($datos as $fila) {
    $asignadoA = getBy('name', 'users', 'id', $fila['asignadoA']);
    $datos_agrupados[$asignadoA][] = $fila;
}

// Generar el contenido del archivo CSV
$csv_content = 'LISTADO DE REPARTO ---- ' . date("d/m/Y") . "\n";
$csv_content .= 'Grupo Valbea' . "\n\n\n";
foreach ($datos_agrupados as $asignadoA => $filas) {
    $csv_content .= "--------------- Asignado a: $asignadoA --------------- \n";
    foreach ($filas as $fila) {
        if ($fila['estado'] == 3) {
            $idEmpresa = getBy('name', 'empresas', 'id', $fila['idEmpresa']);
            $csv_content .= "\n" . $fila['id'] . " - ";
            $csv_content .= $fila['nombreCliente'] . "\n";
            $csv_content .= $fila['calleCliente'] . " - ";
            $csv_content .= $fila['poblacionCliente'] . " - ";
            $csv_content .= $fila['telefonoCliente'] . "\n";
            $csv_content .= $idEmpresa . "\n"; // Utiliza el valor directamente
            $csv_content .= $fila['comentarioExterno'] . "\n";
        }
    }
    $csv_content .= "\n\n"; // Agregar una línea en blanco entre grupos
}

// Encabezados HTTP para indicar que se está devolviendo un archivo CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="datos.csv"');

// Imprimir el contenido del archivo CSV, que será devuelto como respuesta a la solicitud AJAX
echo $csv_content;
?>