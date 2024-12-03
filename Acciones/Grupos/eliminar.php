<?php
require_once __DIR__ . '/../../Controller/GrupoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_grupo = filter_input(INPUT_POST, 'id_grupo', FILTER_VALIDATE_INT);

    if ($action === 'eliminar' && $id_grupo) {
        try {
            // Crear una instancia del controlador
            $grupoController = new GrupoController();

            // Eliminar el grupo
            if ($grupoController->eliminar($id_grupo)) {
                header("Location: ../../grupo.php?success=1");
                exit;
            } else {
                header("Location: ../../grupo.php?error=delete");
                exit;
            }
        } catch (Exception $e) {
            header("Location: ../../grupo.php?error=exception&message=" . urlencode($e->getMessage()));
            exit;
        }
    } else {
        header("Location: ../../grupo.php?error=invalid_action");
        exit;
    }
}
?>
