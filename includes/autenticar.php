<?php
session_start();

$nombre = $_POST['nombre'];
$contrasena = sha1($_POST['contrasena']);

include('conexion.php');

// Consulta para verificar el usuario y la contraseña
$sql = "SELECT nombre_usuario, rol FROM usuarios WHERE nombre_usuario='$nombre' AND password='$contrasena'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $datos = $result->fetch_assoc();
    $_SESSION['nombre'] = $datos['nombre_usuario'];
    $_SESSION['nivel'] = $datos['rol'];
    echo "bien";  // Respuesta si el login es correcto
    
} else {
    echo "error";  // Respuesta si el login falla
}
?>
