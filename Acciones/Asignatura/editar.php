<?php
require_once '../../Controller/AsignaturaController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_asignatura = $_POST['id_asignatura'] ?? null;

    try {
        $controller = new AsignaturaController();

        if ($action === 'editar' && $id_asignatura) {
            $nombre_asignatura = filter_input(INPUT_POST, 'nombre_asignatura', FILTER_SANITIZE_STRING);

            $asignatura = new Asignatura($id_asignatura, $nombre_asignatura);
            
            if ($controller->actualizar($asignatura)) {
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