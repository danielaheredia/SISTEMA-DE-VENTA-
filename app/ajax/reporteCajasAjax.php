<?php

require_once "../pdf/fpdf.php";
require_once "../models/mainModel.php";

use app\models\mainModel;

class ConexionHelper extends mainModel {
    public function obtenerConexion() {
        return $this->conectar();
    }
}

$accion = $_POST['accion'] ?? '';
$fecha_inicio = $_POST['fecha_inicio'] ?? '';
$fecha_fin = $_POST['fecha_fin'] ?? '';

if (!$fecha_inicio || !$fecha_fin) {
    die("Fechas no válidas");
}

$conexion = (new ConexionHelper())->obtenerConexion();

// Consulta de ventas por vendedor y caja
$sql = $conexion->prepare("
    SELECT u.usuario_nombre,
           u.usuario_apellido,
           c.caja_nombre,
           v.venta_fecha,
           SUM(v.venta_total) AS total_vendido
    FROM venta v
    INNER JOIN usuario u ON v.usuario_id = u.usuario_id
    INNER JOIN caja c ON v.caja_id = c.caja_id
    WHERE v.venta_fecha BETWEEN :fecha_inicio AND :fecha_fin
    GROUP BY u.usuario_id, c.caja_id, v.venta_fecha
    ORDER BY v.venta_fecha ASC
");

$sql->bindParam(':fecha_inicio', $fecha_inicio);
$sql->bindParam(':fecha_fin', $fecha_fin);
$sql->execute();

$datos = $sql->fetchAll(PDO::FETCH_ASSOC);

// Generar PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Ventas por Vendedor y Caja', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Fecha', 1);
$pdf->Cell(50, 10, 'Vendedor', 1);
$pdf->Cell(50, 10, 'Caja', 1);
$pdf->Cell(50, 10, 'Total Vendido', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
foreach ($datos as $row) {
    $vendedor = utf8_decode($row['usuario_nombre'] . ' ' . $row['usuario_apellido']);
    $pdf->Cell(40, 10, $row['venta_fecha'], 1);
    $pdf->Cell(50, 10, $vendedor, 1);
    $pdf->Cell(50, 10, utf8_decode($row['caja_nombre']), 1);
    $pdf->Cell(50, 10, '$' . number_format($row['total_vendido'], 2), 1);
    $pdf->Ln();
}

if ($accion == 'descargar') {
    $pdf->Output("D", "reporte_cajas_vendedores.pdf");
} else {
    $pdf->Output(); // Muestra en navegador
}
