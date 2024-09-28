<?php
include('conexion.php');

$id_plan = $_GET['id_plan'];

// Consulta para obtener los detalles del plan
$sql = "SELECT * FROM planes_suscripcion WHERE id_plan = $id_plan";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $plan = $result->fetch_assoc();
    echo json_encode($plan);
} else {
    echo json_encode(['error' => 'Plan no encontrado']);
}

$con->close();
?>
