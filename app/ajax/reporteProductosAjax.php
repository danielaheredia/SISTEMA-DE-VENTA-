<?php

require_once "../pdf/fpdf.php"; // ✅ ESTA es la que necesitas
require_once "../models/mainModel.php";



use app\models\mainModel;


$accion = $_POST['accion'] ?? '';
$fecha_inicio = $_POST['fecha_inicio'] ?? '';
$fecha_fin = $_POST['fecha_fin'] ?? '';

if (!$fecha_inicio || !$fecha_fin) {
    die("Fechas no válidas");
}

$mainModel = new mainModel(); // ✅ crear una instancia
class ConexionHelper extends mainModel {
    public function obtenerConexion() {
        return $this->conectar();
    }
}

$conexion = (new ConexionHelper())->obtenerConexion(); // ✅ FUNCIONA


$sql = $conexion->prepare("
    SELECT p.producto_nombre,
           SUM(vd.venta_detalle_cantidad) AS cantidad_vendida,
           vd.venta_detalle_precio_venta AS precio_unitario,
           SUM(vd.venta_detalle_total) AS total_recaudado,
           v.venta_fecha
    FROM venta_detalle vd
    INNER JOIN producto p ON vd.producto_id = p.producto_id
    INNER JOIN venta v ON vd.venta_codigo = v.venta_codigo
    WHERE v.venta_fecha BETWEEN :fecha_inicio AND :fecha_fin
    GROUP BY p.producto_nombre, vd.venta_detalle_precio_venta, v.venta_fecha
    ORDER BY v.venta_fecha ASC
");

$sql->bindParam(':fecha_inicio', $fecha_inicio);
$sql->bindParam(':fecha_fin', $fecha_fin);
$sql->execute();

$datos = $sql->fetchAll(PDO::FETCH_ASSOC);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Productos Vendidos', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(60, 10, 'Producto', 1);
$pdf->Cell(30, 10, 'Cantidad', 1);
$pdf->Cell(30, 10, 'Precio Unitario', 1);
$pdf->Cell(40, 10, 'Total Recaudado', 1);
$pdf->Cell(30, 10, 'Fecha', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
foreach ($datos as $row) {
    $pdf->Cell(60, 10, utf8_decode($row['producto_nombre']), 1);
    $pdf->Cell(30, 10, $row['cantidad_vendida'], 1);
    $pdf->Cell(30, 10, '$' . number_format($row['precio_unitario'], 2), 1);
    $pdf->Cell(40, 10, '$' . number_format($row['total_recaudado'], 2), 1);
    $pdf->Cell(30, 10, $row['venta_fecha'], 1);
    $pdf->Ln();
}

if ($accion == 'descargar') {
    $pdf->Output("D", "reporte_productos.pdf");
} else {
    $pdf->Output(); // Muestra en navegador
}
