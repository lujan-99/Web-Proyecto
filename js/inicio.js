var seleccionado = document.getElementById("inicio");  // Variable para almacenar el elemento seleccionado
var filtro = null;
function cargar(url) {
    var ajax = new XMLHttpRequest();  // Crear el objeto XMLHttpRequest
    console.log("Cargando página: " + url);
    ajax.open("GET", "paginas/" + url, true);  // Modificar la ruta para salir de la carpeta actual y entrar en 'paginas'
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Cuando la respuesta esté lista y sea exitosa, insertar el contenido en el div
            document.getElementById('Contenido_pagian').innerHTML = ajax.responseText;
        }
    };
    ajax.send();  // Enviar la solicitud AJAX
}

// Función que se ejecuta cuando el mouse pasa sobre el div
function hover(element) {
    if (element !== seleccionado) {  // Solo aplica hover si no está seleccionado
        element.style.backgroundColor = "var(--color-cian-claro)";  // Cambia el color de fondo al pasar el mouse
        element.style.color = "var(--color-blanco)";  // Cambia el color del texto
    }
}

// Función que se ejecuta cuando el mouse sale del div
function unhover(element) {
    if (element !== seleccionado) {  // Solo restaura el estilo si no está seleccionado
        element.style.backgroundColor = "";  // Restaura el color de fondo original
        element.style.color = "";  // Restaura el color del texto original
    }
}

// Función que selecciona el elemento cuando se hace clic
function seleccionar(element) {
    // Deselecciona el elemento previamente seleccionado
    if (seleccionado !== null) {
        seleccionado.style.backgroundColor = "";  // Restaura el fondo original
        seleccionado.style.color = "";  // Restaura el color del texto original
    }

    // Selecciona el nuevo elemento
    element.style.backgroundColor = "var(--color-cian-claro)";  // Color de fondo para el elemento seleccionado
    element.style.color = "var(--color-negro)";  // Cambia el color del texto


    // Actualiza la variable 'seleccionado' para almacenar el nuevo elemento seleccionado
    seleccionado = element;
}

// Selecciona el elemento 'inicio' por defecto al cargar la página
seleccionar(seleccionado);

function mostrarClientes() {
    var contenido = document.getElementById('tabla_clientes_contenedor');
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "includes/clientes_consulta.php", true);  // Llamada a clientes_consulta.php
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var clientes = JSON.parse(ajax.responseText);
            var html = `

                <table id="tabla_clientes">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>CI</th>
                            <th>Fecha de Registro</th>
                            <th>Días Restantes</th>
                            <th>Estado</th>
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
                    <td>
                        <input 
                            type="checkbox" 
                            ${cliente.estado === "activo" ? "checked" : ""} 
                            onchange="activarCliente(${cliente.id_cliente})"
                        >
                    </td>
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
            contenido.innerHTML = html;  // Insertar el contenido generado en el div `lado_derecho_clientes`
        }
    };
    ajax.send();
}



function cargarFormularioEdicion(id) {
    console.log("Editar cliente con ID " + id);
    // Hacer una petición AJAX para obtener el formulario de edición
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "includes/clientes_editar.php?id=" + id, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Insertar el formulario en un contenedor de la página
            document.getElementById('info_cliente').innerHTML = ajax.responseText;
        }
    };
    ajax.send();
}

function editarCliente() {
    var formulario = document.getElementById("form-editar");
    var parametros = new FormData(formulario);
    var ajax = new XMLHttpRequest() //crea el objetov ajax 
    console.log("Editando cliente...");
    ajax.open("post", "includes/cliente_editado.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            document.getElementById('info_cliente').innerHTML = ajax.responseText;
            mostrarClientes();
        }
    }
    ajax.send(parametros);


}

function eliminarUsuario(id) {

    var confirmacion = confirm("¿Estás seguro de que deseas eliminar este usuario?");
    if (confirmacion) {
        console.log("Eliminar cliente con ID " + id);
        // Hacer una petición AJAX para obtener el formulario de edición
        var ajax = new XMLHttpRequest();
        ajax.open("GET", "includes/cliente_eliminado.php?id=" + id, true);
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {
                // Insertar el formulario en un contenedor de la página
                document.getElementById('info_cliente').innerHTML = ajax.responseText;
                mostrarClientes();
            }
        };
        ajax.send();

    }

}

function escribirTecla(event) {
    // Recuperar el div donde se escribirán los resultados
    var edicion = document.getElementById('edicion');

    // Limpiar el contenido actual del div
    edicion.innerHTML = "";

    // Recuperar el texto actual ingresado en el input
    var inputValue = document.getElementById('buscar_ci_clientes').value;

    // Detectar si se presionó la tecla Enter
    if (event.key === "Enter") {
        console.log("Se presionó Enter, ejecutando buscarCliente().");
        buscarCliente(); // Llamar a la función buscarCliente
        return; // Salir de la función para evitar más procesamiento
    }

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
                    nuevoDiv.style.backgroundColor = "var(--color-cian-pastel)"; // Fondo dinámico
                    nuevoDiv.style.color = "var(--color-negro)"; // Letras negras
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
                            <th>Estado</th>
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
                    <td>
                        <input 
                            type="checkbox" 
                            ${cliente.estado === "activo" ? "checked" : ""} 
                            onchange="activarCliente(${cliente.id_cliente})"
                        >
                    </td>
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

function flitroCliente(numero) {
    seleccionarFiltro(numero);
    if (numero === 4) {
        // Si es 4, entonces mostrar todos los clientes
        mostrarClientes();
    } else if (numero) {
        // Si no es 4, procesar con el filtro
        console.log(numero);
        var ajax = new XMLHttpRequest();
        ajax.open("GET", "includes/clientes_consulta.php?numero=" + numero, true);

        // Definir la función que se ejecutará cuando el estado de la solicitud cambie
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var clientes = JSON.parse(ajax.responseText);
                var html = `
                    <table id="tabla_clientes">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>CI</th>
                                <th>Fecha de Registro</th>
                                <th>Días Restantes</th>
                                <th>Estado</th>
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
                        <td>
                            <input 
                                type="checkbox" 
                                ${cliente.estado === "activo" ? "checked" : ""} 
                                onchange="activarCliente(${cliente.id_cliente})"
                            >
                        </td>
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
        ajax.send();  // Enviar la solicitud AJAX
    }
}

  // Variable para almacenar el filtro seleccionado
function seleccionarFiltro(numero_filtro) {
    // Deselecciona el elemento previamente seleccionado
    if (filtro != null) {
        filtro.style.backgroundColor = "";  // Restaura el fondo original
        filtro.style.color = "";  // Restaura el color del texto original
    }

    var filtro_cuadro = document.getElementById("filtro_" + numero_filtro);  // Concatenar el número con "filtro_"
    
    // Verifica si el filtro_cuadro existe
    if (filtro_cuadro) {
        // Selecciona el nuevo elemento 
        filtro_cuadro.style.backgroundColor = "var(--color-cian-claro)";  // Color de fondo para el elemento seleccionado
        filtro_cuadro.style.color = "var(--color-negro)";  // Cambia el color del texto

        // Actualiza la variable 'filtro' para almacenar el nuevo elemento seleccionado
        filtro = filtro_cuadro;
    } else {
        console.error("Elemento con ID 'filtro_" + numero_filtro + "' no encontrado.");
    }
}

function planSeleccionado() {
    var select = document.getElementById('plan_suscripcion');
    var idPlanSeleccionado = select.value;

    console.log("Plan seleccionado ID:", idPlanSeleccionado);

    // Hacer una solicitud AJAX para obtener los detalles del plan
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "includes/planes_read.php?id_plan=" + idPlanSeleccionado, true);
    
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {
                var response = JSON.parse(ajax.responseText);

                // Verificar si hay un error en la respuesta
                if (response.error) {
                    document.getElementById('detalle_plan').innerHTML = '<p>' + response.error + '</p>';
                } else {
                    // Mostrar los detalles del plan en HTML
                    document.getElementById('detalle_plan').innerHTML = `
                        <div style="padding: 20px;">
    <h3 style="color: var(--color-blanco); font-family: Arial, sans-serif; font-size: 24px; text-align: center;">Detalles del Plan</h3>
    
    <h4 style="color: var(--color-cian-pastel); font-family: Arial, sans-serif; font-size: 18px; margin-bottom: 10px;">
        Nombre del Plan:
        <p style="color: var(--color-blanco); margin: 5px 0;">${response.nombre_plan}</p>
    </h4>
    
    <h4 style="color: var(--color-cian-pastel); font-family: Arial, sans-serif; font-size: 18px; margin-bottom: 10px;">
        Id del Plan:
        <p id="id_plan" style="color: var(--color-blanco); margin: 5px 0;">${response.id_plan}</p>
    </h4>
    
    <h4 style="color: var(--color-cian-pastel); font-family: Arial, sans-serif; font-size: 18px; margin-bottom: 10px;">
        Descripción:
        <p style="color: var(--color-blanco); margin: 5px 0;">${response.descripcion}</p>
    </h4>
    
    <h4 style="color: var(--color-cian-pastel); font-family: Arial, sans-serif; font-size: 18px; margin-bottom: 10px;">
        Precio:
        <p style="color: var(--color-blanco); margin: 5px 0;">Bs${response.precio}</p>
    </h4>
    
    <h4 style="color: var(--color-cian-pastel); font-family: Arial, sans-serif; font-size: 18px; margin-bottom: 10px;">
        Duración:
        <p id="duracion" style="color: var(--color-blanco); margin: 5px 0;">${response.duracion} días </p> 
    </h4>
    
    <select id="tipo_pago" style="padding: 10px; width: 100%; font-family: Arial, sans-serif;">
        <option value="efectivo">Efectivo</option>
        <option value="qr">QR</option>
    </select>
</div>

                    `;
                    document.getElementById('img-plan').innerHTML = `<img src="${response.imagen}" alt="Imagen del plan" style="width: 400px;"></img>`;
                }
            } else {
                console.error("Error en la solicitud AJAX: " + ajax.status);
            }
        }
    };

    ajax.send();
}



function crearCliente() {
    // Recuperar los datos del formulario del cliente
    var nombre = document.getElementById('nombre').value.trim();
    var telefono = document.getElementById('telefono').value.trim();
    var ci = document.getElementById('ci').value.trim();
    var duracion = parseInt(document.getElementById('duracion').innerHTML); // Convertir la duración a entero
    var id_plan = parseInt(document.getElementById('id_plan').innerHTML); // Convertir el id_plan a entero
    var tipoPago = document.getElementById('tipo_pago').value.trim();
    var alerta = document.getElementById('alerta'); // Div para mostrar alertas

    // Limpiar el mensaje de alerta previo
    // alerta.innerHTML = "";

    // Validar campos obligatorios
    if (!nombre || !telefono || !ci || !duracion || !id_plan || !tipoPago) {
        alerta.innerHTML = `<p style="color: red; font-weight: bold;">Debe llenar todos los campos.</p>`;
        return; // Salir de la función si hay campos vacíos
    }

    console.log("Duración del plan:", duracion);
    console.log("Id del plan:", id_plan);

    // Crear un objeto FormData para enviar los datos
    var formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('telefono', telefono);
    formData.append('ci', ci);
    formData.append('duracion', duracion);
    formData.append('id_plan', id_plan);
    formData.append('tipo_pago', tipoPago);

    // Crear la solicitud AJAX para enviar los datos al servidor
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "includes/crear_cliente.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Manejar la respuesta del servidor
            alert('Cliente creado exitosamente');
            console.log(ajax.responseText); // Imprimir la respuesta para depuración
            var volatil = document.getElementById('inicio');
            seleccionar(volatil);
            cargar('pantalla_inicio.php');
        }
    };

    // Enviar los datos del formulario
    ajax.send(formData);
}


function NuevoClienteSuscripcion(){
    var contenido = document.getElementById('Contenido_pagian');
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "includes/cliente_nuevo_inscripcion.php", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Manejar la respuesta del servidor
            contenido.innerHTML = ajax.responseText;
            console.log("eSTA ENTRE AQUI");
            console.log(ajax.responseText);
        }
    };

    // Enviar los datos del formulario
    ajax.send();

}


function RenovarSuscripcion(){
    var contenido = document.getElementById('Contenido_pagian');
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "includes/cliente_renovar_inscripcion.php", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Manejar la respuesta del servidor
            contenido.innerHTML = ajax.responseText;
        }
    };

    // Enviar los datos del formulario
    ajax.send();

}

function buscarClienteRenovacion() {
    var id = document.getElementById('buscar_id').value;
    var edicion = document.getElementById('edicion');
    console.log("Buscar cliente con ID " + id);
    edicion.innerHTML = "";
    // Hacer una petición AJAX para obtener el formulario de edición
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "includes/clientes_editar_renovar.php?id=" + id, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Obtener el contenido de la respuesta
            var response = ajax.responseText;

            // Verificar si la respuesta contiene algún mensaje de error, como "No existe ningún cliente"
            if (response.includes("No existe ningún cliente")) {
                // Si no se encuentra el cliente, agregamos el mensaje al final del contenido actual
                var infoRenovacion = document.getElementById('Info_Renovacion');
                infoRenovacion.innerHTML += "<p style='color: red; id=`mensajePeligroso`'>No existe ningún cliente con ese CI.</p>";
            } else {
                // Si se encuentra el cliente, reemplazamos el contenido con el formulario
                document.getElementById('Info_Renovacion').innerHTML = response;
            }
        }
    };
    ajax.send();
}





function seleccionadoPrediccionBuscada(id_cliente, ci) {
    // Mostrar los valores seleccionados en la consola (opcional)
    console.log("Cliente seleccionado:");
    console.log("ID:", id_cliente);
    console.log("CI:", ci);

    document.getElementById('buscar_id').value = ci;  // Actualizar el valor del input
    buscarClienteRenovacion()
    // Aquí puedes agregar cualquier lógica adicional, como enviar estos datos a un servidor o realizar una nueva consulta
}



function autocompletarClienteRenovacion() {
    // Recuperar el div donde se escribirán los resultados
    var edicion = document.getElementById('edicion');

    // Limpiar el contenido actual del div
    edicion.innerHTML = "";

    // Recuperar el texto actual ingresado en el input
    var inputValue = document.getElementById('buscar_id').value;

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
                if (document.getElementById('mensajePeligroso')) {
                    document.getElementById('mensajePeligroso').innerHTML = ""; // Limpiar el contenido del elemento
                }
                // Iterar sobre los resultados y crear los divs
                resultados.forEach(function (cliente) {
                    var nuevoDiv = document.createElement('div');
                    nuevoDiv.style.width = "80%"; // Ancho completo
                    nuevoDiv.style.padding = "10px"; // Espaciado interno
                    nuevoDiv.style.marginBottom = "5px"; // Separación entre elementos
                    nuevoDiv.style.backgroundColor = "rgba(8, 230, 219, 0.67)"; // Fondo dinámico
                    nuevoDiv.style.color = "var(--color-negro)"; // Letras negras
                    nuevoDiv.style.fontFamily = "'Arial', sans-serif"; // Tipografía bonita
                    nuevoDiv.style.fontSize = "16px"; // Tamaño de fuente legible
                    nuevoDiv.style.borderRadius = "5px"; // Bordes redondeados
                    nuevoDiv.style.boxShadow = "0 2px 5px rgba(0, 0, 0, 0.1)"; // Sombra suave

                    nuevoDiv.innerText = ` ${cliente.ci}`; // Mostrar CI en el div
                    nuevoDiv.style.cursor = "pointer"; // Agregar un puntero para indicar clickeable

                    // Agregar el evento onclick
                    nuevoDiv.setAttribute(
                        "onclick",
                        `seleccionadoPrediccionBuscada(${cliente.id_cliente}, '${cliente.ci}')`
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














function nuevaInscripcionCliente() {
    // Recuperar el ID del cliente y los días restantes
    var id_cliente = document.getElementById('id_cliente').value; // Este campo oculto contiene el ID del cliente
    var dias_restantes = document.getElementById('dias_restantes').value; // Recuperar días restantes
    
    // Asegúrate de que también recuperas la duración del nuevo plan y el tipo de pago
    var duracion = parseInt(document.getElementById('duracion').innerHTML);  // Duración del plan (entero)
    var id_plan = parseInt(document.getElementById('id_plan').innerHTML);  // ID del plan (entero)
    var tipoPago = document.getElementById('tipo_pago').value;  // Tipo de pago seleccionado

    // Crear un objeto FormData para enviar los datos
    var formData = new FormData();
    formData.append('id_cliente', id_cliente);
    formData.append('dias_restantes', dias_restantes);
    formData.append('duracion', duracion); // Duración del nuevo plan
    formData.append('id_plan', id_plan);  // ID del plan
    formData.append('tipo_pago', tipoPago); // Tipo de pago

    // Crear la solicitud AJAX para enviar los datos al servidor
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "includes/nueva_inscripcion_cliente_antiguo.php", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Manejar la respuesta del servidor
            alert('Suscripción añadida exitosamente');
            console.log(ajax.responseText); // Imprimir la respuesta para depuración
            // var oh0hh = document.getElementById('inscripcionDatos');
            // seleccionar(oh0hh);
            cargar('pantalla_inscripciones.php');
    
        }
    };

    // Enviar los datos del formulario
    ajax.send(formData);
}





function toggleEstadoPlan(id_plan) {
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "includes/cambiar_estado_plan.php", true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Enviar el ID del plan al servidor para cambiar su estado
    ajax.send("id_plan=" + id_plan);

    // Actualizar el estado del plan sin mostrar una alerta
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            console.log('Estado del plan actualizado');
        }
    };
}





// Función para editar un plan de suscripción
function editarPlan(id_plan) {
    // Hacer una llamada AJAX para obtener los datos del plan
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "includes/obtener_plan.php?id_plan=" + id_plan, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Procesar la respuesta y generar el formulario de edición
            var plan = JSON.parse(ajax.responseText);

            // Mostrar el formulario con los datos del plan a editar
            document.getElementById('Contenido_pagian').innerHTML = `
                <h3>Editar Plan de Suscripción</h3>
                <form id="form-editar-plan">
                    <input type="hidden" id="id_plan" name="id_plan" value="${plan.id_plan}">
                    
                    <label for="nombre_plan">Nombre del Plan:</label>
                    <input type="text" id="nombre_plan" name="nombre_plan" value="${plan.nombre_plan}" required><br>

                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion" value="${plan.descripcion}" required><br>

                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" value="${plan.precio}" required><br>

                    <label for="duracion">Duración (días):</label>
                    <input type="number" id="duracion" name="duracion" value="${plan.duracion}" required><br>

                    <label for="imagen">Imagen del Plan:</label>
                    <img src="http://localhost/Web-Proyecto/img/pagina/${plan.imagen}" alt="Imagen del plan" style="width: 200px;"><br>
                    <input type="file" id="imagen" name="imagen"><br>
                    <small>Deja la imagen vacía si no deseas cambiarla</small><br>

                    <button type="button" onclick="actualizarPlan(${id_plan})">Actualizar Plan</button>
                </form>
            `;
        }
    };
    ajax.send();
}
function actualizarPlan(id_plan) {
    var formData = new FormData(document.getElementById('form-editar-plan'));

    // Crear la solicitud AJAX para actualizar el plan
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "includes/actualizar_plan.php", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Manejar la respuesta
            alert('Plan actualizado correctamente');
            console.log(ajax.responseText);
        }
    };

    // Enviar los datos del formulario al servidor
    ajax.send(formData);
}
// Función para enviar el formulario de actualización de plan
function actualizarPlan(id_plan) {
    var formData = new FormData(document.getElementById('form-editar-plan'));

    // Crear la solicitud AJAX para actualizar el plan
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "includes/actualizar_plan.php", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Manejar la respuesta
            console.log(ajax.responseText);
            cargar('Pantalla_extras.php');
        }
    };

    // Enviar los datos del formulario al servidor
    ajax.send(formData);
}


// Función para generar el formulario para crear un nuevo plan
// Función para generar el formulario para crear un nuevo plan
function crearNuevoPlan() {
    // Selecciona el div con id "Contenido_pagian" y reemplaza su contenido con el formulario
    document.getElementById('Contenido_pagian').innerHTML = `
        <h3>Nuevo Plan de Suscripción</h3>
        <form id="form-nuevo-plan">
            <label for="nombre_plan">Nombre del Plan:</label>
            <input type="text" id="nombre_plan" name="nombre_plan" required><br>

            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" required><br>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" required><br>

            <label for="duracion">Duración (días):</label>
            <input type="number" id="duracion" name="duracion" required><br>

            <label for="imagen">Imagen del Plan:</label>
            <input type="file" id="imagen" name="imagen" required><br>

            <button type="button" onclick="insertarNuevoPlan()">Crear Plan</button>
        </form>
    `;
}


// Función para insertar el nuevo plan utilizando AJAX
function insertarNuevoPlan() {
    var formData = new FormData(document.getElementById('form-nuevo-plan'));

    var ajax = new XMLHttpRequest();
    ajax.open("POST", "includes/insertar_plan.php", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Manejar la respuesta del servidor
            console.log('Nuevo plan creado');
            cargar('Pantalla_extras.php');
        }
    };

    // Enviar los datos del formulario
    ajax.send(formData);
}




function activarCliente(id_cliente) {
    var ajax = new XMLHttpRequest();
    ajax.open("POST", "includes/actualizar_estado_cliente.php", true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Obtener el estado actual del checkbox
    var checkbox = event.target;
    var estado = checkbox.checked ? "activo" : "inactivo";

    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            console.log(`Estado del cliente ${id_cliente} actualizado a: ${estado}`);
        }
    };

    // Enviar el ID del cliente y el nuevo estado al servidor
    ajax.send(`id_cliente=${id_cliente}&estado=${estado}`);
}


function mostrarClientesActivos() {

}


function verGananciasTotales() {
    var ohh = document.getElementById('pagos_pagina');
    seleccionar(ohh);
    cargar('pantalla_pagos.php');
}
function verUsuariosActivos() {
    var ohhh = document.getElementById('clientes_carga_pagina');
    seleccionar(ohhh);
    cargar('pantalla_clientes.php');
    flitroCliente(1);

    setTimeout(function() {
        seleccionarFiltro(1);
    }, 10);
    

}

function verUsuariosTotales() {
    var ohhh = document.getElementById('clientes_carga_pagina');
    seleccionar(ohhh);
    cargar('pantalla_clientes.php');
    

    setTimeout(function() {
        mostrarClientes();
        seleccionarFiltro(4);
    }, 10);
    

}

function renovacionDirecta(ci_cliente) {
    var ohhh = document.getElementById('inscripcionDatos');
    seleccionar(ohhh);
    cargar('pantalla_inscripciones.php');
    

    setTimeout(function() {
        RenovarSuscripcion();
    }, 10);

    console.log(ci_cliente);
    setTimeout(function() {
        var temporsa12= document.getElementById('buscar_id');
        temporsa12.value = ci_cliente;
        buscarClienteRenovacion();
    }, 100);
    

}

        // Función para simular el clic al cargar la página
        window.onload = function () {
            const elemento = document.getElementById("inicio");
            if (elemento) {
                elemento.click(); // Simula el clic
            }
        };

        function cambiarColorEstilo() {
            // Obtener el valor seleccionado
            var color = document.getElementById('tema').value;
            // Cambiar el href del link con id "estilosCambio"
            document.getElementById('estilosCambio').setAttribute('href', 'css/inicio' + color + '.css?v=1.0');
        }



        function updateImageSrc(selectId, imgId, link) {
            const img = document.getElementById(imgId);
            const select = document.getElementById(selectId);
        
            // Obtener el valor seleccionado
            const selectedValue = select.value;
        
            // Base de la URL de la imagen
            const baseSrc = link;
            console.log("Base de la URL de la imagen:", baseSrc);
            // Actualizar el src con el parámetro GET si se selecciona una opción válida
            if (selectedValue !== "nochance") {
                img.src = `${baseSrc}?option=${selectedValue}`;
                console.log("Nueva URL de la imagen:", img.src);
            } else {
                img.src = baseSrc; // Restaurar la URL base si no hay selección válida
            }
        }
        