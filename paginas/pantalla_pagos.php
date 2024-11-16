<?php
// Iniciar sesión y conexión a la base de datos
session_start();
include('../includes/conexion.php');

// Consulta para obtener las suscripciones con la información del cliente y del plan
$sql_suscripciones = "SELECT 
                        s.id_suscripcion, 
                        c.nombre AS cliente, 
                        c.ci, 
                        c.telefono, 
                        p.nombre_plan AS plan, 
                        p.precio, 
                        p.duracion, 
                        s.tipo_pago, 
                        s.usuario 
                    FROM suscripciones s
                    JOIN clientes c ON s.id_cliente = c.id_cliente
                    JOIN planes_suscripcion p ON s.id_plan = p.id_plan";

// Contenedor principal
echo "<div style='display: flex; flex-direction: column; gap: 20px; align-items: center; padding: 20px; width:100%'>";

// Contenedor del título y botón
echo "<div style='display: flex; flex-direction: row; gap: 10px; align-items: center;'>";

// Título con color y estilos adicionales
echo "<h1 style='margin: 0; color: #08e6d1; font-family: Arial, sans-serif; font-size: 28px;'>Suscripciones</h1>";

// Botón de imprimir
echo "<a href='fpdf186/informe.php' style='background-color: #08e6d1; color: black; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-family: Arial, sans-serif; text-align: center;'>Imprimir</a>";

echo "</div>"; // Cerrar contenedor del título y botón

// Contenedor de la tabla
echo "<div style=`display: flex; justify-content: center; align-items: center; flex-grow: 1;`>";

$result_suscripciones = $con->query($sql_suscripciones);

if ($result_suscripciones->num_rows > 0) {
    // Mostrar la tabla con los datos de las suscripciones
    echo "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; text-align: center;'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID Suscripción</th>";
    echo "<th>Cliente</th>";
    echo "<th>CI</th>";
    echo "<th>Teléfono</th>";
    echo "<th>Plan</th>";
    echo "<th>Precio</th>";
    echo "<th>Duración (días)</th>";
    echo "<th>Tipo de Pago</th>";
    echo "<th>Usuario que Registró</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    // Iterar sobre los resultados de la consulta
    while ($row = $result_suscripciones->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id_suscripcion'] . "</td>";
        echo "<td>" . $row['cliente'] . "</td>";
        echo "<td>" . $row['ci'] . "</td>";
        echo "<td>" . $row['telefono'] . "</td>";
        echo "<td>" . $row['plan'] . "</td>";
        echo "<td>" . $row['precio'] . " Bs.</td>";
        echo "<td>" . $row['duracion'] . " días</td>";
        echo "<td>" . ucfirst($row['tipo_pago']) . "</td>";  // Capitalizar el tipo de pago
        echo "<td>" . $row['usuario'] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<h3 style='color: red;'>No hay suscripciones registradas.</h3>";
}

echo "</div>"; // Cerrar contenedor de la tabla
echo "</div>"; // Cerrar contenedor principal

// Cerrar la conexión a la base de datos
$con->close();
?>
