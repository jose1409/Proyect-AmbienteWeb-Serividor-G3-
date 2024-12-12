<?php
require_once '../../Controller/AsignaturaController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_asignatura = $_POST['id_asignatura'] ?? null;

    try {
        $controller = new AsignaturaController();

        if ($action === 'eliminar' && $id_asignatura) {
            if ($controller->eliminar($id_asignatura)) {
                header("Location: ../../asignatura.php");
                exit;
            } else {
                header("Location: ../../asignatura.php");
                exit;
            }
        }
    } catch (Exception $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
}
