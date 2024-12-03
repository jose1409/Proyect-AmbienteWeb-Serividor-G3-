<?php
require_once __DIR__ . '/../../Controller/GrupoController.php';
require_once __DIR__ . '/../../Controller/InstitucionController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y recibir los datos
    $nombre_grupo = filter_input(INPUT_POST, 'nombre_grupo', FILTER_SANITIZE_STRING);
    $id_institucion = filter_input(INPUT_POST, 'id_institucion', FILTER_VALIDATE_INT);

    if ($nombre_grupo && $id_institucion) {
        try {
            // Validar si la institución existe
            $institucionController = new InstitucionController();
            $institucion = $institucionController->obtenerPorId($id_institucion);

            if ($institucion) {
                // Si la institución existe, proceder a insertar el grupo
                $grupoController = new GrupoController();
                $grupo = new Grupo(null, $nombre_grupo, $id_institucion);

                if ($grupoController->insertar($grupo)) {
                    // Redirigir con mensaje de éxito
                    header("Location: ../../grupo.php?success=1");
                    exit;
                } else {
                    // Redirigir con mensaje de error
                    header("Location: ../../grupo.php?error=insert");
                    exit;
                }
            } else {
                // Si la institución no existe, redirigir con mensaje de error
                header("Location: ../../grupo.php?error=invalid_institution");
                exit;
            }
        } catch (Exception $e) {
            header("Location: ../../grupo.php?error=exception&message=" . urlencode($e->getMessage()));
            exit;
        }
    } else {
        header("Location: ../../grupo.php?error=missing_fields");
        exit;
    }
}
?>
