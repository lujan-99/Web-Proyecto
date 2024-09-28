<?php
include('conexion.php');

// Verificar si se ha enviado el id_plan por POST
if (isset($_POST['id_plan'])) {
    $id_plan = (int)$_POST['id_plan'];

    // Consultar el estado actual del plan
    $sql_estado_actual = "SELECT estado_plan FROM planes_suscripcion WHERE id_plan = $id_plan";
    $result_estado = $con->query($sql_estado_actual);

    if ($result_estado->num_rows > 0) {
        $row = $result_estado->fetch_assoc();
        $estado_actual = $row['estado_plan'];

        // Determinar el nuevo estado (si es 'activo' cambiar a 'inactivo' y viceversa)
        $nuevo_estado = ($estado_actual === 'activo') ? 'inactivo' : 'activo';

        // Actualizar el estado del plan en la base de datos
        $sql_cambiar_estado = "UPDATE planes_suscripcion SET estado_plan = '$nuevo_estado' WHERE id_plan = $id_plan";

        if ($con->query($sql_cambiar_estado) === TRUE) {
            echo "Estado del plan actualizado a: " . $nuevo_estado;
        } else {
            echo "Error al actualizar el estado: " . $con->error;
        }
    } else {
        echo "Plan no encontrado.";
    }
} else {
    echo "ID de plan no proporcionado.";
}

// Cerrar la conexión
$con->close();
?>
