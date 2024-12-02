<?php
session_start();
include('../includes/conexion.php');

require_once("../jpgraph/jpgraph.php");
require_once("../jpgraph/jpgraph_pie.php");

// Obtener la opción seleccionada desde el parámetro GET
$opcion = isset($_GET['option']) ? intval($_GET['option']) : 0;

// Configurar variables iniciales
$titulo = "";
$valores = [];
$leyendas = [];

// Construir la consulta SQL y procesar resultados según la opción
switch ($opcion) {
    case 1: // Clientes próximos a vencer
        $query = "
            SELECT 
                SUM(CASE WHEN dias_restantes <= 15 AND dias_restantes > 10 THEN 1 ELSE 0 END) AS '11-15 días',
                SUM(CASE WHEN dias_restantes <= 10 AND dias_restantes > 5 THEN 1 ELSE 0 END) AS '6-10 días',
                SUM(CASE WHEN dias_restantes <= 5 AND dias_restantes > 0 THEN 1 ELSE 0 END) AS '1-5 días'
            FROM clientes
            WHERE dias_restantes > 0";
        $titulo = "Clientes Próximos a Vencer";
        break;

    case 2: // Clientes con más días restantes
        $query = "
            SELECT 
                SUM(CASE WHEN dias_restantes > 25 AND dias_restantes <= 30 THEN 1 ELSE 0 END) AS '26-30 días',
                SUM(CASE WHEN dias_restantes > 30 AND dias_restantes <= 35 THEN 1 ELSE 0 END) AS '31-35 días',
                SUM(CASE WHEN dias_restantes > 35 AND dias_restantes <= 45 THEN 1 ELSE 0 END) AS '36-45 días',
                SUM(CASE WHEN dias_restantes > 45 THEN 1 ELSE 0 END) AS 'Más de 45 días'
            FROM clientes";
        $titulo = "Clientes con Más Días Restantes";
        break;

    default: // Activos vs. inactivos
        $query = "SELECT 
                    SUM(CASE WHEN dias_restantes > 0 THEN 1 ELSE 0 END) AS activos,
                    SUM(CASE WHEN dias_restantes = 0 THEN 1 ELSE 0 END) AS inactivos
                  FROM clientes";
        $titulo = "Clientes Activos vs. Inactivos";
        break;
}

// Ejecutar la consulta
$result = $con->query($query);

// Verificar resultados
if (!$result) {
    die("Error en la consulta: " . $con->error);
}

// Procesar los datos de la consulta
$data = $result->fetch_assoc();

if ($opcion === 1) {
    $valores = [$data['11-15 días'], $data['6-10 días'], $data['1-5 días']];
    $leyendas = [
        "11-15 días ({$data['11-15 días']})",
        "6-10 días ({$data['6-10 días']})",
        "1-5 días ({$data['1-5 días']})"
    ];
} elseif ($opcion === 2) {
    $valores = [
        $data['26-30 días'], 
        $data['31-35 días'], 
        $data['36-45 días'], 
        $data['Más de 45 días']
    ];
    $leyendas = [
        "26-30 días ({$data['26-30 días']})",
        "31-35 días ({$data['31-35 días']})",
        "36-45 días ({$data['36-45 días']})",
        "Más de 45 días ({$data['Más de 45 días']})"
    ];
} else {
    $valores = [$data['activos'], $data['inactivos']];
    $leyendas = [
        "Activos ({$data['activos']})",
        "Inactivos ({$data['inactivos']})"
    ];
}

// Crear el gráfico de pastel
$grafico = new PieGraph(800, 500, 'auto');
$grafico->SetShadow(); // Sombra para el gráfico
$grafico->title->Set($titulo);
$grafico->title->SetFont(FF_FONT2, FS_BOLD, 16);

// Crear el gráfico de pastel recto
$pastel = new PiePlot($valores);
$pastel->SetSize(0.35); // Ajustar el tamaño del gráfico
$pastel->SetCenter(0.5, 0.5); // Centrar el gráfico
$pastel->SetLegends($leyendas); // Leyendas con los nombres de las categorías
$pastel->SetSliceColors(["#5fe71b", "#e53030", "#08e6db", "#ff1212", "#77b300"]); // Colores personalizados
$pastel->SetLabelType(PIE_VALUE_PER); // Mostrar porcentajes
$pastel->value->SetFormat('%2.1f%%'); // Formato de porcentaje
$pastel->value->SetColor("#333333"); // Color de las etiquetas

// Agregar el gráfico de pastel al gráfico principal
$grafico->Add($pastel);

// Mostrar el gráfico
$grafico->Stroke();
?>
