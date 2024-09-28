<?php
include("conexion.php");
session_start();
// Recuperar los datos enviados por AJAX
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$ci = $_POST['ci'];
$duracion = (int)$_POST['duracion'];  // Convertir la duración a entero
$tipo_pago = $_POST['tipo_pago'];
$id_plan = (int)$_POST['id_plan'];  // ID del plan seleccionado
$usuario = $_SESSION['nombre'];  // Usuario actual de la sesión
echo $id_plan;
// Insertar los datos en la tabla clientes
$sql_cliente = "INSERT INTO clientes (nombre, telefono, ci, fecha_registro, dias_restantes) 
                VALUES ('$nombre', '$telefono', '$ci', NOW(), '$duracion')";

if ($con->query($sql_cliente) === TRUE) {
    // Obtener el último ID insertado para el cliente
    $id_cliente = $con->insert_id;

    // Insertar los datos en la tabla suscripciones
    $sql_suscripcion = "INSERT INTO suscripciones (id_cliente, id_plan, tipo_pago, usuario) 
                        VALUES ('$id_cliente', '$id_plan', '$tipo_pago', '$usuario')";

    if ($con->query($sql_suscripcion) === TRUE) {
        echo "Cliente y suscripción creados exitosamente";
    } else {
        echo "Error al crear la suscripción: " . $con->error;
    }
} else {
    echo "Error al crear cliente: " . $con->error;
}

$con->close();
?>
