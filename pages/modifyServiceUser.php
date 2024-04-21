<?php
include_once "../controller/controller.php";
if (!isset($userROL)) {
    header("location: ../index.php");
    exit();
}
if (!isset($service)) {
    header("location: ../index.php");
    exit();
}

modifyServiceByUser();
echo '<form method="POST" class="serviceModify grid">';
echo '<input type="hidden" name="id" value="' . $service['id'] . '">';
echo '<input type="hidden" name="change" value="1">';

// Nombre
echo '<label class="soloDesktop addedMargin" for="nombreCliente"><b>Nombre Cliente:</b></label>';
echo '<label for="nombreCliente">' . $service['nombreCliente'] . '</label>';

// Calle
echo '<label class="soloDesktop addedMargin" for="calleCliente"><b>Calle Cliente:</b></label>';
echo '<label for="calleCliente">' . $service['calleCliente'] . '</label>';

// Población
echo '<label class="soloDesktop addedMargin" for="poblacionCliente"><b>Población Cliente:</b></label>';
echo '<label for="poblacionCliente">' . $service['poblacionCliente'] . '</label>';

// Teléfono
echo '<label class="soloDesktop addedMargin" for="telefonoCliente"><b>Teléfono Cliente:</b></label>';
echo '<label for="telefonoCliente">' . $service['telefonoCliente'] . '</label>';

// Fecha
echo '<label class="soloDesktop addedMargin" for="fechaServicio"><b>Fecha de Servicio:</b></label>';
echo '<label id="fechaServicio" name="fechaServicio" value="' . $service['fechaServicio'] . '">' . date("d-m-Y", strtotime($service['fechaServicio'])) . '</label>';

// Hora Realizado
echo '<input type="hidden" id="horaRealizacion" name="horaRealizacion" value="' . $service['horaRealizacion'] . '">';

// Empresa
echo '<label class="soloDesktop addedMargin" for="idEmpresa"><b>Empresa:</b></label>';
echo '<label value="' . $service['idEmpresa'] . '">' . getBy('name', 'empresas', 'id', $service['idEmpresa']) . '</label>';

// Estado
echo '<input type="hidden" name="estado" value="' . $service['estado'] . '">';
echo '<label for="estado" class="addedMargin"><b>Estado:</b></label>';
echo '<label id="estado" name="estado" value="' . $service['estado'] . '">' . getBy('name', 'estados', 'id', $service['estado']) . '</label>';

// User

// Incidencia
echo '<input type="hidden" id="incidencia" name="incidencia" ' . (($service['incidencia'] == 1) ? 'checked' : '') . '>';

// Nota Interna

// Nota Externa
echo '<label for="comentarioExterno" class="addedMargin"><b>Nota:</b></label>';
echo '<input type="text" class="btn input" id="comentarioExterno" name="comentarioExterno" value="' . $service['comentarioExterno'] . '">';

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
echo '<input type="button" value="Entregar" onclick="changeEstadoOculto(4)" class="btn button serviceModifySubmit addedMarginTop bootstrap icongeneric check">';

// Aplazar
echo '<input type="button" onclick="window.location.href = \'aplazarService.php?service=' . $service['id'] . '\'" value="Aplazar" class="btn button serviceModifySubmit addedMarginTop bootstrap icongeneric delay">';

// Rechazar
echo '<input type="button" value="Rechazar" onclick="changeEstadoOculto(6)" class="btn button serviceModifySubmit addedMarginTop bootstrap icongeneric cancel">';

echo '<input type="submit" value="Actualizar" id="submitButton" class="btn button serviceModifySubmit admin addedMarginTop">';
echo '<p id="notificacion"></p>';
echo '</form>';

echo '<div id="modifyService-bu" class="modifyService-documentUpload">';
echo '<div class="separadorInvisible"></div>';

// Subir archivo
echo '<form id="uploadForm1" enctype="multipart/form-data" class="lineasFilter serviceModify uploadForm">';
echo '<input type="hidden" name="change" value="0">';
echo '<input type="hidden" name="id" value="' . $service["id"] . '">';
echo '<input class="inputfile" type="file" id="fileInput" name="file">';
echo '<label class="btn button bootstrap icongeneric upload" for="fileInput" data-multiple-caption="{count} files selected" multiple >Subir archivo</label>';
echo '<button id="submitBtnOk" class="btn button" style="display: none;" type="submit">Subir archivo</button>';
echo '</form>';

// Subir incidencia
echo '<form id="uploadForm2" enctype="multipart/form-data" class="lineasFilter serviceModify uploadForm">';
echo '<input type="hidden" name="inc" value="1">';
echo '<input type="hidden" name="change" value="0">';
echo '<input type="hidden" name="id" value="' . $service["id"] . '">';
echo '<input class="inputfile" type="file" id="fileInput2" name="file">';
echo '<label class="btn button inc bootstrap icongeneric upload2" for="fileInput2" data-multiple-caption="{count} files selected" multiple >Subir incidencia</label>';
echo '<button id="submitBtnInc" class="btn button" style="display: none;" type="submit">Subir incidencia</button>';
echo '</form>';

echo '</div>';
