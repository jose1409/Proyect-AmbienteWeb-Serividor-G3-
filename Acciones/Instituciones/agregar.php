<?php
require_once __DIR__ . '/../../Controller/InstitucionController.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y recibir los datos
    $nombre_institucion = filter_input(INPUT_POST, 'nombre_institucion', FILTER_SANITIZE_STRING);

    if ($nombre_institucion) {
        try {
            // Crear una instancia del controlador
            $controller = new InstitucionController();

            // Crear un objeto Institucion
            $institucion = new Institucion(null, $nombre_institucion);

            // Insertar la institución
            if ($controller->insertar($institucion)) {
                // Redirigir con mensaje de éxito
                header("Location: ../../institucion.php");
                exit;
            } else {
                // Redirigir con mensaje de error
                header("Location: ../../institucion.php");
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "El nombre de la institución es obligatorio.";
    }
} else {
    echo "Método no permitido.";
}
