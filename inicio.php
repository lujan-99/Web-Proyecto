<!DOCTYPE html>
<html lang="en">
    <?php include('includes/inicio.php'); ?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <?php
// Variable para determinar el estilo seleccionado
$tema = $_SESSION['nivel'];

// Determina el archivo CSS a cargar según el tema
$archivoCss = '';
switch ($tema) {
    case 'Empleado':
        $archivoCss = 'inicio-dark.css';
        break;
    case 'Privilegiado':
        $archivoCss = 'inicio-arcoiris.css';
        break;
    case 'Cliente':
        $archivoCss = 'inicio-blanconegro.css';
        break;
    case 'root':
        $archivoCss = 'inicio.css';
        break;
}
?>
        <link rel="stylesheet" href="css/<?php echo $archivoCss; ?>?v=1.0" id="estilosCambio">

        
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
                <div>
                    <select name="tema" id="tema" onchange="cambiarColorEstilo()">
                        <option value="" <?php echo $tema === 'root' ? 'selected' : ''; ?>>Claro</option>
                        <option value="-arcoiris" <?php echo $tema === 'Empleado' ? 'selected' : ''; ?>>Arcoiris</option>
                        <option value="-blanconegro" <?php echo $tema === 'Privilegiado' ? 'selected' : ''; ?>>Blanco Negro</option>
                        <option value="-dark" <?php echo $tema === 'Cliente' ? 'selected' : ''; ?>>Oscuro</option>
                    </select>
                </div>
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
    echo '<div class="opcion-menu" onmouseover="hover(this)" onmouseout="unhover(this)" onclick="seleccionar(this); cargar(\'pantalla_graficas.php\')">Graficas</div>';
}
?>
        </div>
        <!-- Contenido Principal -->
        <div id="Contenido_pagian">
        
            <!-- ------------------------------------------------------------------------------------------------------ -->
            <div id="contenedor" styel="padding-top: 50px;">
            <link rel="stylesheet" href="css/index.css">

        
    </div>
            <!-- ------------------------------------------------------------------------------------------------------ -->
        </div>
        <script src="js/inicio.js" type="text/javascript"></script>
    </body>
</html>
