<?php
require_once '../../Controller/AsignaturaController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y recibir los datos
    $nombre = filter_input(INPUT_POST, 'nombre_asignatura', FILTER_SANITIZE_STRING);

    if ($nombre) {
        try {
            // Crear una instancia del controlador
            $controller = new AsignaturaController();

            // Crear un objeto Asignatura
            $asignatura = new Asignatura(null, $nombre);

            // Insertar la institución
            if ($controller->insertar($asignatura)) {
                // Redirigir con mensaje de éxito
                header("Location: ../../asignatura.php");
                exit;
            } else {
                // Redirigir con mensaje de error
                header("Location: ../../asignatura.php");
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "El nombre de la Asignatura es obligatorio.";
    }
} else {
    echo "Método no permitido.";
}