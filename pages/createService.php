<?php
include_once "../controller/controller.php";
if (isset($_SESSION["rol"])) {
    include_once "./header.php";
} else {
    header("location: ../index.php");
    exit();
}
?>
<form method="post" class="lineasFilter" style="display: flex; flex-direction: column">
    <div style="display: flex; flex-direction: row">
        <?php if ($userEmpresaID == $idValbea) : ?>
            <select class="admin btn input" name="empresa" placeholder="Empresa" required>
                <?php if (isset($_POST['create'])) : ?>
                    <option value="<?php echo $_POST['empresa']; ?>"><?php echo getBy('name', 'empresas', 'id', $_POST['empresa']); ?></option>
                <?php else : ?>
                    <option value="">Empresa</option>
                <?php endif; ?>
                <?php
                $empresas = getArrayEmpresas();
                foreach ($empresas as $empresa) :
                ?>
                    <option value="<?php echo $empresa['id']; ?>"><?php echo $empresa['name']; ?></option>
                <?php endforeach; ?>
            </select>
        <?php else : ?>
            <input type="hidden" name="empresa" value="<?php echo $userEmpresaID; ?>">
        <?php endif; ?>
        <?php if (isset($_POST["create"])) : ?>
            <input type="hidden" name="date" value="<?php echo $_POST["date"]; ?>">
        <?php else : ?>
            <input type="date" name="date" class="btn input" required>
        <?php endif; ?>
        <button type="button" id="addServiceBtn" class="btn button">Agregar otro servicio</button>
        <input type="submit" value="Crear" class="btn button" name="create">
    </div>
    <p id="notificacion"></p>
    <div class="service-inputs">
        <input type="text" placeholder="Nombre" name="services[0][name]" class="btn input" required>
        <input type="text" placeholder="Calle" class="calle btn input" name="services[0][calle]" required>
        <input type="text" placeholder="Población" class="btn input" name="services[0][poblacion]" required>
        <input type="text" placeholder="Teléfono" class="btn input" name="services[0][telf]" required>
        <input type="text" placeholder="Nota" class="btn input" name="services[0][nota]">
    </div>
</form>
<?php
createService();
include_once "./footer.php";
?>
<script>
    document.getElementById("header-btn-cservice").classList.add("header-btn-selected");

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById("addServiceBtn").addEventListener('click', function() {
            var servicesContainer = document.querySelector('.lineasFilter');
            var lastServiceInputs = servicesContainer.querySelector('.service-inputs:last-child');
            var newServiceInputs = lastServiceInputs.cloneNode(true);

            // Obtener el índice del último servicio y calcular el índice del siguiente servicio
            var lastIndex = parseInt(lastServiceInputs.querySelector('input[name^="services["]').getAttribute('name').match(/\[(\d+)\]/)[1]);
            var newIndex = lastIndex + 1;

            // Actualizar los nombres de los atributos de los elementos clonados
            newServiceInputs.querySelectorAll('input').forEach(function(input) {
                var nameAttr = input.getAttribute('name');
                if (nameAttr) {
                    input.setAttribute('name', nameAttr.replace(/\[\d+\]/, '[' + newIndex + ']'));
                }
            });

            servicesContainer.appendChild(newServiceInputs);
        });
    });

    document.getElementById("header-btn-cservice").classList.add("header-btn-selected");

    // PEGADO DE DATOS DESDE EXCEL
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.lineasFilter').addEventListener('paste', function(e) {
            var clipboardData, pastedData;
            // Accede a los datos del portapapeles
            clipboardData = e.clipboardData || window.clipboardData;
            pastedData = clipboardData.getData('Text');
            // Divide los datos pegados en filas
            var rows = pastedData.split('\n');
            // Obtener el contenedor de servicios
            var servicesContainer = document.querySelector('.lineasFilter');

            // Iterar sobre las filas de datos pegados
            for (var i = 0; i < rows.length; i++) {
                // Obtener las columnas de cada fila
                var columns = rows[i].split('\t');

                // Si hay suficientes columnas para completar los campos del formulario
                if (columns.length >= 5) {
                    // Obtener el conjunto de campos de servicio correspondiente a esta fila
                    var serviceInputs = servicesContainer.querySelectorAll('.service-inputs')[i];
                    var inputs = serviceInputs.querySelectorAll('input');

                    // Actualizar los valores de los campos con los datos correspondientes de cada columna
                    inputs[0].value = columns[0]; // Nombre
                    inputs[1].value = columns[1]; // Calle
                    inputs[2].value = columns[2]; // Población
                    inputs[3].value = columns[3]; // Teléfono
                    inputs[4].value = columns[4]; // Nota
                } else {
                    
                }
            }
            e.preventDefault();
        });
    });
</script>

</body>