<?php
require_once '../../Controller/PeriodoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_periodo = filter_input(INPUT_POST, 'id_periodo', FILTER_VALIDATE_INT);

    if ($action === 'editar' && $id_periodo) {
        $nombre_periodo = filter_input(INPUT_POST, 'nombre_periodo', FILTER_SANITIZE_STRING);
        $fecha_inicio = filter_input(INPUT_POST, 'fecha_inicio', FILTER_SANITIZE_STRING);
        $fecha_fin = filter_input(INPUT_POST, 'fecha_fin', FILTER_SANITIZE_STRING);

        if ($nombre_periodo && $fecha_inicio && $fecha_fin) {
            try {
                // Crear una instancia del controlador
                $controller = new PeriodoController();

                // Crear un objeto Periodo
                $periodo = new Periodo($id_periodo, $nombre_periodo, $fecha_inicio, $fecha_fin);

                // Actualizar el periodo
                if ($controller->actualizar($periodo)) {
                    header("Location: ../../periodo.php");
                    exit;
                } else {
                    header("Location: ../../periodo.php?error=No se pudo actualizar el periodo");
                    exit;
                }
            } catch (Exception $e) {
                echo "Error: " . htmlspecialchars($e->getMessage());
            }
        } else {
            echo "Todos los campos obligatorios deben ser completados.";
        }
    } else {
        echo "Acción no válida.";
    }
}
