<!DOCTYPE html>
<html lang="en">
    <?php include('includes/inicio.php'); ?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="css/inicio.css">
        <script src="js/inicio.js" type="text/javascript"></script>
        
    </head>

    <body>
        <div id="cabeza">
            <div id="logo-usuario">
                <img src="img/pagina/logo.jpg" alt="logo" id="logo">
                <div id="nombre-usuario">
                    <?php echo $_SESSION['nombre']; ?> : <?php echo $_SESSION['nivel']; ?>
                </div>
            </div>
            <div>
                <div>Fecha</div>
                <a href="includes/cerrar.php">
                    <div id="cerrar-sesion">Botón de cierre</div>
                </a>
            </div>
        </div>

        <div id="nav">
            <div class="opcion-menu" onmouseover="hover(this)" onmouseout="unhover(this)" onclick="seleccionar(this); cargar('pantalla_inicio.php')" id="inicio">Inicio</div>
            <div class="opcion-menu" onmouseover="hover(this)" onmouseout="unhover(this)" onclick="seleccionar(this); cargar('pantalla_clientes.php');" id="clientes_carga_pagina">Clientes</div>
            <div class="opcion-menu" onmouseover="hover(this)" onmouseout="unhover(this)" onclick="seleccionar(this); cargar('pantalla_inscripciones.php')" id="inscripcionDatos">Inscripciones</div>
            <div class="opcion-menu" onmouseover="hover(this)" onmouseout="unhover(this)" onclick="seleccionar(this); cargar('pantalla_pagos.php')" id="pagos_pagina">Pagos</div>
            <?php

// Verificar si el usuario es 'root'
if (isset($_SESSION['nivel']) && $_SESSION['nivel'] === 'root') {
    // Si el usuario es 'root', imprimir el contenido
    echo '<div class="opcion-menu" onmouseover="hover(this)" onmouseout="unhover(this)" onclick="seleccionar(this); cargar(\'pantalla_extras.php\')">Extras</div>';
}
?>
        </div>
        <!-- Contenido Principal -->
        <div id="Contenido_pagian">
        
            <!-- ------------------------------------------------------------------------------------------------------ -->
            <div id="contenedor" styel="padding-top: 50px;">
            <link rel="stylesheet" href="css/index.css">

        <div id="textos">
            <div id="texto-logo">Equilibrium Wellness Club</div>
            <div id="texto-complementario">Software de Gestion</div>
        </div>
    </div>
            <!-- ------------------------------------------------------------------------------------------------------ -->
        </div>
        
    </body>
</html>
