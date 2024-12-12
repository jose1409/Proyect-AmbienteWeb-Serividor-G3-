<?php
require_once __DIR__ . '/../../Controller/PeriodoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y recibir los datos
    $nombre_periodo = filter_input(INPUT_POST, 'nombre_periodo', FILTER_SANITIZE_STRING);
    $fecha_inicio = filter_input(INPUT_POST, 'fecha_inicio', FILTER_SANITIZE_STRING);
    $fecha_fin = filter_input(INPUT_POST, 'fecha_fin', FILTER_SANITIZE_STRING);

    if ($nombre_periodo && $fecha_inicio && $fecha_fin) {
        try {
            // Crear una instancia del controlador
            $controller = new PeriodoController();

            // Crear un objeto Periodo
            $periodo = new Periodo(null, $nombre_periodo, $fecha_inicio, $fecha_fin);

            // Insertar el periodo
            if ($controller->insertar($periodo)) {
                // Redirigir con mensaje de éxito
                header("Location: ../../periodo.php");
                exit;
            } else {
                // Redirigir con mensaje de error
                header("Location: ../../periodo.php");
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
} else {
    echo "Método no permitido.";
}
