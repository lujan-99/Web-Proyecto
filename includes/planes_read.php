<?php
include ('conexion.php');

// Verificar si se ha recibido un id_plan
$id_plan = isset($_GET['id_plan']) ? $_GET['id_plan'] : '';

$response = [];

if (!empty($id_plan)) {
    // Consulta para obtener los detalles del plan
    $sql = "SELECT id_plan, nombre_plan, descripcion, precio, duracion, imagen FROM planes_suscripcion WHERE id_plan = '$id_plan'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Almacenar los detalles del plan en un array
        $response = [
            'id_plan' => $row['id_plan'],
            'nombre_plan' => $row['nombre_plan'],
            'descripcion' => $row['descripcion'],
            'precio' => $row['precio'],
            'duracion' => $row['duracion'],
            'imagen' => 'img/pagina/' . $row['imagen']  // Ruta de la imagen
        ];
    } else {
        $response = ['error' => 'No se encontraron detalles para este plan.'];
    }
} else {
    $response = ['error' => 'No se proporcionó un ID de plan válido.'];
}

// Devolver los detalles del plan como JSON
header('Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_UNICODE);

$con->close();
?>
