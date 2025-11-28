<?php
require_once "./app/controllers/ReportesController.php";
require_once "../pdf/fpdf.php"; // ✅ ESTA es la que necesitas


use app\controllers\ReportesController;

$controller = new ReportesController();
$controller->reporteProductosPDF($_POST['fecha_inicio'], $_POST['fecha_fin']);
exit;
