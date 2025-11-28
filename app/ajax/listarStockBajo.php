<?php
require_once "../../config/server.php";
require_once "../../config/app.php";

// Crear la conexión
$conexion = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Verificar la conexión
if ($conexion->connect_error) {
    echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
    exit;
}

// Consulta SQL para obtener productos con bajo stock
$consulta = "SELECT producto_nombre, producto_stock_total
             FROM producto
             WHERE producto_stock_total <= 10 
             AND producto_estado = 'Habilitado'";

// Ejecutar la consulta
$resultado = $conexion->query($consulta);

// Verificar si la consulta fue exitosa
if (!$resultado) {
    echo json_encode(['error' => 'Error en la consulta']);
    exit;
}

// Almacenar los resultados
$datos = [];
while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}

// Cerrar la conexión
$conexion->close();

// Configurar el tipo de contenido para JSON
header('Content-Type: application/json');

// Enviar la respuesta en formato JSON
echo json_encode($datos);
?>
