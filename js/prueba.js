
function escribirTecla() {
    // Recuperar el div donde se escribirán los resultados
    var edicion = document.getElementById('edicion');

    // Limpiar el contenido actual del div
    edicion.innerHTML = "";

    // Recuperar el texto actual ingresado en el input
    var inputValue = document.getElementById('buscar_ci_clientes').value;

    // Detectar si el input está vacío
    if (!inputValue.trim()) {
        console.log("El campo está vacío, no se realizará la búsqueda.");
        return; // No hacer la búsqueda si el campo está vacío
    }

    console.log("Texto ingresado:", inputValue);

    // Llamar a AJAX para la consulta en la base de datos
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "includes/clientes_consulta.php?texto=" + encodeURIComponent(inputValue), true);

    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            try {
                // Parsear la respuesta como JSON
                var resultados = JSON.parse(ajax.responseText);

                // Iterar sobre los resultados y crear los divs
                resultados.forEach(function (cliente) {
                    var nuevoDiv = document.createElement('div');
                    nuevoDiv.style.width = "100%"; // Ancho completo
                    nuevoDiv.style.padding = "10px"; // Espaciado interno
                    nuevoDiv.style.marginBottom = "5px"; // Separación entre elementos
                    nuevoDiv.style.backgroundColor = "#08e6d1"; // Fondo dinámico
                    nuevoDiv.style.color = "black"; // Letras negras
                    nuevoDiv.style.fontFamily = "'Arial', sans-serif"; // Tipografía bonita
                    nuevoDiv.style.fontSize = "16px"; // Tamaño de fuente legible
                    nuevoDiv.style.borderRadius = "5px"; // Bordes redondeados
                    nuevoDiv.style.boxShadow = "0 2px 5px rgba(0, 0, 0, 0.1)"; // Sombra suave

                    nuevoDiv.innerText = ` ${cliente.ci}`; // Mostrar CI en el div
                    nuevoDiv.style.cursor = "pointer"; // Agregar un puntero para indicar clickeable

                    // Agregar el evento onclick
                    nuevoDiv.setAttribute(
                        "onclick",
                        `seleccionadoPrediccion(${cliente.id_cliente}, '${cliente.ci}')`
                    );

                    // Agregar el nuevo div al contenedor
                    edicion.appendChild(nuevoDiv);
                });
            } catch (e) {
                console.error("Error procesando la respuesta:", e);
            }
        }
    };

    ajax.send(); // Enviar la solicitud AJAX
}


function seleccionadoPrediccion(id_cliente, ci) {
    // Mostrar los valores seleccionados en la consola (opcional)
    console.log("Cliente seleccionado:");
    console.log("ID:", id_cliente);
    console.log("CI:", ci);

    document.getElementById('buscar_ci_clientes').value = ci;  // Actualizar el valor del input
    buscarCliente()
    // Aquí puedes agregar cualquier lógica adicional, como enviar estos datos a un servidor o realizar una nueva consulta
}



function buscarCliente() {
    var buscar_ci = document.getElementById('buscar_ci_clientes').value.trim();
    var edicion = document.getElementById('edicion');

    // Limpiar el contenido actual del div
    edicion.innerHTML = "";

    // Mostrar el texto ingresado en la consola
    console.log("Buscando cliente con CI: " + buscar_ci);

    // Realizar la solicitud AJAX
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "includes/clientes_consulta.php?ci=" + buscar_ci, true);

    // Definir la función que se ejecutará cuando el estado de la solicitud cambie
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var clientes = JSON.parse(ajax.responseText);

            if (clientes.length === 0) {
                // Si no hay resultados, mostrar mensaje en rojo
                document.getElementById('tabla_clientes_contenedor').innerHTML = `
                    <div style="color: red; font-size: 48px; text-align: center; font-family: 'Wild Wolf'; padding: 50px;">
                        Ese cliente no existe
                    </div>
                `;
                return; // Salir de la función si no hay clientes
            }

            // Construir la tabla si hay resultados
            var html = `
                <table id="tabla_clientes">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>CI</th>
                            <th>Fecha de Registro</th>
                            <th>Días Restantes</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>`;

            // Iterar sobre cada cliente y generar la fila HTML
            clientes.forEach(function (cliente) {
                html += `<tr>
                    <td>${cliente.nombre}</td>
                    <td>${cliente.telefono}</td>
                    <td>${cliente.ci}</td>
                    <td>${cliente.fecha_registro}</td>
                    <td>${cliente.dias_restantes}</td>
                    <td class="acciones">
                        <button class="accion_boton" onclick="cargarFormularioEdicion(${cliente.id_cliente})">
                            <img src="img/pagina/editar.png" alt="Editar" style="width: 24px; height: 24px;">
                        </button>
                        <button class="accion_boton" onclick="eliminarUsuario(${cliente.id_cliente})">
                            <img src="img/pagina/eliminar.png" alt="Eliminar" style="width: 24px; height: 24px;">
                        </button>
                    </td>
                </tr>`;
            });

            html += `</tbody></table>`;
            document.getElementById('tabla_clientes_contenedor').innerHTML = html;  // Insertar el contenido generado
        }
    };

    ajax.send(); // Enviar la solicitud AJAX
}