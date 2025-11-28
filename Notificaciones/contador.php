<?php
require_once "../config/app.php";
require_once "../config/server.php";
require_once "../autoload.php";

// Conexión con mysqli
$conexion = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Verificar si hubo error en la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Establecer el límite de stock bajo
$limite_stock_bajo = 10;

// Preparar la consulta
$stmt = $conexion->prepare("SELECT COUNT(*) AS total FROM producto WHERE producto_stock_total <= ? AND producto_estado = 'Habilitado'");
$stmt->bind_param("i", $limite_stock_bajo);
$stmt->execute();

// Obtener resultado
$resultado = $stmt->get_result();
$fila = $resultado->fetch_assoc();

// Mostrar el resultado en JSON
echo json_encode(['total' => $fila['total']]);

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>
