<?php
require_once '../../Controller/InstitucionController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_institucion = $_POST['id_institucion'] ?? null;

    try {
        $controller = new InstitucionController();

        if ($action === 'eliminar' && $id_institucion) {
            if ($controller->eliminar($id_institucion)) {
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
?>
