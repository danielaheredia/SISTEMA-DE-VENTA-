
<?php require_once "./config/app.php"; ?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Biblioteca de Reportes</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f8f9fa;
            }
            .card-title {
                font-weight: 600;
            }
            .icono {
                width: 50px;
            }
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <h2 class="mb-4">📚 Biblioteca de Reportes</h2>

            <!-- Reporte de Productos -->
            <!-- Reporte de Productos -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="http://localhost/VENTAS/app/views/fotos/producto.png" class="icono me-3" alt="Icono">
                        <div>
                            <h5 class="card-title mb-0">Reporte de Productos</h5>
                            <small class="text-muted">Visualiza los productos más y menos vendidos por fecha.</small>
                        </div>
                    </div>

                    <form action="<?php echo APP_URL; ?>app/ajax/reporteProductosAjax.php" method="POST" target="_blank" class="row g-2">
                        <div class="col-md-5">
                            <input type="date" name="fecha_inicio" class="form-control" required>
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="fecha_fin" class="form-control" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" name="accion" value="ver" class="btn btn-primary me-2 w-100">
                                📄 Ver Reporte
                            </button>
                            <button type="submit" name="accion" value="descargar" class="btn btn-success w-100">
                                📥 Descargar
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Reporte de Cajas / Vendedores -->
            <!-- Reporte de Cajas / Vendedores -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?php echo APP_URL; ?>app/views/fotos/vendedores.png" class="icono me-3" alt="Icono">
                        <div>
                            <h5 class="card-title mb-0">Reporte de Cajas / Vendedores</h5>
                            <small class="text-muted">Consulta las ventas por vendedor y caja en un periodo.</small>
                        </div>
                    </div>

                    <form action="<?php echo APP_URL; ?>app/ajax/reporteCajasAjax.php" method="POST" target="_blank" class="row g-2">
                        <div class="col-md-5">
                            <input type="date" name="fecha_inicio" class="form-control" required>
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="fecha_fin" class="form-control" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" name="accion" value="ver" class="btn btn-primary me-2 w-100">
                                📄 Ver Reporte
                            </button>
                            <button type="submit" name="accion" value="descargar" class="btn btn-success w-100">
                                📥 Descargar
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Reporte de Ganancias -->
            <!-- Reporte de Ganancias -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?php echo APP_URL; ?>app/views/fotos/ganancias.png" class="icono me-3" alt="Icono">
                        <div>
                            <h5 class="card-title mb-0">Reporte de Ganancias</h5>
                            <small class="text-muted">Muestra el total de ingresos y ganancias por período.</small>
                        </div>
                    </div>

                    <form action="<?php echo APP_URL; ?>app/ajax/reporteGananciasAjax.php" method="POST" target="_blank" class="row g-2">
                        <div class="col-md-5">
                            <input type="date" name="fecha_inicio" class="form-control" required>
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="fecha_fin" class="form-control" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" name="accion" value="ver" class="btn btn-primary me-2 w-100">
                                📄 Ver Reporte
                            </button>
                            <button type="submit" name="accion" value="descargar" class="btn btn-success w-100">
                                📥 Descargar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

<script>
	const APP_URL = "<?php echo APP_URL; ?>";
</script>
