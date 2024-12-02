<?php
// Iniciar sesión y conexión a la base de datos
session_start();
include('../includes/conexion.php');

require_once("../jpgraph/jpgraph.php");
require_once("../jpgraph/jpgraph_pie.php");

// COLORES CONFIGURABLES
$colores = [
    "#5fe71b", "#e53030", "#08e6db", "#ff1212", 
    "#77b300", "#005580", "#4e4e4e", "#224747", "#0f0"
];

// Obtener la opción seleccionada desde el parámetro GET
$opcion = isset($_GET['option']) ? intval($_GET['option']) : 0;

// Construir la consulta SQL según la opción
switch ($opcion) {
    case 1: // Clientes activos
        $query = "SELECT ps.nombre_plan, COUNT(s.id_plan) AS total 
                  FROM suscripciones s
                  JOIN planes_suscripcion ps ON s.id_plan = ps.id_plan
                  JOIN clientes c ON s.id_cliente = c.id_cliente
                  WHERE c.dias_restantes > 0
                  GROUP BY s.id_plan 
                  ORDER BY total DESC";
        $titulo = "Planes de Suscripción de Clientes Activos";
        break;

    case 2: // Planes activos
        $query = "SELECT ps.nombre_plan, COUNT(s.id_plan) AS total 
                  FROM suscripciones s
                  JOIN planes_suscripcion ps ON s.id_plan = ps.id_plan
                  WHERE ps.estado_plan = 'activo'
                  GROUP BY s.id_plan 
                  ORDER BY total DESC";
        $titulo = "Planes Activos Más Comprados";
        break;

    default: // Todos los planes
        $query = "SELECT ps.nombre_plan, COUNT(s.id_plan) AS total 
                  FROM suscripciones s
                  JOIN planes_suscripcion ps ON s.id_plan = ps.id_plan
                  GROUP BY s.id_plan 
                  ORDER BY total DESC";
        $titulo = "Porcentaje de Cada Plan de Suscripción";
        break;
}

// Ejecutar la consulta
$result = $con->query($query);

// Verificar resultados
if (!$result) {
    die("Error en la consulta: " . $con->error);
}

// Arreglos para los datos
$planes = [];
$totales = [];
$total_suscripciones = 0;

// Procesar los resultados de la consulta
while ($row = $result->fetch_assoc()) {
    $planes[] = $row['nombre_plan'];
    $totales[] = $row['total'];
    $total_suscripciones += $row['total'];
}

// Crear el gráfico de pastel recto
$grafico = new PieGraph(800, 500, 'auto');
$grafico->SetShadow(); // Sombra para el gráfico
$grafico->SetMargin(40, 40, 40, 100); // Márgenes ajustados
$grafico->title->Set($titulo);
$grafico->title->SetFont(FF_FONT2, FS_BOLD, 16);
$grafico->title->SetColor("#005580"); // Título con color destacado

// Agregar texto adicional para el total de suscripciones
$grafico->subtitle->Set("Total de Suscripciones: $total_suscripciones");
$grafico->subtitle->SetFont(FF_FONT1, FS_BOLD, 12);
$grafico->subtitle->SetColor("#333333"); // Color del subtítulo

// Crear el gráfico de pastel recto
$pastel = new PiePlot($totales);
$pastel->SetSize(0.35); // Ajustar el tamaño del gráfico
$pastel->SetCenter(0.5, 0.5); // Centrar el gráfico
$pastel->SetLegends($planes); // Leyendas con los nombres de los planes

// Personalizar las secciones del pastel
$pastel->SetSliceColors($colores); // Aplicar colores personalizados
$pastel->SetLabelType(PIE_VALUE_PER); // Mostrar porcentajes
$pastel->value->SetFormat('%2.1f%%'); // Formato de porcentaje
$pastel->value->SetFont(FF_FONT1, FS_BOLD); // Estilo de las etiquetas
$pastel->value->SetColor("#333333"); // Color de las etiquetas

// Agregar el gráfico de pastel al gráfico principal
$grafico->Add($pastel);

// Mostrar el gráfico
$grafico->Stroke();
?>
