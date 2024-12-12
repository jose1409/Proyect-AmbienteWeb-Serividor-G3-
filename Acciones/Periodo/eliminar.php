<?php
require_once '../../Controller/PeriodoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_periodo = filter_input(INPUT_POST, 'id_periodo', FILTER_VALIDATE_INT);

    if ($action === 'eliminar' && $id_periodo) {
        try {
            // Crear una instancia del controlador
            $controller = new PeriodoController();

            // Eliminar el periodo
            if ($controller->eliminar($id_periodo)) {
                header("Location: ../../periodo.php");
                exit;
            } else {
                header("Location: ../../periodo.php?error=No se pudo eliminar el periodo");
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Acción no válida.";
    }
}
