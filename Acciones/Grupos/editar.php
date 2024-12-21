<?php
require_once __DIR__ . '/../../Controller/GrupoController.php';
require_once __DIR__ . '/../../Controller/InstitucionController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';
    $id_grupo = filter_input(INPUT_POST, 'id_grupo', FILTER_VALIDATE_INT);

    if ($action === 'editar' && $id_grupo) {
        $nombre_grupo = filter_input(INPUT_POST, 'nombre_grupo', FILTER_SANITIZE_STRING);
        $id_institucion = filter_input(INPUT_POST, 'id_institucion', FILTER_VALIDATE_INT);

        if ($nombre_grupo && $id_institucion) {
            try {
                // Validar si la institución existe
                $institucionController = new InstitucionController();
                $institucion = $institucionController->obtenerPorId($id_institucion);

                if ($institucion) {
                    // Si la institución existe, proceder a actualizar el grupo
                    $grupoController = new GrupoController();
                    $grupo = new Grupo($id_grupo, $nombre_grupo, $id_institucion);

                    if ($grupoController->actualizar($grupo)) {
                        header("Location: ../../grupo.php?success=1");
                        exit;
                    } else {
                        header("Location: ../../grupo.php?error=update");
                        exit;
                    }
                } else {
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
    } else {
        
       header("Location: ../../grupo.php?error=invalid_action");
       exit;
    }
}
?>
