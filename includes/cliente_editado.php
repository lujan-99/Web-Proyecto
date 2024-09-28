<?php
include("conexion.php");

// Recoger los datos del formulario
$id_cliente = $_POST['id_cliente'];
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$ci = $_POST['ci'];
$fecha_registro = $_POST['fecha_registro']; // Aunque es de solo lectura, lo incluimos aquí por completitud
$dias_restantes = $_POST['dias_restantes'];

// Construir la consulta SQL para actualizar el cliente
$sql = "UPDATE clientes SET 
        nombre='$nombre', 
        telefono='$telefono', 
        ci='$ci', 
        fecha_registro='$fecha_registro', 
        dias_restantes='$dias_restantes'
        WHERE id_cliente=$id_cliente";

// Ejecutar la consulta
$result = $con->query($sql);

if ($result) {
    echo "<div style='color: rgb(8, 230, 219); font-family: Wild Wolf; font-size: 32px; padding-top: 40px;text-align: center;'>Cliente actualizado con éxito.</div><img src='img/iconos/bien.png' style='width: 320px; padding:15px;'>";
} else {
    echo "<div style='color: rgb(8, 230, 219); font-family: Wild Wolf; font-size: 32px; padding-top: 40px;text-align: center;'>Error al actualizar el cliente: " . $con->error . "</div><img src='img/iconos/bien.png' style='width: 320px; padding:15px;'>";
}

// Cerrar la conexión a la base de datos
$con->close();
?>
