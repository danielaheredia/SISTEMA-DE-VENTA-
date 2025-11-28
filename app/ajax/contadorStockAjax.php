<?php
require_once "../../config/app.php";
require_once "../../config/server.php";

// Conexión con mysqli
$conexion = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Verificar si hay errores en la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener productos con stock bajo
$sql = "SELECT producto_nombre, producto_Stock_total FROM producto WHERE producto_Stock_total <= 10";
$resultado = $conexion->query($sql);

// Verificar si la consulta fue exitosa
if ($resultado) {
    $productos = [];

    // Obtener los resultados en formato de array
    while ($row = $resultado->fetch_assoc()) {
        $productos[] = $row;
    }

    // Devolver los datos como JSON
    echo json_encode([
        'total' => count($productos),
        'productos' => $productos
    ]);
} else {
    echo json_encode([
        'total' => 0,
        'productos' => []
    ]);
}

// Cerrar la conexión
$conexion->close();
?>
