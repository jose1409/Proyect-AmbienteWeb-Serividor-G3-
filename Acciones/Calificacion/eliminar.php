<?php
require_once '../../Controller/CalificacionController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_calificacion = filter_input(INPUT_POST, 'id_calificacion', FILTER_VALIDATE_INT);

    if ($action === 'eliminar' && $id_calificacion) {
        try {
            // Crear una instancia del controlador
            $controller = new CalificacionController();

            // Eliminar el calificacion
            if ($controller->eliminar($id_calificacion)) {
                header("Location: ../../calificacion.php?success=1");
                exit;
            } else {
                header("Location: ../../calificacion.php?error=delete");
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Acción no válida.";
    }
}
