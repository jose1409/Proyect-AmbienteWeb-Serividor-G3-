<?php
require_once '../../Controller/ProfesorController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_profesor = filter_input(INPUT_POST, 'id_profesor', FILTER_VALIDATE_INT);

    if ($action === 'eliminar' && $id_profesor) {
        try {
            // Crear una instancia del controlador
            $controller = new ProfesorController();

            // Eliminar el profesor
            if ($controller->eliminar($id_profesor)) {
                header("Location: ../../profesor.php");
                exit;
            } else {
                header("Location: ../../profesor.php?error=No se pudo eliminar el profesor");
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Acción no válida.";
    }
}
