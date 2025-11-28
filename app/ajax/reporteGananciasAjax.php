<?php

require_once "../pdf/fpdf.php";
require_once "../models/mainModel.php";

use app\models\mainModel;

// Clase para acceder a conectar()
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

// Consulta de ingresos y ganancias por día
$sql = $conexion->prepare("
    SELECT v.venta_fecha,
           SUM(vd.venta_detalle_precio_venta * vd.venta_detalle_cantidad) AS ingresos,
           SUM((vd.venta_detalle_precio_venta - vd.venta_detalle_precio_compra) * vd.venta_detalle_cantidad) AS ganancia
    FROM venta v
    INNER JOIN venta_detalle vd ON v.venta_codigo = vd.venta_codigo
    WHERE v.venta_fecha BETWEEN :fecha_inicio AND :fecha_fin
    GROUP BY v.venta_fecha
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
$pdf->Cell(0, 10, 'Reporte de Ganancias', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 10, 'Fecha', 1);
$pdf->Cell(60, 10, 'Ingresos', 1);
$pdf->Cell(60, 10, 'Ganancia', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
foreach ($datos as $row) {
    $pdf->Cell(50, 10, $row['venta_fecha'], 1);
    $pdf->Cell(60, 10, '$' . number_format($row['ingresos'], 2), 1);
    $pdf->Cell(60, 10, '$' . number_format($row['ganancia'], 2), 1);
    $pdf->Ln();
}

if ($accion == 'descargar') {
    $pdf->Output("D", "reporte_ganancias.pdf");
} else {
    $pdf->Output(); // Muestra en navegador
}
