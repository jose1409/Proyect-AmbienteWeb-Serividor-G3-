<?php
require_once '../../Controller/ProfesorController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_profesor = filter_input(INPUT_POST, 'id_profesor', FILTER_VALIDATE_INT);

    if ($action === 'editar' && $id_profesor) {
        $cedula = filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $apellido1 = filter_input(INPUT_POST, 'apellido1', FILTER_SANITIZE_STRING);
        $apellido2 = filter_input(INPUT_POST, 'apellido2', FILTER_SANITIZE_STRING);
        $id_institucion = filter_input(INPUT_POST, 'id_institucion', FILTER_VALIDATE_INT);

        if ($cedula && $nombre && $apellido1 && $id_institucion) {
            try {
                // Crear una instancia del controlador
                $controller = new ProfesorController();

                // Crear un objeto Profesor
                $profesor = new Profesor($id_profesor, $cedula, $nombre, $apellido1, $apellido2, $id_institucion);

                // Actualizar el profesor
                if ($controller->actualizar($profesor)) {
                    header("Location: ../../profesor.php");
                    exit;
                } else {
                    header("Location: ../../profesor.php?error=No se pudo actualizar el profesor");
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
