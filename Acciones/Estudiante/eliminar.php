<?php
require_once '../../Controller/EstudianteController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_estudiante = filter_input(INPUT_POST, 'id_estudiante', FILTER_VALIDATE_INT);

    if ($action === 'eliminar' && $id_estudiante) {
        try {
            // Crear una instancia del controlador
            $controller = new EstudianteController();

            // Eliminar el estudiante
            if ($controller->eliminar($id_estudiante)) {
                header("Location: ../../estudiante.php?success=1");
                exit;
            } else {
                header("Location: ../../estudiante.php?error=delete");
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Acción no válida.";
    }
}
