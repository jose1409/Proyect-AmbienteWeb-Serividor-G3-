<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaturas - Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="View/assets/css/asignatura.css">
</head>

<body>
    <?php
    include 'menu.php';

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
                <h4 class="mb-0">Gestión de Asignaturas</h4>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#asignaturaModal">
                        <i class="fas fa-plus"></i> Nueva Asignatura
                    </button>
                </div>
            </div>

            <!-- search bar-filtro -->
            <div class="search-box mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Buscar por nombre...">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>

            <!-- tabla de asignaturas -->
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once './Controller/AsignaturaController.php';

                            try {
                                // Instanciar el controlador
                                $asignaturaController = new AsignaturaController();
                                $asignaturas = $asignaturaController->listar();

                                if (!empty($asignaturas)) {
                                    foreach ($asignaturas as $asignatura) {
                                        $id = htmlspecialchars($asignatura->getIdAsignatura());
                                        $nombre = htmlspecialchars($asignatura->getNombre());

                                        echo <<<HTML
                            <tr>
                                <td>{$id}</td>
                                <td>{$nombre}</td>
                                <td>
                                    <!-- Botón Editar -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{$id}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Botón Eliminar -->
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{$id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Editar -->
                            <div class="modal fade" id="editModal{$id}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Asignatura</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="./Acciones/Asignatura/editar.php" method="POST">
                                            <input type="hidden" name="action" value="editar">
                                                <input type="hidden" name="id_asignatura" value="{$id}">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre de la Asignatura</label>
                                                    <input type="text" class="form-control" name="nombre_asignatura" value="{$nombre}" required>
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
                            <div class="modal fade" id="deleteModal{$id}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Eliminar Asignatura</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar la asignatura "<strong>{$nombre}</strong>"?</p>
                                            <form action="./Acciones/Asignatura/eliminar.php" method="POST">
                                            <input type="hidden" name="action" value="eliminar">
                                                <input type="hidden" name="id_asignatura" value="{$id}">
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
                                    echo "<tr><td colspan='3'>No se encontraron asignaturas en la base de datos.</td></tr>";
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

    <!-- Asignatura Modal -->
    <div class="modal fade" id="asignaturaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Asignatura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="asignaturaForm" action="./Acciones/Asignatura/agregar.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label" for="nombre_asignatura">Nombre de la asignatura</label>
                            <input type="text" class="form-control" id="nombre_asignatura" name="nombre_asignatura" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="asignaturaForm">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>