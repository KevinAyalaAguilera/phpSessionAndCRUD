<?php
include_once "../controller/controller.php";
if (!isset($userROL)) {
    header("location: ../index.php");
    exit();
}

modifyService();
echo '<form method="POST" class="serviceModify grid">';
echo '<input type="hidden" name="id" value="' . $service['id'] . '">';

// Nombre
echo '<label class="soloDesktop addedMargin" for="nombreCliente"><b>Nombre Cliente:</b></label>';
echo '<input class="btn input" type="text" id="nombreCliente" name="nombreCliente" value="' . $service['nombreCliente'] . '">';

// Calle
echo '<label class="soloDesktop addedMargin" for="calleCliente"><b>Calle Cliente:</b></label>';
echo '<input class="btn input" type="text" id="calleCliente" name="calleCliente" value="' . $service['calleCliente'] . '">';

// Población
echo '<label class="soloDesktop addedMargin" for="poblacionCliente"><b>Población Cliente:</b></label>';
echo '<input class="btn input" type="text" id="poblacionCliente" name="poblacionCliente" value="' . $service['poblacionCliente'] . '">';

// Teléfono
echo '<label class="soloDesktop addedMargin" for="telefonoCliente"><b>Teléfono Cliente:</b></label>';
echo '<input class="btn input" type="text" id="telefonoCliente" name="telefonoCliente" value="' . $service['telefonoCliente'] . '">';

// Fecha
echo '<label class="soloDesktop addedMargin" for="fechaServicio"><b>Fecha de Servicio:</b></label>';
echo '<label id="fechaServicio" name="fechaServicio" value="' . $service['fechaServicio'] . '">' . date("d-m-Y", strtotime($service['fechaServicio'])) . '</label>';

// Hora Relizado
echo '<label class="soloDesktop addedMargin" for="horaRealizacion"><b>Hora Realizado:</b></label>';
echo '<input type="hidden" id="horaRealizacion" name="horaRealizacion" value="' . $service['horaRealizacion'] . '">';
echo '<label>' . $service['horaRealizacion'] . '</label>';

// Empresa
echo '<label class="soloDesktop addedMargin" for="idEmpresa"><b>Empresa:</b></label>';
$empresas = getArrayEmpresasCliente();
echo '<select  class="btn input admin" id="idEmpresa" name="idEmpresa">';
echo '<option value="' . $service['idEmpresa'] . '">' . getBy('name', 'empresas', 'id', $service['idEmpresa']) . '</option>';
for ($i = 0; $i < count($empresas); $i++) {
    echo '<option value="' . $empresas[$i]['id'] . '">' . $empresas[$i]['name'] . '</option>';
}
echo '</select>';

// Estado
echo '<label class="soloDesktop addedMargin" for="estado"><b>Estado:</b></label>';
echo '<select  class="btn input" name="estado" placeholder="Estado">';
echo '<option value="' . $service['estado'] . '">' . getBy('name', 'estados', 'id', $service['estado']) . '</option>';
$estados = getArrayEstados();
for ($i = 0; $i < count($estados); $i++) {
    echo '<option value="' . $estados[$i]['id'] . '">' . $estados[$i]['name'] . '</option>';
}
echo '</select>';

// User
echo '<label class="soloDesktop addedMargin" for="asignadoA"><b>Asignado a:</b></label>';
echo '<select  class="btn input admin" id="asignadoA" name="asignadoA">';
echo '<option value="' . $service['asignadoA'] . '">' . getBy('name', 'users', 'id', ($service['asignadoA'])) . '</option>';
$empleados = getArrayEmpleados();
for ($i = 0; $i < count($empleados); $i++) {
    echo '<option value="' . $empleados[$i]['id'] . '">' . $empleados[$i]['name'] . '</option>';
}
echo '</select>';

// Incidencia
echo '<label for="incidencia" class="addedMargin"><b>Incidencia:</b></label>';
echo '<input class="checkbox" type="checkbox" id="incidencia" name="incidencia" ' . (($service['incidencia'] == 1) ? 'checked' : '') . '>';

// Nota Interna
echo '<label for="comentarioInterno" class="addedMargin"><b>Nota interna:</b></label>';
echo '<input class="btn input" type="text" id="comentarioInterno" name="comentarioInterno" value="' . $service['comentarioInterno'] . '">';

// Nota Externa
echo '<label for="comentarioExterno" class="addedMargin"><b>Nota externa:</b></label>';
echo '<input class="btn input" type="text" id="comentarioExterno" name="comentarioExterno" value="' . $service['comentarioExterno'] . '">';

echo '<div class="separadorInvisible"></div>';
echo '<div class="separadorInvisible"></div>';
echo '<div class="separadorInvisible"></div>';

echo '<div class="separadorInvisible"></div>';
echo '<div class="separadorInvisible"></div>';
echo '<div class="separadorInvisible"></div>';
echo '<div class="separadorInvisible"></div>';

// Controlador de estado oculto
echo '<input type="hidden" name="BTNestado" id="BTNestado" value="0">';
echo '<script>';
echo 'function changeEstadoOculto(estado) {';
echo '    document.getElementById("BTNestado").value = estado;';
echo '    document.getElementById("horaRealizacion").value = "'. date("H:i:s") .'";';
echo '    document.getElementById("submitButton").click();';
echo '}';
echo '</script>';

// Entregar
echo '<input type="button" value="Entregar" onclick="changeEstadoOculto(4)" class="btn button serviceModifySubmit addedMarginTop">';

// Aplazar
echo '<input type="button" onclick="window.location.href = \'aplazarService.php?service=' . $service['id'] . '\'" value="Aplazar" class="btn button serviceModifySubmit addedMarginTop">';

// Rechazar
echo '<input type="button" value="Rechazar" onclick="changeEstadoOculto(6)" class="btn button serviceModifySubmit addedMarginTop">';

echo '<input type="submit" value="Actualizar" id="submitButton" class="btn button serviceModifySubmit admin addedMarginTop">';
echo '</form>';

echo '<div id="modifyService-bu" class="modifyService-documentUpload">';
echo '<div class="separadorInvisible"></div>';

// Subir archivo
echo '<form id="uploadForm1" enctype="multipart/form-data" class="lineasFilter serviceModify uploadForm">';
echo '<input type="hidden" name="change" value="0">';
echo '<input type="hidden" name="id" value="' . $service["id"] . '">';
echo '<input class="inputfile" type="file" id="fileInput" name="file">';
echo '<label class="btn button" for="fileInput" data-multiple-caption="{count} files selected" multiple >Subir archivo</label>';
echo '<button id="submitBtnOk" class="btn button" style="display: none;" type="submit">Subir archivo</button>';
echo '</form>';

// Subir incidencia
echo '<form id="uploadForm2" enctype="multipart/form-data" class="lineasFilter serviceModify uploadForm">';
echo '<input type="hidden" name="inc" value="1">';
echo '<input type="hidden" name="change" value="0">';
echo '<input type="hidden" name="id" value="' . $service["id"] . '">';
echo '<input class="inputfile" type="file" id="fileInput2" name="file">';
echo '<label class="btn button inc" for="fileInput2" data-multiple-caption="{count} files selected" multiple >Subir incidencia</label>';
echo '<button id="submitBtnInc" class="btn button" style="display: none;" type="submit">Subir incidencia</button>';
echo '</form>';

echo '</div>';
