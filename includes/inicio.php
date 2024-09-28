<?php
// Iniciar sesión
session_start();
include('conexion.php');

// Establecer la zona horaria
date_default_timezone_set('America/La_Paz');

// Consulta para contar el número total de clientes con días restantes > 0
$sql_total_activos = "SELECT COUNT(*) AS total_clientes_activos
        FROM clientes 
        WHERE dias_restantes > 0";
$result_activos = $con->query($sql_total_activos);
$row2 = $result_activos ? $result_activos->fetch_assoc() : ['total_clientes_activos' => 0];

// Consulta para contar el número de inscripciones (clientes registrados)
$sql_total_inscripciones = "SELECT COUNT(*) AS total_inscripciones 
        FROM clientes";
$result_inscripciones = $con->query($sql_total_inscripciones);
$row1 = $result_inscripciones ? $result_inscripciones->fetch_assoc() : ['total_inscripciones' => 0];

// Consulta para calcular las ganancias totales (sumar los precios de todos los planes suscritos)
$sql_ganancias = "SELECT SUM(p.precio) AS total_ganancias
        FROM planes_suscripcion p
        JOIN suscripciones s ON p.id_plan = s.id_plan";
$result_ganancias = $con->query($sql_ganancias);
$row3 = $result_ganancias ? $result_ganancias->fetch_assoc() : ['total_ganancias' => 0];
$ganancias = $row3['total_ganancias'] ?? 0;

// Consulta de clientes cuyas suscripciones vencen en los próximos 10 días y mayores a 0
$sql_vencimientos = "SELECT id_cliente, nombre, dias_restantes
        FROM clientes 
        WHERE dias_restantes < 10 AND dias_restantes > 0";
$result_vencimientos = $con->query($sql_vencimientos);

// Cerrar la conexión se hará en el archivo que lo incluye.
