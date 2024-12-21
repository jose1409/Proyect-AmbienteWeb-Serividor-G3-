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
    <?php
    include 'menu.php';
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
                                <input type="text" class="form-control" placeholder="Institución" id="filter-institucion">
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
                                <th>Institución</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        require_once './Controller/ProfesorController.php';
                        require_once './Controller/InstitucionController.php';

                        try {
                            $controller = new ProfesorController();
                            $institucionController = new InstitucionController();
                            $profesores = $controller->listar();
                            $instituciones = $institucionController->listar();

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
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{$id}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{$id}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="editModal{$id}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Editar Profesor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="./Acciones/Profesores/editar.php" method="POST">
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
                                                            <label class="form-label">Institución</label>
                                                            <select class="form-select" name="id_institucion" required>
                                                                <option value="">Seleccione una institución</option>
HTML;
                                    foreach ($instituciones as $institucion) {
                                        $selected = $institucion->getIdInstitucion() == $id_institucion ? 'selected' : '';
                                        echo "<option value=\"{$institucion->getIdInstitucion()}\" $selected>{$institucion->getNombre()}</option>";
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

                                    <div class="modal fade" id="deleteModal{$id}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Eliminar Profesor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Estás seguro de que deseas eliminar al profesor "<strong>{$nombre} {$apellido1}</strong>"?</p>
                                                    <form action="./Acciones/Profesores/eliminar.php?action=eliminar" method="POST">
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
                                echo "<tr><td colspan='7' class='text-center'>No hay profesores registrados.</td></tr>";
                            }
                        } catch (Exception $e) {
                            echo "<tr><td colspan='7' class='text-center'>Error: No se pudieron cargar los datos.</td></tr>";
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
                                <label class="form-label">Institución</label>
                                <select class="form-select" name="id_institucion" required>
                                    <option value="">Seleccione una institución</option>
                                    <?php
                                    foreach ($instituciones as $institucion) {
                                        echo "<option value='{$institucion->getIdInstitucion()}'>{$institucion->getNombre()}</option>";
                                    }
                                    ?>
                                </select>
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

    <div class="modal fade" id="errorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
    <script>
        document.getElementById('apply-filters').addEventListener('click', function() {
            const idFilter = document.getElementById('filter-id').value.toLowerCase();
            const cedulaFilter = document.getElementById('filter-cedula').value.toLowerCase();
            const nombreFilter = document.getElementById('filter-nombre').value.toLowerCase();
            const primerApellidoFilter = document.getElementById('filter-primer-apellido').value.toLowerCase();
            const segundoApellidoFilter = document.getElementById('filter-segundo-apellido').value.toLowerCase();
            const institucionFilter = document.getElementById('filter-institucion').value.toLowerCase();

            const rows = document.querySelectorAll('.custom-table tbody tr');
            rows.forEach(row => {
                const id = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const cedula = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const nombre = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const primerApellido = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                const segundoApellido = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                const institucion = row.querySelector('td:nth-child(6)').textContent.toLowerCase();

                const match =
                    (idFilter === "" || id.includes(idFilter)) &&
                    (cedulaFilter === "" || cedula.includes(cedulaFilter)) &&
                    (nombreFilter === "" || nombre.includes(nombreFilter)) &&
                    (primerApellidoFilter === "" || primerApellido.includes(primerApellidoFilter)) &&
                    (segundoApellidoFilter === "" || segundoApellido.includes(segundoApellidoFilter)) &&
                    (institucionFilter === "" || institucion.includes(institucionFilter));

                row.style.display = match ? '' : 'none';
            });
        });
    </script>
</body>

</html>
