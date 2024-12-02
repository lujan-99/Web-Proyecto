<?php
session_start();
include('../includes/conexion.php');

require_once("../jpgraph/jpgraph.php");
require_once("../jpgraph/jpgraph_pie.php");
require_once("../jpgraph/jpgraph_bar.php");

// Obtener la opción seleccionada desde el parámetro GET
$option = isset($_GET['option']) ? $_GET['option'] : 0;

// Comportamiento basado en `option`
if (!$option) {
    // Consulta para la gráfica de pastel (usuarios que registraron más suscripciones)
    $query = "SELECT usuario, COUNT(*) AS total
              FROM suscripciones
              GROUP BY usuario
              ORDER BY total DESC";
    $result = $con->query($query);

    // Arreglos para los datos
    $usuarios = [];
    $valores = [];

    while ($row = $result->fetch_assoc()) {
        $usuarios[] = "{$row['usuario']} ({$row['total']})";
        $valores[] = $row['total'];
    }

    // Configurar gráfico de pastel
    $grafico = new PieGraph(800, 500, 'auto');
    $grafico->SetShadow();
    $grafico->title->Set("Usuarios que Registraron Más Suscripciones");
    $grafico->title->SetFont(FF_FONT2, FS_BOLD, 16);

    $pastel = new PiePlot($valores);
    $pastel->SetSize(0.35);
    $pastel->SetCenter(0.5, 0.5);
    $pastel->SetLegends($usuarios);
    $pastel->SetSliceColors(["#08e6db", "#77b300", "#e53030", "#005580"]);
    $pastel->SetLabelType(PIE_VALUE_PER);
    $pastel->value->SetFormat('%2.1f%%');
    $pastel->value->SetColor("#333333");

    $grafico->Add($pastel);

    // Mostrar gráfico de pastel
    $grafico->Stroke();
} else {
    // Gráfico de barras para un usuario específico
    $query = "SELECT MONTH(s.fecha) AS mes, COUNT(*) AS total
              FROM suscripciones s
              WHERE s.usuario = '$opcion'
              GROUP BY MONTH(s.fecha)";
    $result = $con->query($query);

    $meses = [];
    $valores = [];
    $nombres_meses = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];

    while ($row = $result->fetch_assoc()) {
        $meses[] = $nombres_meses[$row['mes'] - 1];
        $valores[] = $row['total'];
    }

    // Configurar gráfico de barras
    $grafico = new Graph(900, 500, 'auto');
    $grafico->SetScale("textlin");
    $grafico->SetMargin(50, 30, 50, 100);
    $grafico->title->Set("Suscripciones Registradas por $opcion");
    $grafico->title->SetFont(FF_FONT2, FS_BOLD, 16);

    $grafico->xaxis->SetTickLabels($meses);
    $grafico->xaxis->SetTitle("Meses", "center");
    $grafico->yaxis->SetTitle("Suscripciones", "center");

    $barplot = new BarPlot($valores);
    $barplot->SetFillColor($colores['barras']);
    $grafico->Add($barplot);

    // Mostrar gráfico de barras
    $grafico->Stroke();
}
?>
