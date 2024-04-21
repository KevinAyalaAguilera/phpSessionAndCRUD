<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "grupo_valbea_prueba";

session_start();

$idValbea = 1;
$userID;
$userName;
$userROL;
$userEmpresaID;
$userEmpresaCIF;
$userEsDeValbea;

if (isset($_SESSION["userId"])) $userID = $_SESSION["userId"];
if (isset($_SESSION["user"])) $userName = $_SESSION["user"];
if (isset($_SESSION["rol"])) $userROL = $_SESSION["rol"];
if (isset($_SESSION["userEmpresaID"])) $userEmpresaID = $_SESSION["userEmpresaID"];
if (isset($_SESSION["userCIF"])) $userEmpresaCIF = $_SESSION["userCIF"];
if (isset($userEmpresaID)) {
    if ($userEmpresaID == 1) $userEsDeValbea = true;
    else $userEsDeValbea = false;
}


function connectDB()
{
    global $host, $user, $pass, $db;
    $conexion = mysqli_connect($host, $user, $pass, $db);
    if (mysqli_connect_errno()) {
        echo "Error \n";
        echo "Errno: " . mysqli_connect_errno() . "\n";
        echo "Error: " . mysqli_connect_error() . "\n";
        exit;
    }

    return $conexion;
}

function disconnectDB($conexion)
{
    mysqli_close($conexion);
}

function logIn()
{
    if (isset($_POST["login"])) {
        $conexion = connectDB();
        $userName = $_POST["user"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM users WHERE name = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['pass'];
            if (password_verify($password, $hashedPassword)) {
                $_SESSION["user"] = $row['name'];
                $_SESSION["rol"] = $row['rol'];
                $_SESSION["userId"] = $row['id'];
                $_SESSION["userEmpresaID"] = $row['empresaID'];
                $_SESSION["userCIF"] = getBy('cif', 'empresas', 'id', $row['empresaID']);
                if (isset($_SESSION["userId"])) $userID = $_SESSION["userId"];
                if (isset($_SESSION["user"])) $userName = $_SESSION["user"];
                if (isset($_SESSION["rol"])) $userROL = $_SESSION["rol"];
                if (isset($_SESSION["userEmpresaID"])) $userEmpresaID = $_SESSION["userEmpresaID"];
                if (isset($_SESSION["userCIF"])) $userEmpresaCIF = $_SESSION["userCIF"];
                if ($userEmpresaID == 1) $userEsDeValbea = true;
                else $userEsDeValbea = false;
                header("location: ./listServices.php");
                insertarLog("Inicio de sesión.", $conexion);
                exit();
            }
        }
        notificacion('Datos incorrectos.');
    }
}


function listServices()
{
    global $userID, $userROL, $userEmpresaID, $idValbea;

    printFilterInputs();

    if ($userEmpresaID == 1 && $userROL == "user") {
        printEmpresaSelect();
        printSearchButton();
    }

    if ($userEmpresaID != 1) {
        if (isset($_GET['filterDateStart'])) echo '<input class="btn input" value="' . $_GET['filterDateStart'] . '" type="date" name="filterDateStart">';
        else echo '<input class="btn input" type="date" name="filterDateStart">';
        if (isset($_GET['filterDateEnd'])) echo '<input class="btn input" value="' . $_GET['filterDateEnd'] . '" type="date" name="filterDateEnd">';
        else echo '<input class="btn input" type="date" name="filterDateEnd">';
        printUserSelect();
        printStatusSelect();
        printIncCheckbox();
        printExcelButton();
        printSearchButton();
    }

    if ($userEmpresaID == $idValbea && ($userROL == "superadmin" || $userROL == "admin")) {
        if (isset($_GET['filterDateStart'])) echo '<input class="btn input" value="' . $_GET['filterDateStart'] . '" type="date" name="filterDateStart">';
        else echo '<input class="btn input" type="date" name="filterDateStart">';
        if (isset($_GET['filterDateEnd'])) echo '<input class="btn input" value="' . $_GET['filterDateEnd'] . '" type="date" name="filterDateEnd">';
        else echo '<input class="btn input" type="date" name="filterDateEnd">';
        printUserSelect();
        printEmpresaSelect();
        printStatusSelect();
        printIncCheckbox();
        printExcelButton();
        printRepartoButton();
        printSearchButton();
    }

    echo '<p id="notificacion"></p>';
    echo '</form>';

    if ($_SERVER["REQUEST_METHOD"] === "GET") {

        $conexion = connectDB();

        // Construir la consulta base
        $sql = "SELECT * FROM Services WHERE 1=1";
        $queryEmpty = true;

        // Aplicar filtros si se han enviado
        if (!empty($_GET["filterMain"])) {
            $sql .= " AND (nombreCliente LIKE '%" . $_GET["filterMain"] . "%'";
            $sql .= " OR id LIKE '%" . $_GET["filterMain"] . "%'";
            $sql .= " OR calleCliente LIKE '%" . $_GET["filterMain"] . "%'";
            $sql .= " OR poblacionCliente LIKE '%" . $_GET["filterMain"] . "%')";
            $queryEmpty = false;
        }
        if (!empty($_GET["filterStatus"])) {
            $sql .= " AND estado = '" . $_GET["filterStatus"] . "'";
            $queryEmpty = false;
        }
        if (!empty($_GET["filterInc"])) {
            $sql .= " AND incidencia = 1";
            $queryEmpty = false;
        }

        if (!empty($_GET["filterUser"])) {
            $sql .= " AND asignadoA = '" . $_GET["filterUser"] . "'";
            $queryEmpty = false;
        }

        // SI LA EMPRESA DEL USER NO ES VALBEA, FILTRAMOS POR SU EMPRESA
        if ($userEmpresaID != $idValbea) {
            $filterEmpresa = $userEmpresaID;
        } else if (!empty($_GET["filterEmpresa"])) {
            $filterEmpresa = $_GET["filterEmpresa"];
        }
        if (!empty($filterEmpresa) && $userEmpresaID != $idValbea) {
            $sql .= " AND idEmpresa = '" . $filterEmpresa . "'";
        } else if (!empty($filterEmpresa)) {
            $sql .= " AND idEmpresa = '" . $filterEmpresa . "'";
            $queryEmpty = false;
        }


        if (!empty($_GET["filterDateStart"])) {
            $sql .= " AND fechaServicio >= '" . $_GET["filterDateStart"] . "'";
        }
        if (!empty($_GET["filterDateEnd"])) {
            $sql .= " AND fechaServicio <= '" . $_GET["filterDateEnd"] . "'";
        }
        if (empty($_GET["filterDateStart"]) && empty($_GET["filterDateEnd"]) && $queryEmpty) {
            $sql .= " AND fechaServicio = '" . date("Y-m-d") . "'";
        }



        // SI ES "USER" DE VALBEA, MUESTRA SOLO SUS SERVICIOS DE HOY
        if ($userEmpresaID == $idValbea && $userROL == "user") {
            $sql .= " AND fechaServicio = '" . date('Y-m-d') . "'";
            $sql .= " AND asignadoA = '" . $userID . "'";
        }


        // Realizar la consulta
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            // Inicializa un array bidimensional para almacenar los resultados
            $datos = array();

            // Itera sobre los resultados y almacénalos en el array bidimensional
            while ($fila = $result->fetch_assoc()) {
                $datos[] = $fila;
            }

            // Almacena el array en $_SESSION
            $_SESSION['excel'] = $datos;
        }
        $result = $conexion->query($sql);

        echo '<div class="lineas">';
        echo '<div class="lineaWrapper soloDesktop lineaWrapper-th">';
        echo '<div>Nombre</div>';
        echo '<div class="calle">Calle</div>';
        echo '<div>Población</div>';
        echo '<div>Teléfono</div>';
        echo '<div>Fecha</div>';
        echo '<div>Asignado a</div>';
        if ($userEmpresaID == $idValbea) echo '<div>Empresa</div>';
        echo '<div>Estado</div>';
        if ($userEmpresaID == $idValbea) echo '<div>Nota interna</div>';
        echo '<div>Nota</div>';
        echo '</div>';
        echo '<div class="separador soloDesktop"></div>';

        while ($row = mysqli_fetch_array($result)) {
            $idDesglosado = explode('-', $row[0]);
            if ($row[8] == 1) echo '<div class="lineaWrapper bootstrap icongeneric servicebackgroundstatus sinasignar">';
            else if ($row[8] == 2) echo '<div class="lineaWrapper bootstrap icongeneric servicebackgroundstatus asignado">';
            else if ($row[8] == 3) echo '<div class="lineaWrapper bootstrap icongeneric servicebackgroundstatus enruta">';
            else if ($row[8] == 4) echo '<div class="lineaWrapper bootstrap icongeneric servicebackgroundstatus entregado">';
            else if ($row[8] == 5) echo '<div class="lineaWrapper bootstrap icongeneric servicebackgroundstatus aplazado">';
            else if ($row[8] == 6) echo '<div class="lineaWrapper bootstrap icongeneric servicebackgroundstatus rechazado">';
            else if ($row[8] == 7) echo '<div class="lineaWrapper bootstrap icongeneric servicebackgroundstatus cancelado">';
            else echo '<div class="lineaWrapper bootstrap icongeneric servicebackgroundstatus box">';
            echo '<div><a class="hiperlink" href="./modifyService.php?service=' . $row[0] . '">' . $row[1] . '-' . $idDesglosado[1] . '</a></div>';
            echo '<div class="calle">' . $row[2] . '</div>';
            echo '<div>' . $row[3] . '</div>';
            echo '<div>' . $row[4] . '</div>';
            echo '<div class="soloDesktop">' . date("d-m-Y", strtotime($row[5])) . '</div>';
            echo '<div class="soloDesktop">' . getBy('name', 'users', 'id', $row[9]) . '</div>';
            if ($userEmpresaID == $idValbea) echo '<div class="soloDesktop">' . getBy('name', 'empresas', 'id', $row[7]) . '</div>';
            echo '<div class="soloDesktop">' . getBy('name', 'estados', 'id', $row[8]) . '</div>';
            if ($userEmpresaID == $idValbea) echo '<div class="soloDesktop">' . $row[11] . '</div>';
            echo '<div class="soloDesktop">' . $row[12] . '</div>';
            echo '</div>';
            echo '<div class="separador"></div>';
        }

        echo '</div>';

        $sqlCount = "SELECT COUNT(*) AS total FROM Services";
        $resultCount = $conexion->query($sqlCount);
        $rowCount = mysqli_fetch_assoc($resultCount);
    }
}


function printFilterInputs()
{
    echo '<form method="get" class="lineasFilter">';
    //echo '<h3>Lista de servicios</h3>';
    if (isset($_GET['filterMain'])) echo '<input class="btn input" value="' . $_GET['filterMain'] . '" type="text" name="filterMain" placeholder="Buscar..">';
    else echo '<input class="btn input" type="text" name="filterMain" placeholder="Buscar...">';
}

function printEmpresaSelect()
{
    echo '<select class="btn input" name="filterEmpresa" placeholder="Empresa">';
    if (isset($_GET['filterEmpresa']) && $_GET['filterEmpresa'] != "") echo '<option value="' . $_GET['filterEmpresa'] . '">' . getBy('name', 'empresas', 'id', $_GET['filterEmpresa']) . '</option>';
    else echo '<option value="">Empresa</option>';
    $empresas = getArrayEmpresasCliente();
    foreach ($empresas as $empresa) {
        echo '<option value="' . $empresa['id'] . '">' . $empresa['name'] . '</option>';
    }
    echo '</select>';
}

function printUserSelect()
{
    echo '<select class="btn input" name="filterUser" placeholder="Empleado">';
    if (isset($_GET['filterUser']) && $_GET['filterUser'] != "") echo '<option value="' . $_GET['filterUser'] . '">' . getBy('name', 'users', 'id', $_GET['filterUser']) . '</option>';
    else echo '<option value="">Empleado</option>';
    $empleados = getArrayEmpleados();
    foreach ($empleados as $empleado) {
        echo '<option value="' . $empleado['id'] . '">' . $empleado['name'] . '</option>';
    }
    echo '</select>';
}

function printStatusSelect()
{
    echo '<select class="btn input" name="filterStatus" placeholder="Estado">';
    if (isset($_GET['filterStatus']) && $_GET['filterStatus'] != "") echo '<option value="' . $_GET['filterStatus'] . '">' . getBy('name', 'estados', 'id', $_GET['filterStatus']) . '</option>';
    else echo '<option value="">Estado</option>';
    $estados = getArrayEstados();
    foreach ($estados as $estado) {
        echo '<option value="' . $estado['id'] . '">' . $estado['name'] . '</option>';
    }
    echo '</select>';
}

function printIncCheckbox()
{
    echo '<div>';
    if (isset($_GET['filterInc'])) echo '<div>Incidencia</div><input type="checkbox" name="filterInc" checked>';
    else echo '<div>Incidencia</div><input type="checkbox" name="filterInc">';
    echo '</div>';
}

function printExcelButton()
{
    echo '<input class="soloDesktop btn button" id="descargarCSV" type="button" value="Excel" name="excel">';
}

function printRepartoButton()
{
    echo '<input class="soloDesktop btn button" id="descargarReparto" type="button" value="Reparto" name="reparto">';
}

function printSearchButton()
{
    echo '<input class="btn button" type="submit" value="Buscar" name="search">';
}



function createService()
{
    if (isset($_POST["create"])) {
        $conexion = connectDB();

        // Preparar la consulta para verificar IDs existentes
        $sql = "SELECT id FROM Services";
        $result = $conexion->query($sql);
        $existingIds = array();
        while ($row = $result->fetch_assoc()) {
            $existingIds[] = $row['id'];
        }

        do {
            $id = generarID();
            $fecha = DateTime::createFromFormat('Y-m-d', $_POST["date"]); // Convertir a objeto DateTime
            $id = $fecha->format("Y") . $fecha->format("m") . $fecha->format("d") . '-' . $id; // Formatear la fecha correctamente
        } while (in_array($id, $existingIds));

        // Insertar el servicio utilizando una consulta preparada
        $stmt = $conexion->prepare("INSERT INTO Services (id, nombreCliente, calleCliente, poblacionCliente, telefonoCliente, comentarioExterno, fechaServicio, idEmpresa, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("ssssssss", $id, $_POST["name"], $_POST["calle"], $_POST["poblacion"], $_POST["telf"], $_POST["nota"], $_POST["date"], $_POST["empresa"]);

        if ($stmt->execute()) {
            notificacion('Servicio creado con éxito.');
            insertarLog('Crea servicio ' . $id . '.', $conexion);
        } else {
            notificacion('Error al crear el servicio.');
        }

        // Cerrar la conexión y liberar recursos
        $stmt->close();
        $conexion->close();
    }
}

function getServiceById($id)
{
    // Conectarse a la base de datos
    $conexion = connectDB();

    // Escapar el ID para prevenir inyección SQL
    $id = mysqli_real_escape_string($conexion, $id);

    // Consulta SQL para obtener los datos del servicio por ID
    $sql = "SELECT * FROM Services WHERE id = '$id'";

    // Ejecutar la consulta
    $result = $conexion->query($sql);

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Obtener la fila de resultados como un arreglo asociativo
        $service = $result->fetch_assoc();
        return $service; // Retornar los datos del servicio
    } else {
        // Si no se encontraron resultados, retornar un arreglo vacío o manejar el error según sea necesario
        return array();
    }
}

function listUsers()
{
    $conexion = connectDB();

    $sql = "SELECT * FROM users";
    $result = $conexion->query($sql);

    $sql2 = "SELECT id, name FROM empresas;";
    $result2 = $conexion->query($sql2);
    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $empresasArray[$row["id"]] = $row["name"];
        }
    }

    echo '<div class="lineas">';
    echo '<div class="lineaWrapper soloDesktop lineaWrapper-th">';
    echo '<div>Usuario</div>';
    echo '<div>Rol</div>';
    echo '<div>Empresa</div>';
    echo '<div>Acciones</div>';
    echo '</div>';
    while ($row = mysqli_fetch_array($result)) {
        echo '<div class="lineaWrapper">';
        echo '<div>' . $row[1] . '</div>';
        echo '<div>' . $row[3] . '</div>';
        echo '<div>' . $empresasArray[$row[4]] . '</div>';
        echo '<div><form method="post">';
        echo '<input type="hidden" value="' . $row[0] . '" name="user">';
        echo '<input type="submit" class="btn button danger" value="Eliminar" name="userEliminar">';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '<div class="separador"></div>';
    }
    echo '</div>';
}

function createUser()
{
    if (isset($_POST["create"])) {
        $user = $_POST["user"];
        $password = $_POST["password"];
        $rol = $_POST["rol"];
        $empresa = $_POST["empresa"];
        $conexion = connectDB();
        // Verifica si ya existe un usuario con el mismo nombre
        $sql = "SELECT * FROM users WHERE name = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            // No existe un usuario con ese nombre, proceder a crearlo
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users`(`name`, `pass`, `rol`, `empresaID`) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssss", $user, $hashedPassword, $rol, $empresa);
            $stmt->execute();
            insertarLog('Crea usuario ' . $user . '.', $conexion);
            notificacion('Usuario ' . $user . ' creado.');
        } else {
            notificacion('No se ha podido crear el usuario.');
        }
    }
}

function changePassword()
{
    if (isset($_POST["change_password"])) {
        $user = $_POST["user"];
        $oldPassword = $_POST["old_password"];
        $newPassword = $_POST["old_password"];
        // Verificar la autenticación del usuario con su contraseña actual
        $conexion = connectDB();
        $sql = "SELECT * FROM users WHERE name = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($oldPassword, $row['pass'])) {
                // La contraseña actual es correcta, proceder a cambiarla
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET pass = ? WHERE name = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("ss", $hashedNewPassword, $user);
                $stmt->execute();
                insertarLog('Cambio de contraseña para el usuario ' . $user . '.', $conexion);
                notificacion('Contraseña cambiada exitosamente.');
            } else {
                notificacion('La contraseña actual es incorrecta.');
            }
        } else {
            notificacion('Usuario no encontrado.');
        }
    }
}

function listEmpresas()
{
    $conexion = connectDB();
    $sql = "SELECT * FROM Empresas";
    $result = $conexion->query($sql);
    echo '<div class="lineas">';
    echo '<div class="lineaWrapper soloDesktop lineaWrapper-th">';
    echo '<div>Empresa</div>';
    echo '<div>Cif</div>';
    echo '<div>Dirección</div>';
    echo '<div>Acciones</div>';
    echo '</div>';
    while ($row = mysqli_fetch_array($result)) {
        echo '<div class="lineaWrapper">';
        echo '<div>' . $row[1] . '</div>';
        echo '<div>' . $row[3] . '</div>';
        echo '<div>' . $row[2] . '</div>';
        echo '<div><form method="post">';
        echo '<input type="hidden" value="' . $row[0] . '" name="empresa">';
        echo '<input type="submit" class="btn button danger" value="Eliminar" name="empresaEliminar">';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '<div class="separador"></div>';
    }
    echo '</div>';
}

function createEmpresa()
{
    // FALTA COMPROBAR QUE CIF ES ÚNICO
    if (isset($_POST["createEmpresa"])) {
        $sql = "SELECT * FROM empresas";
        $conexion = connectDB();
        $result = $conexion->query($sql);
        $datoDuplicado = false;
        while ($row = mysqli_fetch_array($result)) {
            if (!($datoDuplicado)) {
                if ($row[3] == $_POST["cifEmpresa"]) {
                    $datoDuplicado = true;
                    notificacion('No ha sido posible crear la empresa.');
                }
            }
        }
        if (!($datoDuplicado)) {
            notificacion('Empresa ' . $_POST["nombreEmpresa"] . ' creada.');
            $sql = "INSERT INTO `empresas`(`cif`, `name`, `direccion`) VALUES ("
                . "'" . $_POST["cifEmpresa"] . "', "
                . "'" . $_POST["nombreEmpresa"] . "', "
                . "'" . $_POST["direccionEmpresa"] . "'"
                . ");";
            $conexion->query($sql);
            insertarLog('Crea empresa ' . $_POST["nombreEmpresa"] . '.', $conexion);
            notificacion('Empresa ' . $_POST["nombreEmpresa"] . ' creada.');
        }
    }
}

function insertIntoFileLog($service_id, $file_name)
{
    $conexion = connectDB();

    // Preparar la consulta SQL con la columna date y la fecha actual
    $stmt = $conexion->prepare("INSERT INTO archivos (id_servicio, nombre_archivo, date) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $service_id, $file_name);

    if ($stmt->execute()) {
        notificacion('Subido archivo ' . $file_name . ' a la base de datos.');
        insertarLog('Subido archivo ' . $file_name . ' a la base de datos.', $conexion);
    } else {
        notificacion('Error al subir archivo a la base de datos.');
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conexion->close();
}

function listLog()
{

    $conexion = connectDB();

    $sql = "SELECT * FROM log";
    $result = $conexion->query($sql);

    echo '<div class="lineas">';
    echo '<div class="lineaWrapper soloDesktop lineaWrapper-th">';
    echo '<div>Fecha y hora</div>';
    echo '<div>Usuario</div>';
    echo '<div>Acción</div>';
    echo '</div>';
    while ($row = mysqli_fetch_array($result)) {
        echo '<div class="lineaWrapper">';
        echo '<div>' . $row[1] . '</div>';
        echo '<div>' . $row[2] . '</div>';
        echo '<div>' . $row[3] . '</div>';
        echo '</div>';
        echo '<div class="separador"></div>';
    }
    echo '</div>';
}

function deleteService()
{
    if (isset($_POST["delete"])) {
        if (isset($_POST["id"])) {
            $sql = "DELETE FROM Services WHERE id = " . $_POST["id"] . ";";
            $conexion = connectDB();
            $conexion->query($sql);
        }
    }
    $sql = "SELECT * FROM Services;";
    $conexion = connectDB();
    $result = $conexion->query($sql);
    echo '<table><tr><th>ID</th><th>name</th><th>category</th><th>price</th><th>origin</th><th></th></tr>';
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $row[0] . '</td>';
        echo '<td>' . $row[1] . '</td>';
        echo '<td>' . $row[2] . '</td>';
        echo '<td>' . $row[3] . '</td>';
        echo '<td>' . $row[4] . '</td>';
        echo '<td><form method="POST"><input type="text" hidden name="id" value="' . $row[0]
            . '"><input type="submit" class="x" value="X" name="delete"></form></td>';
        echo '</tr>';
    }
    echo '</table>';
    if (isset($_POST["delete"])) {
        if (isset($_POST["id"])) {
            notificacion('Eliminado servicio con ID ' . $_POST["id"] . '.');
        }
    }
}

function modifyService()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar los datos del formulario
        $id = $_POST['id'];
        $nombreCliente = $_POST['nombreCliente'];
        $calleCliente = $_POST['calleCliente'];
        $poblacionCliente = $_POST['poblacionCliente'];
        $telefonoCliente = $_POST['telefonoCliente'];
        $horaRealizacion = $_POST['horaRealizacion'];
        $idEmpresa = $_POST['idEmpresa'];
        $estado = $_POST['estado'];
        $asignadoA = $_POST['asignadoA'];
        $incidencia = isset($_POST['incidencia']) ? 1 : 0;
        $comentarioInterno = $_POST['comentarioInterno'];
        $comentarioExterno = $_POST['comentarioExterno'];

        if ($_POST['BTNestado'] != 0) $estado = $_POST['BTNestado'];

        notificacion($id . " actualizado.");

        $conexion = connectDB();

        $sql = "UPDATE Services SET nombreCliente=?, calleCliente=?, poblacionCliente=?, telefonoCliente=?, horaRealizacion=?, idEmpresa=?, estado=?, asignadoA=?, incidencia=?, comentarioInterno=?, comentarioExterno=? WHERE id=?";

        $stmt = $conexion->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("sssssssiisss", $nombreCliente, $calleCliente, $poblacionCliente, $telefonoCliente, $horaRealizacion, $idEmpresa, $estado, $asignadoA, $incidencia, $comentarioInterno, $comentarioExterno, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            insertarLog("Actualizado el servicio " . $id . ".", $conexion);
            $stmt->close();
            $conexion->close();
            header("location: modifyService.php?service=" .  $id);
        } else {
            notificacion("No se ha podido actualizar.");
            $stmt->close();
            $conexion->close();
        }

        actualizarSinAsignarAsignado();
        actualizarEstadosServicios();
    }
}

function modifyServiceByUser()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['change'] = 1) {
        // Recuperar los datos del formulario
        $id = $_POST['id'];
        $comentarioExterno = $_POST['comentarioExterno'];
        $estado = $_POST['estado'];
        $incidencia = isset($_POST['incidencia']) ? 1 : 0;
        $horaRealizacion = $_POST['horaRealizacion'];

        if ($_POST['BTNestado'] != 0) $estado = $_POST['BTNestado'];

        notificacion($id . " actualizado.");

        $conexion = connectDB();

        $sql = "UPDATE Services SET horaRealizacion=?, comentarioExterno=?, estado=?, incidencia=? WHERE id=?";

        $stmt = $conexion->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("ssiis", $horaRealizacion, $comentarioExterno, $estado, $incidencia, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            insertarLog("Actualizado el servicio " . $id . ".", $conexion);
            $stmt->close();
            $conexion->close();
            header("location: modifyService.php?service=" .  $id);
        } else {
            notificacion("No se ha podido actualizar.");
            $stmt->close();
            $conexion->close();
        }
    }
}

function modifyServiceByClient()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar los datos del formulario
        $id = $_POST['id'];
        $comentarioExterno = $_POST['comentarioExterno'];

        notificacion($id . " actualizado.");

        $conexion = connectDB();

        $sql = "UPDATE Services SET comentarioExterno=? WHERE id=?";

        $stmt = $conexion->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("ss", $comentarioExterno, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            insertarLog("Actualizado el servicio " . $id . ".", $conexion);
            $stmt->close();
            $conexion->close();
            header("location: modifyService.php?service=" .  $id);
        } else {
            notificacion("No se ha podido actualizar.");
            $stmt->close();
            $conexion->close();
        }
    }
}

function setServiceIncidence($service_id, $value)
{


    $conexion = connectDB();

    $sql = "UPDATE Services SET incidencia=? WHERE id=?";

    $stmt = $conexion->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("is", $value, $service_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        insertarLog("Generada incidencia en el servicio " . $service_id . ".", $conexion);
        $stmt->close();
        $conexion->close();
    } else {
        notificacion("No se ha podido actualizar.");
        $stmt->close();
        $conexion->close();
    }
}


function getBy($datoSolicitado, $tabla, $campoEsIgualA, $valorAportado)
{
    $conexion = connectDB();

    // Escapar el valor para prevenir inyección SQL
    $valor = mysqli_real_escape_string($conexion, $valorAportado);

    // Construir la consulta SQL utilizando consultas preparadas para mayor seguridad
    $sql = 'SELECT ' . $datoSolicitado . ' FROM ' . $tabla . ' WHERE ' . $campoEsIgualA . ' = ?';

    // Preparar la consulta
    $stmt = $conexion->prepare($sql);

    // Vincular el parámetro y ejecutar la consulta
    $stmt->bind_param("s", $valorAportado);
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Obtener la primera fila de resultados como un arreglo asociativo
        $row = $result->fetch_array();
        return $row[$datoSolicitado]; // Retornar el valor específico solicitado
    } else {
        // Si no se encontraron resultados, retornar un valor nulo o manejar el error según sea necesario
        return null;
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conexion->close();
}

function getRowBy($tabla, $campoEsIgualA, $valorAportado)
{
    $conexion = connectDB();

    // Escapar el valor para prevenir inyección SQL
    $valor = mysqli_real_escape_string($conexion, $valorAportado);

    // Construir la consulta SQL utilizando consultas preparadas para mayor seguridad
    $sql = 'SELECT * FROM ' . $tabla . ' WHERE ' . $campoEsIgualA . ' = ?';

    // Preparar la consulta
    $stmt = $conexion->prepare($sql);

    // Vincular el parámetro y ejecutar la consulta
    $stmt->bind_param("s", $valorAportado);
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Obtener la primera fila de resultados como un arreglo asociativo
        $row = $result->fetch_array();
        return $row; // Retornar
    } else {
        // Si no se encontraron resultados, retornar un valor nulo o manejar el error según sea necesario
        return null;
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conexion->close();
}


function getArrayEmpresas()
{
    $conexion = connectDB();
    $sql = "SELECT id, name FROM empresas;";
    $result = $conexion->query($sql);
    $empresas = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $empresas[] = $row;
        }
    }
    return $empresas;
}

function getArrayEstados()
{
    $conexion = connectDB();
    $sql = "SELECT id, name FROM estados;";
    $result = $conexion->query($sql);
    $estados = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $estados[] = $row;
        }
    }
    return $estados;
}

function getArrayEmpresasCliente()
{
    $conexion = connectDB();
    $sql = "SELECT id, name FROM empresas WHERE cif <> 'B42619684'";
    $result = $conexion->query($sql);
    $empresas = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $empresas[] = $row;
        }
    }
    return $empresas;
}

function getArrayEmpleados()
{
    $conexion = connectDB();
    global $idValbea;
    $sql = "SELECT id, name FROM users WHERE empresaID = '" . $idValbea . "';";
    $result = $conexion->query($sql);
    $empleados = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $empleados[] = $row;
        }
    }
    return $empleados;
}

function insertarLog($accion, $conn)
{
    global $userName;
    // Obtener la fecha y hora actual
    $fechaHora = date("Y-m-d H:i:s");
    // Obtener el usuario de la sesión

    // Preparar la consulta SQL
    $sql = "INSERT INTO log (datetime, user, accion) VALUES (?, ?, ?)";
    // Preparar la declaración
    $stmt = $conn->prepare($sql);
    // Vincular parámetros
    $stmt->bind_param("sss", $fechaHora, $userName, $accion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
    } else {
        echo "Error al insertar el registro de log: " . $conn->error;
    }

    // Cerrar la declaración
    $stmt->close();
}

function generarID()
{
    $caracteres = '123456789';
    $caracteres2 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud = 4;
    $id = '';
    for ($i = 0; $i < $longitud; $i++) {
        $id .= $caracteres2[rand(0, strlen($caracteres2) - 1)];
    }
    for ($i = 0; $i < $longitud; $i++) {
        $id .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $id;
}

function servicioIdEnUso($id, $conn)
{
    $sql = "SELECT id FROM servicios WHERE id = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return true; // El ID está en uso
    } else {
        return false; // El ID no está en uso
    }
}

function notificacion($mensaje)
{
    echo '<script>document.getElementById("notificacion").innerText = "' . $mensaje . '";</script>';
}


// CONFIG

function actualizarEstadosServicios()
{
    /*
    1 Sin Asignar
    2 Asignado
    3 En ruta
    4 Entregado
    5 Aplazado
    6 Rechazado
    7 Cancelado
    */

    $conexion = connectDB();
    $fechaHoy = date("Y-m-d");


    // Sentencia SQL para actualizar el estado a 3 si el estado es 2 y la fechaServicio es igual a la fecha de hoy (ASIGNADO > EN RUTA)
    $sqlActualizarEstado3 = $conexion->prepare("UPDATE services SET estado = 3 WHERE estado = 2 AND fechaServicio = '$fechaHoy';");
    $sqlActualizarEstado3->execute();
    $sqlActualizarEstado3->close();

    // Sentencia SQL para actualizar el estado a 7 si el estado es 3 y la fechaServicio es anterior a la fecha de hoy (EN RUTA > CANCELADO)
    $sqlActualizarEstado7 = $conexion->prepare("UPDATE services SET estado = 7 WHERE estado = 3 AND fechaServicio < '$fechaHoy';");
    $sqlActualizarEstado7->execute();
    $sqlActualizarEstado7->close();

    // Sentencia SQL para actualizar el estado a 7 si el estado es 2 y la fechaServicio es anterior a la fecha de hoy (EN RUTA > CANCELADO)
    $sqlActualizarEstado7 = $conexion->prepare("UPDATE services SET estado = 7 WHERE estado = 2 AND fechaServicio < '$fechaHoy';");
    $sqlActualizarEstado7->execute();
    $sqlActualizarEstado7->close();

    // Sentencia SQL para actualizar el estado a 7 si el estado es 1 y la fechaServicio es anterior a la fecha de hoy (SIN ASIGNAR > CANCELADO)
    $sqlActualizarEstado7 = $conexion->prepare("UPDATE services SET estado = 7 WHERE estado = 1 AND fechaServicio < '$fechaHoy';");
    $sqlActualizarEstado7->execute();
    $sqlActualizarEstado7->close();

    // Pasar a SIN ASIGNAR si no está asignado ni APLAZADO ni RECHAZADO ni CANCELADO
    $sqlActualizarEstado1 = $conexion->prepare("UPDATE services SET estado = 1 WHERE estado != 1 AND estado != 5 AND estado != 6 AND estado != 7 AND asignadoA = 0;");
    $sqlActualizarEstado1->execute();
    $sqlActualizarEstado1->close();

    // Cerrar la conexión
    $conexion->close();
}

function actualizarSinAsignarAsignado()
{
    /*
    1 Sin Asignar
    2 Asignado
    */

    $conexion = connectDB();

    $sqlActualizarEstado = $conexion->prepare("UPDATE services SET estado = 2 WHERE estado = 1 AND asignadoA != 0;");
    $sqlActualizarEstado->execute();
    $sqlActualizarEstado->close();

    $conexion->close();
}

function eliminarArchivosAntiguos()
{
    $directorio = '../valbeadocs/';

    // Conectar a la base de datos
    $conexion = connectDB();

    // Calcular la fecha límite hace 40 días
    $fecha_limite = date('Y-m-d', strtotime('-40 days'));

    // Consultar archivos cuya fecha sea anterior a hace 40 días
    $consulta = $conexion->prepare("SELECT nombre_archivo FROM archivos WHERE date < ?");
    $consulta->bind_param("s", $fecha_limite);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Eliminar archivos del directorio y registros de la base de datos
    while ($fila = $resultado->fetch_assoc()) {
        $nombre_archivo = $fila['nombre_archivo'];
        $ruta_archivo = $directorio . "/" . $nombre_archivo;
        if (file_exists($ruta_archivo)) {
            unlink($ruta_archivo);
        }
    }
    $consulta->close();

    // Eliminar registros de la base de datos
    $stmt_delete = $conexion->prepare("DELETE FROM archivos WHERE date < ?");
    $stmt_delete->bind_param("s", $fecha_limite);
    $stmt_delete->execute();
    $stmt_delete->close();

    // Cerrar conexión a la base de datos
    $conexion->close();
}

function borrarLogAntiguo() {
    $conexion = connectDB();
    $fecha_limite = date('Y-m-d', strtotime('-40 days'));

    // Eliminar registros de la base de datos
    $stmt_delete = $conexion->prepare("DELETE FROM log WHERE datetime < ?");
    $stmt_delete->bind_param("s", $fecha_limite);
    $stmt_delete->execute();
    $stmt_delete->close();

    // Cerrar conexión a la base de datos
    $conexion->close();
}