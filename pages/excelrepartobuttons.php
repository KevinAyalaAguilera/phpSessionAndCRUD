<script>
	document.getElementById("descargarCSV").addEventListener("click", function() {
		// Realizar la solicitud AJAX al servidor PHP
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "generarCSV.php", true); // Ruta al archivo PHP que generará el CSV
		xhr.responseType = "blob"; // Tipo de respuesta esperada: archivo binario (Blob)

		xhr.onload = function() {
			if (this.status === 200) {
				// Crear un enlace para descargar el archivo CSV
				var blob = new Blob([this.response], {
					type: "text/csv"
				}); // Crear un objeto Blob con el contenido CSV
				var url = window.URL.createObjectURL(blob); // Crear una URL del objeto Blob
				var a = document.createElement("a"); // Crear un elemento <a> para el enlace de descarga
				a.href = url;
				a.download = "datos.csv"; // Nombre del archivo CSV
				document.body.appendChild(a); // Agregar el enlace al cuerpo del documento HTML
				a.click(); // Simular el clic en el enlace para iniciar la descarga del archivo
				window.URL.revokeObjectURL(url); // Liberar la URL creada
			} else {
				console.error("Error al descargar el archivo CSV.");
			}
		};

		xhr.onerror = function() {
			console.error("Error de red al intentar descargar el archivo CSV.");
		};

		xhr.send(); // Enviar la solicitud AJAX al servidor PHP
	});

    document.getElementById("descargarReparto").addEventListener("click", function() {
		// Realizar la solicitud AJAX al servidor PHP
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "generarCSVReparto.php", true); // Ruta al archivo PHP que generará el CSV
		xhr.responseType = "blob"; // Tipo de respuesta esperada: archivo binario (Blob)

		xhr.onload = function() {
			if (this.status === 200) {
				// Crear un enlace para descargar el archivo CSV
				var blob = new Blob([this.response], {
					type: "text/csv"
				}); // Crear un objeto Blob con el contenido CSV
				var url = window.URL.createObjectURL(blob); // Crear una URL del objeto Blob
				var a = document.createElement("a"); // Crear un elemento <a> para el enlace de descarga
				a.href = url;
				a.download = "listado.csv"; // Nombre del archivo CSV
				document.body.appendChild(a); // Agregar el enlace al cuerpo del documento HTML
				a.click(); // Simular el clic en el enlace para iniciar la descarga del archivo
				window.URL.revokeObjectURL(url); // Liberar la URL creada
			} else {
				console.error("Error al descargar el archivo CSV.");
			}
		};

		xhr.onerror = function() {
			console.error("Error de red al intentar descargar el archivo CSV.");
		};

		xhr.send(); // Enviar la solicitud AJAX al servidor PHP
	});
</script>