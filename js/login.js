function login() {
    var formulario = document.getElementById("login-form");
    var parametros = new FormData(formulario);  // Capturamos los datos del formulario
    var mensajeError = document.getElementById('mensaje');  // Mensaje de error

    var ajax = new XMLHttpRequest();  // Creamos el objeto AJAX

    ajax.open("POST", "includes/autenticar.php", true);  // Abrimos la solicitud AJAX
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Revisamos la respuesta del servidor
            if (ajax.responseText === "error") {
                // Mostrar mensaje de error si el login falla
                
                mensajeError.innerText = "Usuario o contraseña incorrectos.";
            } else if (ajax.responseText === "bien") {
                // Mostrar mensaje de éxito si el login es correcto
                
                mensajeError.innerText = "Inicio de sesión exitoso. Redirigiendo...";
                
                // Redirigir después de un corto delay
                setTimeout(function() {
                    window.location.href = "inicio.php";
                }, 2000);
            }
        }
    };

    ajax.send(parametros);  // Enviamos los datos del formulario
}
