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
        $this->Cell(0, 10, 'Informe de Pagos Disponibles', 0, 1, 'C');

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
        $this->Cell(0, 10, 'Gimnasio - Informe de Pagos | Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Crear instancia de PDF
$pdf = new PDF('L', 'mm', 'A4'); // Configuracion horizontal
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Consultar pagos disponibles
$sql_pagos = "
    SELECT 
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
    JOIN planes_suscripcion p ON s.id_plan = p.id_plan
";

$result_pagos = $con->query($sql_pagos);

if ($result_pagos->num_rows > 0) {
    // Encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(0, 207, 207); // Fondo en el tono del logo
    $pdf->SetTextColor(0);

    // Ancho de las columnas ajustado para llenar toda la pagina
    $widths = [15, 50, 40, 40, 45, 25, 25, 25, 20];

    $pdf->Cell($widths[0], 10, 'ID', 1, 0, 'C', true);
    $pdf->Cell($widths[1], 10, 'Cliente', 1, 0, 'C', true);
    $pdf->Cell($widths[2], 10, 'CI', 1, 0, 'C', true);
    $pdf->Cell($widths[3], 10, 'Telefono', 1, 0, 'C', true);
    $pdf->Cell($widths[4], 10, 'Plan', 1, 0, 'C', true);
    $pdf->Cell($widths[5], 10, 'Precio', 1, 0, 'C', true);
    $pdf->Cell($widths[6], 10, 'Duracion', 1, 0, 'C', true);
    $pdf->Cell($widths[7], 10, 'Pago', 1, 0, 'C', true);
    $pdf->Cell($widths[8], 10, 'Usuario', 1, 0, 'C', true);
    $pdf->Ln();

    // Datos de la tabla
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetFillColor(245, 245, 245); // Fondo gris claro para alternancia
    $pdf->SetTextColor(0);

    $fill = false;
    $ventas_por_usuario = [];
    $ventas_por_plan = [];

    while ($row = $result_pagos->fetch_assoc()) {
        $pdf->Cell($widths[0], 10, $row['id_suscripcion'], 1, 0, 'C', $fill);
        $pdf->Cell($widths[1], 10, $row['cliente'], 1, 0, 'L', $fill);
        $pdf->Cell($widths[2], 10, $row['ci'], 1, 0, 'L', $fill);
        $pdf->Cell($widths[3], 10, $row['telefono'], 1, 0, 'L', $fill);
        $pdf->Cell($widths[4], 10, $row['plan'], 1, 0, 'L', $fill);
        $pdf->Cell($widths[5], 10, $row['precio'] . ' Bs', 1, 0, 'R', $fill);
        $pdf->Cell($widths[6], 10, $row['duracion'] . ' dias', 1, 0, 'C', $fill);
        $pdf->Cell($widths[7], 10, ucfirst($row['tipo_pago']), 1, 0, 'L', $fill);
        $pdf->Cell($widths[8], 10, $row['usuario'], 1, 0, 'L', $fill);
        $pdf->Ln();

        $fill = !$fill;

        // Contar ventas por usuario
        if (!isset($ventas_por_usuario[$row['usuario']])) {
            $ventas_por_usuario[$row['usuario']] = 0;
        }
        $ventas_por_usuario[$row['usuario']]++;

        // Contar ventas por plan
        if (!isset($ventas_por_plan[$row['plan']])) {
            $ventas_por_plan[$row['plan']] = 0;
        }
        $ventas_por_plan[$row['plan']]++;
    }
}

// Resumen por usuario
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 207, 207);
$pdf->Cell(0, 10, 'Resumen de Ventas por Usuario', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0);
foreach ($ventas_por_usuario as $usuario => $ventas) {
    $pdf->Cell(120, 10, "Usuario: $usuario", 1, 0, 'L');
    $pdf->Cell(40, 10, "Ventas: $ventas", 1, 0, 'C');
    $pdf->Ln();
}

// Resumen por plan
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 207, 207);
$pdf->Cell(0, 10, 'Resumen de Ventas por Tipo de Suscripcion', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0);
foreach ($ventas_por_plan as $plan => $ventas) {
    $pdf->Cell(120, 10, "Plan: $plan", 1, 0, 'L');
    $pdf->Cell(40, 10, "Ventas: $ventas", 1, 0, 'C');
    $pdf->Ln();
}

// Salida del PDF
$pdf->Output();
$con->close();
