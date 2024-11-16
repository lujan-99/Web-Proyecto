<?php 
include("conexion.php");

// Verificar si se han recibido parámetros por GET
$ci = isset($_GET['ci']) ? $_GET['ci'] : '';
$numero = isset($_GET['numero']) ? $_GET['numero'] : '';
$texto = isset($_GET['texto']) ? $_GET['texto'] : ''; // Nuevo parámetro para el texto

// Modificar la consulta SQL en función de los parámetros recibidos
if (!empty($texto)) {
    // Recuperar el CI y el ID de los clientes cuyos CI comienzan con el texto ingresado
    $sql_clientes = "SELECT id_cliente, ci 
                     FROM clientes 
                     WHERE ci LIKE '$texto%'";
} else if (!empty($ci)) {
    // Si se ha recibido un CI exacto, hacer la consulta filtrando por ese CI
    $sql_clientes = "SELECT id_cliente, nombre, telefono, ci, fecha_registro, dias_restantes 
                     FROM clientes 
                     WHERE ci = '$ci'";
} else if (!empty($numero)) {
    switch ($numero) {
        case 1:
            // Seleccionar los clientes que tienen días restantes diferentes de 0
            $sql_clientes = "SELECT id_cliente, nombre, telefono, ci, fecha_registro, dias_restantes 
                             FROM clientes 
                             WHERE dias_restantes != 0";
            break;
        case 2:
            // Seleccionar los clientes que tienen días restantes igual a 0
            $sql_clientes = "SELECT id_cliente, nombre, telefono, ci, fecha_registro, dias_restantes 
                             FROM clientes 
                             WHERE dias_restantes = 0";
            break;
        case 3:
            // Seleccionar los clientes que tienen días restantes menores a 10
            $sql_clientes = "SELECT id_cliente, nombre, telefono, ci, fecha_registro, dias_restantes 
                             FROM clientes 
                             WHERE dias_restantes < 10 AND dias_restantes > 0";
            break;
        default:
            // Si 'numero' no es 1, 2 o 3, seleccionar todos los clientes
            $sql_clientes = "SELECT id_cliente, nombre, telefono, ci, fecha_registro, dias_restantes FROM clientes";
            break;
    }
} else {
    // Si no se ha recibido un CI ni un número, buscar todos los clientes
    $sql_clientes = "SELECT id_cliente, nombre, telefono, ci, fecha_registro, dias_restantes FROM clientes";
}

// Ejecutar la consulta
$result_clientes = $con->query($sql_clientes);

$datos = array();

if ($result_clientes->num_rows > 0) {
    while ($row = $result_clientes->fetch_assoc()) {
        $datos[] = $row;
    }
}

// Devolver los resultados como JSON
echo json_encode($datos, JSON_UNESCAPED_UNICODE);

// Cerrar la conexión a la base de datos
$con->close();
?>
