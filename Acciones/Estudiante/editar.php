<?php
require_once __DIR__ . '/../../Controller/EstudianteController.php';
require_once __DIR__ . '/../../Controller/GrupoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_estudiante = filter_input(INPUT_POST, 'id_estudiante', FILTER_VALIDATE_INT);

    if ($action === 'editar' && $id_estudiante) {
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
                    // Si el grupo existe, proceder a actualizar el estudiante
                    $estudianteController = new EstudianteController();
                    $estudiante = new Estudiante($id_estudiante, $cedula, $nombre, $apellido1, $apellido2, $id_grupo);

                    if ($estudianteController->actualizar($estudiante)) {
                        header("Location: ../../estudiante.php?success=1");
                        exit;
                    } else {
                        header("Location: ../../estudiante.php?error=update");
                        exit;
                    }
                } else {
                    header("Location: ../../estudiante.php?error=invalid_group");
                    exit;
                }
            } catch (Exception $e) {
                header("Location: ../../estudiante.php?error=exception&message=" . urlencode($e->getMessage()));
                exit;
            }
        } else {
            header("Location: ../../estudiante.php?error=missing_fields");
            exit;
        }
    } else {
        header("Location: ../../estudiante.php?error=invalid_action");
        exit;
    }
}
