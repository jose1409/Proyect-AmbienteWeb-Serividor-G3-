<?php
require_once __DIR__ . '/../../Controller/ProfesorController.php';
require_once __DIR__ . '/../../Controller/InstitucionController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y recibir los datos
    $cedula = filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING);
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $apellido1 = filter_input(INPUT_POST, 'apellido1', FILTER_SANITIZE_STRING);
    $apellido2 = filter_input(INPUT_POST, 'apellido2', FILTER_SANITIZE_STRING);
    $id_institucion = filter_input(INPUT_POST, 'id_institucion', FILTER_VALIDATE_INT);

    if ($cedula && $nombre && $apellido1 && $id_institucion) {
        try {
            // Validar si la institución existe
            $institucionController = new InstitucionController();
            $institucion = $institucionController->obtenerPorId($id_institucion);

            if ($institucion) {
                // Si la institución existe, proceder a insertar el profesor
                $controller = new ProfesorController();
                $profesor = new Profesor(null, $cedula, $nombre, $apellido1, $apellido2, $id_institucion);

                if ($controller->insertar($profesor)) {
                    // Redirigir con mensaje de éxito
                    header("Location: ../../profesor.php?success=1");
                    exit;
                } else {
                    // Redirigir con mensaje de error 
                    header("Location: ../../profesor.php?error=insert");
                    exit;
                }
            } else {
                // Si la institución no existe, redirigir con mensaje de error
                header("Location: ../../profesor.php?error=invalid_institution");
                exit;
            }
        } catch (Exception $e) {
            header("Location: ../../profesor.php?error=exception&message=" . urlencode($e->getMessage()));
            exit;
        }
    } else {
        header("Location: ../../profesor.php?error=missing_fields");
        exit;
    }
}
