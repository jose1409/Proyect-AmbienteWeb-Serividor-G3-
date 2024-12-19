<?php
require_once __DIR__ . '/../../Controller/CalificacionController.php';
require_once __DIR__ . '/../../Controller/GrupoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_calificacion = filter_input(INPUT_POST, 'id_calificacion', FILTER_VALIDATE_INT);

    if ($action === 'editar' && $id_calificacion) {
        $cedula = filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $apellido1 = filter_input(INPUT_POST, 'apellido1', FILTER_SANITIZE_STRING);
        $apellido2 = filter_input(INPUT_POST, 'apellido2', FILTER_SANITIZE_STRING);
        $id_grupo = filter_input(INPUT_POST, 'id_grupo', FILTER_VALIDATE_INT);

        if ($cedula && $nombre && $apellido1 && $id_grupo) {
            try {
                // Validar si el grupo existe
                $grupoController = new GrupoController();
                $grupo = $grupoController->obtenerPorId($id_grupo);

                if ($grupo) {
                    // Si el grupo existe, proceder a actualizar el calificacion
                    $calificacionController = new CalificacionController();
                    $calificacion = new Calificacion($id_calificacion, $cedula, $nombre, $apellido1, $apellido2, $id_grupo);

                    if ($calificacionController->actualizar($calificacion)) {
                        header("Location: ../../calificacion.php?success=1");
                        exit;
                    } else {
                        header("Location: ../../calificacion.php?error=update");
                        exit;
                    }
                } else {
                    header("Location: ../../calificacion.php?error=invalid_group");
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
    } else {
        header("Location: ../../calificacion.php?error=invalid_action");
        exit;
    }
}
