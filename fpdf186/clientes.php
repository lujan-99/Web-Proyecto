<?php
require('fpdf.php');

// Incluir la conexión
include('../includes/conexion.php');

class PDF extends FPDF
{
    // Encabezado
    function Header()
    {
        // Logo
        $this->Image('../img/pagina/logo.jpg', 10, 6, 30);

        // Titulo
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(0, 207, 207); // Color del texto en el tono del logo
        $this->Cell(0, 10, 'Informe de Todos los Clientes', 0, 1, 'C');

        // Subtitulo con fecha
        $this->SetFont('Arial', 'I', 12);
        $this->SetTextColor(0);
        $fecha = date('d/m/Y');
        $this->Cell(0, 8, "Generado el: $fecha - Sistema del Gimnasio", 0, 1, 'C');
        $this->Ln(5);
    }

    // Pie de pagina
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, 'Gimnasio - Informe de Clientes | Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Crear instancia de PDF
$pdf = new PDF('L', 'mm', 'A4'); // Configuración horizontal
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Consultar todos los clientes
$sql_clientes = "
    SELECT 
        id_cliente, 
        nombre, 
        ci, 
        telefono, 
        estado, 
        fecha_registro 
    FROM clientes
";

$result_clientes = $con->query($sql_clientes);

if ($result_clientes->num_rows > 0) {
    // Encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(0, 207, 207); // Fondo en el tono del logo
    $pdf->SetTextColor(0);

    // Ancho de las columnas ajustado para llenar toda la página
    $widths = [15, 50, 40, 40, 35, 40, 50]; // Ajustar ancho para la nueva columna

    $pdf->Cell($widths[0], 10, 'ID', 1, 0, 'C', true);
    $pdf->Cell($widths[1], 10, 'Nombre', 1, 0, 'C', true);
    $pdf->Cell($widths[2], 10, 'CI', 1, 0, 'C', true);
    $pdf->Cell($widths[3], 10, 'Telefono', 1, 0, 'C', true);
    $pdf->Cell($widths[4], 10, 'Estado', 1, 0, 'C', true);
    $pdf->Cell($widths[5], 10, 'Fecha Registro', 1, 0, 'C', true);
    $pdf->Cell($widths[6], 10, 'Firmas', 1, 0, 'C', true);
    $pdf->Ln();

    // Datos de la tabla
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetFillColor(245, 245, 245); // Fondo gris claro para alternancia
    $pdf->SetTextColor(0);

    $fill = false;
    $activos = 0;
    $inactivos = 0;

    while ($row = $result_clientes->fetch_assoc()) {
        $pdf->Cell($widths[0], 10, $row['id_cliente'], 1, 0, 'C', $fill);
        $pdf->Cell($widths[1], 10, $row['nombre'], 1, 0, 'L', $fill);
        $pdf->Cell($widths[2], 10, $row['ci'], 1, 0, 'L', $fill);
        $pdf->Cell($widths[3], 10, $row['telefono'], 1, 0, 'L', $fill);
        $pdf->Cell($widths[4], 10, ucfirst($row['estado']), 1, 0, 'C', $fill);
        $pdf->Cell($widths[5], 10, $row['fecha_registro'], 1, 0, 'C', $fill);
        $pdf->Cell($widths[6], 10, '', 1, 0, 'C', $fill); // Columna de firmas vacía
        $pdf->Ln();

        $fill = !$fill;

        // Contar activos e inactivos
        if ($row['estado'] === 'activo') {
            $activos++;
        } else {
            $inactivos++;
        }
    }

    // Resumen de conteo
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(0, 207, 207);
    $pdf->Cell(0, 10, 'Resumen de Clientes', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0);
    $pdf->Cell(60, 10, 'Clientes Activos:', 1, 0, 'L');
    $pdf->Cell(30, 10, $activos, 1, 1, 'C');

    $pdf->Cell(60, 10, 'Clientes Inactivos:', 1, 0, 'L');
    $pdf->Cell(30, 10, $inactivos, 1, 1, 'C');
}

// Salida del PDF
$pdf->Output();
$con->close();
