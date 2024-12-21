<?php
require_once __DIR__ . '/../../Controller/CalificacionController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y recibir los datos
    $id_estudiante = filter_input(INPUT_POST, 'id_estudiante', FILTER_VALIDATE_INT);
    $trabajo_cotidiano = filter_input(INPUT_POST, 'trabajo_cotidiano', FILTER_VALIDATE_FLOAT);
    $tareas = filter_input(INPUT_POST, 'tareas', FILTER_VALIDATE_FLOAT);
    $proyecto = filter_input(INPUT_POST, 'proyecto', FILTER_VALIDATE_FLOAT);
    $asistencia = filter_input(INPUT_POST, 'asistencia', FILTER_VALIDATE_FLOAT);
   
    if ($id_estudiante && $trabajo_cotidiano && $proyecto && $asistencia && $tareas) {
        try {

            // Crear instancia del controlador
            $controller = new CalificacionController();
            $calificacion = new calificacion(1, $id_estudiante, $trabajo_cotidiano, $tareas, $proyecto, $asistencia, 0);
            $calificacion->setCalificacionFinal($calificacion->calcularCalificacionFinal());

            if ($controller->insertar($calificacion)) {
                // Redirigir con mensaje de éxito
                header("Location: ../../calificacion.php?success=1");
                exit;
            } else {
                // Redirigir con mensaje de error
                header("Location: ../../calificacion.php?error=insert");
                exit;
            }
        } catch (Exception $e) {
            header("Location: ../../calificacion.php?error=exception&message=" . urlencode($e->getMessage()));
            exit;
        }
    } else {
        header("Location: ../../calificacion.php?error=missing_fields");
        exit;
    }
}
