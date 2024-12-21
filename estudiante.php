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


            <!-- tabla de estudiantes -->
            <div class="table-container">
                <div class="table-responsive">

                <!-- filtro -->
                    <form class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-1">
                                <input type="text" class="form-control" placeholder="ID" id="filter-id">
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" placeholder="Cédula" id="filter-cedula">
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" placeholder="Nombre" id="filter-nombre">
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" placeholder="Primer Apellido" id="filter-primer-apellido">
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" placeholder="Segundo Apellido" id="filter-segundo-apellido">
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" placeholder="Grupo" id="filter-grupo">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-primary w-100" id="apply-filters">Filtrar</button>
                            </div>
                        </div>
                    </form>

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
                                                        <form action="./Acciones/Estudiante/editar.php?action=editar" method="POST">
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
                                                        <form action="./Acciones/Estudiante/eliminar.php?action=eliminar" method="POST">
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
    <script>
        document.getElementById('apply-filters').addEventListener('click', function() {
            const idFilter = document.getElementById('filter-id').value.toLowerCase();
            const cedulaFilter = document.getElementById('filter-cedula').value.toLowerCase();
            const nombreFilter = document.getElementById('filter-nombre').value.toLowerCase();
            const primerApellidoFilter = document.getElementById('filter-primer-apellido').value.toLowerCase();
            const segundoApellidoFilter = document.getElementById('filter-segundo-apellido').value.toLowerCase();
            const grupoFilter = document.getElementById('filter-grupo').value.toLowerCase();

            const rows = document.querySelectorAll('.custom-table tbody tr');
            rows.forEach(row => {
                const id = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const cedula = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const nombre = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const primerApellido = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                const segundoApellido = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                const grupo = row.querySelector('td:nth-child(6)').textContent.toLowerCase();

                const match =
                    (idFilter === "" || id.includes(idFilter)) &&
                    (cedulaFilter === "" || cedula.includes(cedulaFilter)) &&
                    (nombreFilter === "" || nombre.includes(nombreFilter)) &&
                    (primerApellidoFilter === "" || primerApellido.includes(primerApellidoFilter)) &&
                    (segundoApellidoFilter === "" || segundoApellido.includes(segundoApellidoFilter)) &&
                    (grupoFilter === "" || grupo.includes(grupoFilter));

                row.style.display = match ? '' : 'none';
            });
        });
    </script>

</body>

</html>