<?php
require_once '../../Controller/InstitucionController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_institucion = $_POST['id_institucion'] ?? null;

    try {
        $controller = new InstitucionController();

        if ($action === 'editar' && $id_institucion) {
            $nombre_institucion = filter_input(INPUT_POST, 'nombre_institucion', FILTER_SANITIZE_STRING);

            $institucion = new Institucion($id_institucion, $nombre_institucion);

            if ($controller->actualizar($institucion)) {
                header("Location: ../../institucion.php");
                exit;
            } else {
                header("Location: ../../institucion.php");
                exit;
            }
        }
    } catch (Exception $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
}
