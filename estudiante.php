<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes - Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="View/assets/css/estudiante.css">
</head>

<body>
    <?php include 'menu.php'; 
    
    session_start();

    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit();
    }

    ?>

    <!-- main -->
    <main class="main-content">
        <div class="content-wrapper">
            <div class="top-bar">
                <h4 class="mb-0">Gestión de Estudiantes</h4>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#estudianteModal">
                        <i class="fas fa-plus"></i> Nuevo Estudiante
                    </button>
                </div>
            </div>

            <!-- search bar-filtro -->
            <div class="search-box mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Buscar por nombre o grupo...">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>

            <!-- tabla de estudiantes -->
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Grupo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once './Controller/EstudianteController.php';
                            require_once './Controller/GrupoController.php';

                            try {
                                // Instanciar controladores
                                $estudianteController = new EstudianteController();
                                $grupoController = new GrupoController();

                                $estudiantes = $estudianteController->listar();

                                if (!empty($estudiantes)) {
                                    foreach ($estudiantes as $estudiante) {
                                        $id_estudiante = htmlspecialchars($estudiante->getIdEstudiante());
                                        $cedula = htmlspecialchars($estudiante->getCedula());
                                        $nombre = htmlspecialchars($estudiante->getNombre());
                                        $apellido1 = htmlspecialchars($estudiante->getApellido1());
                                        $apellido2 = htmlspecialchars($estudiante->getApellido2());
                                        $id_grupo = htmlspecialchars($estudiante->getIdGrupo());

                                        // Obtener el nombre del grupo
                                        $grupo = $grupoController->obtenerPorId($id_grupo);
                                        $nombre_grupo = $grupo ? htmlspecialchars($grupo->getNombreGrupo()) : 'Sin Grupo';

                                        echo <<<HTML
                                        <tr>
                                            <td>{$id_estudiante}</td>
                                            <td>{$cedula}</td>
                                            <td>{$nombre}</td>
                                            <td>{$apellido1}</td>
                                            <td>{$apellido2}</td>
                                            <td>{$nombre_grupo}</td>
                                            <td>
                                                <!-- Botón Editar -->
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{$id_estudiante}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Botón Eliminar -->
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{$id_estudiante}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Editar -->
                                        <div class="modal fade" id="editModal{$id_estudiante}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Editar Estudiante</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="./Acciones/Estudiante/editar.php" method="POST">
                                                            <input type="hidden" name="id_estudiante" value="{$id_estudiante}">
                                                            <div class="mb-3">
                                                                <label class="form-label">Cédula</label>
                                                                <input type="text" class="form-control" name="cedula" value="{$cedula}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Nombre</label>
                                                                <input type="text" class="form-control" name="nombre" value="{$nombre}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Primer Apellido</label>
                                                                <input type="text" class="form-control" name="apellido1" value="{$apellido1}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Segundo Apellido</label>
                                                                <input type="text" class="form-control" name="apellido2" value="{$apellido2}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Grupo</label>
                                                                <select class="form-select" name="id_grupo" required>
                                                                    <option value="">Seleccione un grupo</option>
HTML;
                                        foreach ($grupoController->listar() as $grupo) {
                                            $selected = $grupo->getIdGrupo() == $id_grupo ? 'selected' : '';
                                            echo "<option value=\"{$grupo->getIdGrupo()}\" $selected>{$grupo->getNombreGrupo()}</option>";
                                        }
                                        echo <<<HTML
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Eliminar -->
                                        <div class="modal fade" id="deleteModal{$id_estudiante}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Eliminar Estudiante</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>¿Estás seguro de que deseas eliminar al estudiante "<strong>{$nombre} {$apellido1}</strong>"?</p>
                                                        <form action="./Acciones/Estudiante/eliminar.php" method="POST">
                                                            <input type="hidden" name="id_estudiante" value="{$id_estudiante}">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
HTML;
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No se encontraron registros en la tabla <code>estudiante</code>.</td></tr>";
                                }
                            } catch (Exception $e) {
                                echo "<tr><td colspan='3'>Error al consultar la base de datos: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; 2024 Sistema Académico. Todos los derechos reservados.</p>
        </footer>
    </main>

    <!-- Modal para agregar estudiante -->
    <div class="modal fade" id="estudianteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="./Acciones/Estudiante/agregar.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Cédula</label>
                            <input type="text" class="form-control" name="cedula" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Primer Apellido</label>
                            <input type="text" class="form-control" name="apellido1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" name="apellido2">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Grupo</label>
                            <select class="form-select" name="id_grupo" required>
                                <option value="">Seleccione un grupo</option>
                                <?php
                                $grupos = $grupoController->listar();
                                foreach ($grupos as $grupo) {
                                    echo "<option value=\"{$grupo->getIdGrupo()}\">{$grupo->getNombreGrupo()}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>