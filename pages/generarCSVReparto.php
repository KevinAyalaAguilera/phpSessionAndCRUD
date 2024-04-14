<?php
include_once "../controller/controller.php";
if (!isset($_SESSION["rol"])) header("location: ../index.php");

// Ejemplo de datos ficticios
$datos = $_SESSION['excel'];

// Agrupar los datos por asignadoA y luego por idEmpresa
$datos_agrupados = array();
foreach ($datos as $fila) {
    $asignadoA = getBy('name', 'users', 'id', $fila['asignadoA']);
    $idEmpresa = getBy('name', 'empresas', 'id', $fila['idEmpresa']);
    $datos_agrupados[$asignadoA][$idEmpresa][] = $fila;
}

// Generar el contenido del archivo CSV
$csv_content = 'LISTADO DE REPARTO - ' . date("d/m/Y") . "\n";
$csv_content .= 'GRUPO VALBEA - B42619684' . "\n\n\n";
foreach ($datos_agrupados as $asignadoA => $empresas) {
    if ($asignadoA != "") {
        $csv_content .= "ASIGNADO A: " . strtoupper($asignadoA) . "\nMATRÍCULA: \n";
        foreach ($empresas as $idEmpresa => $filas) {
            $csv_content .= " > EMPRESA: " . strtoupper($idEmpresa) . "\n";
            foreach ($filas as $fila) {
                if ($fila['estado'] == 3) {
                    $csv_content .= ' > > ' . $fila['nombreCliente'] . " - ";
                    $csv_content .= $fila['calleCliente'] . " - ";
                    $csv_content .= $fila['poblacionCliente'] . " - ";
                    $csv_content .= $fila['telefonoCliente'] . " - ";
                    $csv_content .= $fila['comentarioExterno'];
                    $csv_content .= "\n";
                }
            }
        }
        $csv_content .= "\n"; // Agregar una línea en blanco entre grupos
    }
}

// Encabezados HTTP para indicar que se está devolviendo un archivo CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="datos.csv"');

// Imprimir el contenido del archivo CSV, que será devuelto como respuesta a la solicitud AJAX
echo $csv_content;
