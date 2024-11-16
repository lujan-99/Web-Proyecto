<?php
include("conexion.php");

// Recuperar datos del POST
$id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';
$estado = isset($_POST['estado']) ? $_POST['estado'] : '';

// Validar los datos
if (!empty($id_cliente) && !empty($estado)) {
    $sql = "UPDATE clientes SET estado = ? WHERE id_cliente = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('si', $estado, $id_cliente);
    if ($stmt->execute()) {
        echo "Estado actualizado correctamente.";
    } else {
        echo "Error al actualizar el estado.";
    }
    $stmt->close();
} else {
    echo "Datos insuficientes.";
}

$con->close();
?>
