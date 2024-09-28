<?php
include("conexion.php");
session_start();

// Recuperar los datos enviados por AJAX
$id_cliente = (int)$_POST['id_cliente']; // ID del cliente existente
$dias_restantes = (int)$_POST['dias_restantes'];  // Días restantes actuales del cliente
$duracion = (int)$_POST['duracion'];  // Duración de la nueva suscripción
$tipo_pago = $_POST['tipo_pago'];
$id_plan = (int)$_POST['id_plan'];  // ID del plan seleccionado
$usuario = $_SESSION['nombre'];  // Usuario actual de la sesión

// Sumar la duración de la nueva suscripción a los días restantes del cliente
$nuevos_dias_restantes = $dias_restantes + $duracion;

// Actualizar los días restantes del cliente en la base de datos
$sql_update_dias = "UPDATE clientes SET dias_restantes = '$nuevos_dias_restantes' WHERE id_cliente = '$id_cliente'";

if ($con->query($sql_update_dias) === TRUE) {
    // Insertar los datos en la tabla suscripciones
    $sql_suscripcion = "INSERT INTO suscripciones (id_cliente, id_plan, tipo_pago, usuario) 
                        VALUES ('$id_cliente', '$id_plan', '$tipo_pago', '$usuario')";

    if ($con->query($sql_suscripcion) === TRUE) {
        echo "Suscripción añadida exitosamente y días restantes actualizados.";
    } else {
        echo "Error al crear la suscripción: " . $con->error;
    }
} else {
    echo "Error al actualizar los días restantes del cliente: " . $con->error;
}

$con->close();
?>
