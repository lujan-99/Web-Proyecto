<?php session_start();
if (!isset($_SESSION['nombre'])) {
?>
    <meta http-equiv="refresh" content="3; url=index.html">
<?php
    die('Acceso Denegado');
}

// $_SESSION['nombre']=$datos['nombre_usuario'];
// $_SESSION['nivel']=$datos['tipo_usuario_id'];
?>
