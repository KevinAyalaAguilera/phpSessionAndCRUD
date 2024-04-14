<?php
include_once "../controller/controller.php";
if (!isset($userROL)) {
    header("location: ../index.php");
    exit();
}

modifyServiceByClient();
echo '<form method="POST" class="serviceModify grid">';
echo '<input type="hidden" name="id" value="' . $service['id'] . '">';

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

// Hora Relizado
echo '<label class="soloDesktop addedMargin" for="horaRealizacion"><b>Hora Realizado:</b></label>';
echo '<label id="horaRealizacion" name="horaRealizacion" value="' . $service['horaRealizacion'] . '">' . $service['horaRealizacion'] . '</label>';

// Estado
echo '<label class="soloDesktop addedMargin" for="estado"><b>Estado:</b></label>';
echo '<label id="estado" name="estado" value="' . $service['estado'] . '">' . getBy('name', 'estados', 'id', $service['estado']) . '</label>';

// User
echo '<label class="soloDesktop addedMargin" for="asignadoA"><b>Asignado a:</b></label>';
echo '<label id="asignadoA" name="asignadoA" value="' . $service['asignadoA'] . '">' . getBy('name', 'users', 'id', ($service['asignadoA'])) . '</label>';

// Incidencia
if ($service['incidencia'] == 1) {
    echo '<label class="soloDesktop addedMargin" for="incidencia"><b>Incidencia:</b></label>';
    echo '<label class="soloDesktop btn-icon" for="incidencia"><b>Sí</b></label>';
} else {
    echo '<label class="soloDesktop addedMargin" for="incidencia"><b>Incidencia:</b></label>';
    echo '<label class="soloDesktop" for="incidencia"><b>No</b></label>';
}

// Nota Externa
echo '<label for="comentarioExterno" class="addedMargin"><b>Nota:</b></label>';
echo '<input class="btn input" type="text" id="comentarioExterno" name="comentarioExterno" value="' . $service['comentarioExterno'] . '">';
echo '<div class="separadorInvisible"></div>';
echo '<div class="separadorInvisible"></div>';
echo '<div class="separadorInvisible"></div>';
echo '<div class="separadorInvisible"></div>';

echo '<div class="separadorInvisible"></div>';
echo '<div class="separadorInvisible"></div>';
echo '<input type="submit" value="Actualizar" class="btn button serviceModifySubmit admin addedMarginTop">';
echo '<p id="notificacion"></p>';
echo '</form>';

echo '<div id="modifyService-bu" class="modifyService-documentUpload">';
echo '<div class="separadorInvisible"></div>';
echo '<div class="separadorInvisible"></div>';


// Subir archivo
echo '<form id="uploadForm1" enctype="multipart/form-data" class="lineasFilter serviceModify uploadForm">';
echo '<input type="hidden" name="change" value="0">';
echo '<input type="hidden" name="id" value="' . $service["id"] . '">';
echo '<input class="inputfile" type="file" id="fileInput" name="file">';
echo '<label class="btn button bootstrap icongeneric upload" for="fileInput" data-multiple-caption="{count} files selected" multiple >Subir archivo</label>';
echo '<button id="submitBtnOk" class="btn button" style="display: none;" type="submit">Subir archivo</button>';
echo '</form>';

echo '</div>';
