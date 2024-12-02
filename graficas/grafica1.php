<?php
// Iniciar sesión y conexión a la base de datos
session_start();
include('../includes/conexion.php');

require_once("../jpgraph/jpgraph.php");
require_once("../jpgraph/jpgraph_bar.php");

// COLORES CONFIGURABLES
$colores = [
    'barras' => "#5fe71b",      // Color de las barras
    'fondo_grafico' => "#ffffff", // Fondo del gráfico
    'titulo' => "#5fe71b",       // Color del título
    'texto_ejes' => "#000000",   // Color del texto de los ejes
    'lineas_cuadricula' => "#cccccc", // Color de las líneas de cuadrícula
    'valores_barras' => "#000000" // Color de los valores sobre las barras
];

// Obtener la opción seleccionada desde el parámetro GET
$opcion = isset($_GET['option']) ? intval($_GET['option']) : 0;

// Construir la consulta SQL según la opción
switch ($opcion) {
    case 1: // Mostrar registros del mes actual
        $query = "SELECT DAY(fecha_registro) AS dia, COUNT(*) AS total 
                  FROM clientes 
                  WHERE MONTH(fecha_registro) = MONTH(CURDATE())
                  GROUP BY DAY(fecha_registro)";
        $titulo = "Clientes Registrados en el Mes Actual";
        $ejeX = "Días";
        break;

    case 2: // Mostrar registros de la semana actual
        $query = "SELECT DAY(fecha_registro) AS dia, COUNT(*) AS total 
                  FROM clientes 
                  WHERE WEEK(fecha_registro) = WEEK(CURDATE())
                  GROUP BY DAY(fecha_registro)";
        $titulo = "Clientes Registrados en la Semana Actual";
        $ejeX = "Días";
        break;

    case 3: // Mostrar registros del día actual
        $query = "SELECT HOUR(fecha_registro) AS hora, COUNT(*) AS total 
                  FROM clientes 
                  WHERE DATE(fecha_registro) = CURDATE()
                  GROUP BY HOUR(fecha_registro)";
        $titulo = "Clientes Registrados Hoy";
        $ejeX = "Horas";
        break;

    default: // Mostrar registros por mes (opción por defecto)
        $query = "SELECT MONTH(fecha_registro) AS mes, COUNT(*) AS total 
                  FROM clientes 
                  GROUP BY MONTH(fecha_registro)";
        $titulo = "Clientes Registrados por Mes";
        $ejeX = "Meses";
        break;
}

// Ejecutar la consulta
$result = $con->query($query);

// Arreglos para los datos
$etiquetas = [];
$totales = [];
$maximo = 0;

// Nombres de los meses (si aplica)
$nombres_meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

// Procesar los resultados de la consulta
while ($row = $result->fetch_assoc()) {
    if ($opcion === 0) {
        $etiquetas[] = $nombres_meses[$row['mes'] - 1];
    } else {
        $etiquetas[] = $row['dia'] ?? $row['hora'];
    }
    $totales[] = $row['total'];
    if ($row['total'] > $maximo) {
        $maximo = $row['total'];
    }
}

// Ajustar el valor máximo para que no parezca que las barras chocan
$maximo += 1;

// Crear el gráfico de barras
$grafico = new Graph(900, 500, 'auto');
$grafico->SetScale("textlin", 0, $maximo); // Escala desde 0 hasta el valor máximo calculado
$grafico->SetMargin(50, 30, 50, 100);
$grafico->SetBox(true);
$grafico->SetShadow();
$grafico->xaxis->SetTickLabels($etiquetas);
$grafico->xaxis->SetTitle($ejeX, "center");
$grafico->xaxis->SetColor($colores['texto_ejes']);
$grafico->yaxis->SetTitle("Clientes Registrados", "center");
$grafico->yaxis->SetColor($colores['texto_ejes']);
$grafico->SetBackgroundGradient($colores['fondo_grafico'], $colores['fondo_grafico'], GRAD_HOR);

// Crear las barras
$barplot = new BarPlot($totales);
$barplot->SetFillColor($colores['barras']); // Color de las barras
$barplot->SetWidth(0.6); // Ancho de las barras

// Mostrar etiquetas de valor sobre cada barra
$barplot->value->Show();
$barplot->value->SetFormat('%d');
$barplot->value->SetColor($colores['valores_barras']);
$barplot->value->SetFont(FF_FONT1, FS_BOLD);

// Agregar las barras al gráfico
$grafico->Add($barplot);

// Título de la gráfica
$grafico->title->Set($titulo);
$grafico->title->SetFont(FF_FONT2, FS_BOLD, 14);
$grafico->title->SetColor($colores['titulo']);

// Estilizar las líneas de cuadrícula
$grafico->ygrid->SetColor($colores['lineas_cuadricula']);
$grafico->ygrid->Show(true, true); // Mostrar líneas horizontales y verticales

// Mostrar el gráfico
$grafico->Stroke();
?>
