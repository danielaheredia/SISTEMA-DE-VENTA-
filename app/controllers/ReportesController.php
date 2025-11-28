public function reporteProductosPDF($fechaInicio, $fechaFin) {
    require_once "./app/pdf/fpdf.php";

    $pdf = new \FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, "Reporte de Productos", 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Desde: $fechaInicio   Hasta: $fechaFin", 0, 1);

    // Aquí agregas los datos de productos

    $pdf->Output('I', "reporte_productos.pdf");
}

