<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesores - Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="View/assets/css/profesor.css">
</head>

<body>
    <!-- menu lateral -->
    <?php include 'menu.php';

    session_start();

    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit();
    }

    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        $message = '';

        switch ($error) {
            case 'invalid_institution':
                $message = 'La institución seleccionada no es válida.';
                break;
            case 'insert':
                $message = 'Ocurrió un error al intentar agregar el profesor.';
                break;
            case 'missing_fields':
                $message = 'Todos los campos son obligatorios.';
                break;
            case 'exception':
                $message = isset($_GET['message']) ? urldecode($_GET['message']) : 'Ocurrió un error inesperado.';
                break;
            default:
                $message = 'Ocurrió un error desconocido.';
                break;
        }

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorMessage = document.getElementById('errorMessage');
                errorMessage.textContent = '$message';
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        </script>";
    }

    ?>

    <!-- main -->
    <main class="main-content">
        <div class="content-wrapper">
            <div class="top-bar">
                <h4 class="mb-0">Gestión de Profesores</h4>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#professorModal">
                        <i class="fas fa-plus"></i> Nuevo Profesor
                    </button>
                </div>
            </div>

            <!-- search bar-filtro -->
            <div class="search-box mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Buscar por nombre o cédula...">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select">
                            <option value="">Filtrar por institución</option>
                            <option value="1">Institución 1</option>
                            <option value="2">Institución 2</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>

            <!-- tabla de profesor -->
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
                                <th>ID Institución</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once './Controller/ProfesorController.php';
                            try {
                                // Instanciar el controlador
                                $controller = new ProfesorController();
                                $profesores = $controller->listar();
                                // Verificar si hay profesores
                                if (!empty($profesores)) {
                                    foreach ($profesores as $profesor) {
                                        $id = htmlspecialchars($profesor->getIdProfesor());
                                        $cedula = htmlspecialchars($profesor->getCedula());
                                        $nombre = htmlspecialchars($profesor->getNombre());
                                        $apellido1 = htmlspecialchars($profesor->getApellido1());
                                        $apellido2 = htmlspecialchars($profesor->getApellido2());
                                        $id_institucion = htmlspecialchars($profesor->getIdInstitucion());
                                        echo <<<HTML
                                        <tr>
                                            <td>{$id}</td>
                                            <td>{$cedula}</td>
                                            <td>{$nombre}</td>
                                            <td>{$apellido1}</td>
                                            <td>{$apellido2}</td>
                                            <td>{$id_institucion}</td>
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
                                                        <h5 class="modal-title">Editar Profesor</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="./Acciones/Profesores/editar.php" method="POST">
                                                            <input type="hidden" name="action" value="editar">
                                                            <input type="hidden" name="id_profesor" value="{$id}">
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
                                                                <label class="form-label">ID Institución</label>
                                                                <input type="number" class="form-control" name="id_institucion" value="{$id_institucion}" required>
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
                                                        <h5 class="modal-title">Eliminar Profesor</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>¿Estás seguro de que deseas eliminar al profesor "<strong>{$nombre} {$apellido1}</strong>"?</p>
                                                        <form action="./Acciones/Profesores/eliminar.php" method="POST">
                                                            <input type="hidden" name="action" value="eliminar">
                                                            <input type="hidden" name="id_profesor" value="{$id}">
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
                                    echo "<tr><td colspan='7'>No se encontraron registros en la tabla <code>profesor</code>.</td></tr>";
                                }
                            } catch (Exception $e) {
                                echo "<tr><td colspan='7'>Error al consultar la base de datos: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
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

    <!-- Modal para agregar profesor -->
    <div class="modal fade" id="professorModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Profesor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="./Acciones/Profesores/agregar.php" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Cédula</label>
                                <input type="text" class="form-control" name="cedula" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Primer Apellido</label>
                                <input type="text" class="form-control" name="apellido1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Segundo Apellido</label>
                                <input type="text" class="form-control" name="apellido2">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">ID Institución</label>
                                <input type="number" class="form-control" name="id_institucion" required>
                            </div>
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

    <!-- Modal de Error -->
    <div class="modal fade" id="errorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="errorMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>