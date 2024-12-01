<?php
// Iniciar sesión y conexión a la base de datos
session_start();
include('../includes/conexion.php');

// Consulta para obtener todos los planes de suscripción
$sql_planes = "SELECT id_plan, nombre_plan, descripcion, precio, duracion, estado_plan FROM planes_suscripcion";

$result_planes = $con->query($sql_planes);

if ($result_planes->num_rows > 0) {
    // Mostrar la tabla con los datos de los planes de suscripción
    echo "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; text-align: center;'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID Plan</th>";
    echo "<th>Nombre del Plan</th>";
    echo "<th>Descripción</th>";
    echo "<th>Precio</th>";
    echo "<th>Duración (días)</th>";
    echo "<th>Estado (Activo)</th>";
    echo "<th>Acciones</th>";  // Columna de acciones (editar)
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    // Iterar sobre los resultados de la consulta
    while ($row = $result_planes->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id_plan'] . "</td>";
        echo "<td>" . $row['nombre_plan'] . "</td>";
        echo "<td>" . $row['descripcion'] . "</td>";
        echo "<td>" . $row['precio'] . " Bs.</td>";
        echo "<td>" . $row['duracion'] . " días</td>";

        // Checkbox para indicar si el plan está activo
        $checked = ($row['estado_plan'] === 'activo') ? 'checked' : '';
        echo "<td><input type='checkbox' onclick='toggleEstadoPlan(" . $row['id_plan'] . ")' $checked></td>";

        // Botón para editar el plan
        echo "<td><button onclick='editarPlan(" . $row['id_plan'] . ")'>Editar</button></td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<h3 style='color: var(--color-rojo-intenso);'>No hay planes de suscripción registrados.</h3>";
}

// Botón para añadir un nuevo plan
echo "<br><button onclick='crearNuevoPlan()'>Nuevo Plan</button>";

// Cerrar la conexión a la base de datos
$con->close();
?>
