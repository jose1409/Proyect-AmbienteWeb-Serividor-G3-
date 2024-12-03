<?php
require_once __DIR__ . '/../../Controller/EstudianteController.php';
require_once __DIR__ . '/../../Controller/GrupoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y recibir los datos
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
                // Si el grupo existe, obtener también su nombre
                $nombre_grupo = $grupo->getNombreGrupo();

                // Crear instancia del controlador
                $controller = new EstudianteController();
                $estudiante = new Estudiante(null, $cedula, $nombre, $apellido1, $apellido2, $id_grupo, $nombre_grupo);

                if ($controller->insertar($estudiante)) {
                    // Redirigir con mensaje de éxito
                    header("Location: ../../estudiante.php?success=1");
                    exit;
                } else {
                    // Redirigir con mensaje de error
                    header("Location: ../../estudiante.php?error=insert");
                    exit;
                }
            } else {
                // Si el grupo no existe, redirigir con mensaje de error
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
}
