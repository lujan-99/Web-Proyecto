<?php
// Iniciar sesión o conexión a la base de datos
//include('verificar.php');
include('verificar.php');
include('conexion.php');
//Debemos agregar la zona horaria para que la hora sea la correcta
date_default_timezone_set('America/La_Paz');
//Obtener el mes y el año actual
$mes_actual = date('m');  // Mes en formato de dos dígitos (01-12)
$anio_actual = date('Y');  // Año en formato de cuatro dígitos
//Comprobamos que el mes y el año se obtuvieron correctamente
// echo $mes_actual;
// echo $anio_actual;

// Consulta para contar el numero de inscripciones en el mes actual
$sql_total_inscripciones = "SELECT COUNT(*) AS total_inscripciones 
        FROM suscripciones 
        WHERE MONTH(fecha_inicio) = '$mes_actual' 
        AND YEAR(fecha_inicio) = '$anio_actual'";

// Consulta para contar el número total de clientes activos
$sql_tota_activos = "SELECT COUNT(DISTINCT c.id) AS total_clientes_activos
        FROM clientes c
        JOIN suscripciones s ON c.id = s.cliente_id
        JOIN estados_suscripcion e ON s.estado_id = e.id
        WHERE e.nombre = 'activa'";

// Consulta para las ganancias del mes actual
$sql_ganancias = "SELECT SUM(monto) AS total_ganancias
        FROM pagos
        WHERE MONTH(fecha_pago) = '$mes_actual'
        AND YEAR(fecha_pago) = '$anio_actual'";
// Consulta de todos los clientes de los que vence su suscripcion en el mes actual
$sql_vencimientos = "SELECT c.id, c.nombre, c.apellidos, s.fecha_fin
        FROM clientes c
        JOIN suscripciones s ON c.id = s.cliente_id
        WHERE MONTH(s.fecha_fin) = '12'
        AND YEAR(s.fecha_fin) = '$anio_actual'";

// Imprimir la consulta SQL para verificar
// echo $sql_total_activos;
// echo $sql_total_inscripciones;
// echo $sql_ganancias;

// Preparar y ejecutar las consultas
$result_inscipciones = $con->query($sql_total_inscripciones);
$result_activos = $con->query($sql_tota_activos);
$result_ganancias = $con->query($sql_ganancias);
$result_vencimientos = $con->query($sql_vencimientos);

// Verificar si la consulta se ejecutó correctamente
if ($result_inscipciones) {
    $row1 = $result_inscipciones->fetch_assoc();
} else {
    echo "0 resultados";
}

if ($result_activos) {
    $row2 = $result_activos->fetch_assoc();
} else {
    echo "0 resultados";
}


if ($result_ganancias) {
    $row3 = $result_ganancias->fetch_assoc();
    if ($row3['total_ganancias'] == null) {
        $ganancias = 0;
        // echo "No hay ganancias";
    } else {
        $ganancias = $row3['total_ganancias'];
    }
} else {
    echo "0 resultados";
}


// if ($result_vencimientos) {
//     $row4 = $result_vencimientos->fetch_assoc();
// } else {
//     echo "0 resultados";
// }
// ?>