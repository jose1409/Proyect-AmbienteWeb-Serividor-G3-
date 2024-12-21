<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificaciones - Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="View/assets/css/calificacion.css">

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
                <h4 class="mb-0">Gestión de Calificaciones</h4>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#calificacionModal">
                        <i class="fas fa-plus"></i> Nueva Calificación
                    </button>
                </div>
            </div>




            <!-- tabla de calificaciones -->
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
                                <input type="text" class="form-control" placeholder="Estudiante" id="filter-estudiante">
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
                                <th>Cedula Estudiante</th>
                                <th>Estudiante</th>
                                <th>Trabajo Cotidiano</th>
                                <th>Tareas</th>
                                <th>Proyecto</th>
                                <th>Asistencia</th>
                                <th>Calificación Final</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once './Controller/CalificacionController.php';
                            require_once './Controller/EstudianteController.php';
                            try {
                                // Instanciar el controlador
                                $controller = new CalificacionController();
                                $calificaciones = $controller->listar();
                                $EstudianteController = new EstudianteController();
                                $estudiantes = $EstudianteController->listar();


                                // Verificar si hay registros de calificaciones
                                if (!empty($calificaciones)) {
                                    foreach ($calificaciones as $calificacion) {
                                        $id_calificacion = htmlspecialchars($calificacion->getIdCalificacion());
                                        $id_estudiante = htmlspecialchars($calificacion->getIdEstudiante());
                                        $trabajo_cotidiano = htmlspecialchars($calificacion->getTrabajoCotidiano());
                                        $tareas = htmlspecialchars($calificacion->getTareas());
                                        $proyecto = htmlspecialchars($calificacion->getProyecto());
                                        $asistencia = htmlspecialchars($calificacion->getAsistencia());
                                        $calificacion_final = htmlspecialchars($calificacion->getCalificacionFinal());
                                        $estudiante = $EstudianteController->obtenerPorId($id_estudiante);

                                        echo <<<HTML
                                        <tr>
                                            <td>{$id_calificacion}</td>
                                            <td>{$estudiante->getCedula()}</td> 
                                            <td>{$estudiante->getNombreCompleto()}</td>                                         
                                            <td>{$trabajo_cotidiano}</td>
                                            <td>{$tareas}</td>
                                            <td>{$proyecto}</td>
                                            <td>{$asistencia}</td>
                                            <td>{$calificacion_final}</td>
                                            <td>

                                                <!-- Botón Editar -->
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{$id_calificacion}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Botón Eliminar -->
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{$id_calificacion}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Editar -->
                                        <div class="modal fade" id="editModal{$id_calificacion}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Editar Calificación</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="./Acciones/Calificacion/editar.php" method="POST">
                                                            <input type="hidden" name="action" value="editar">
                                                            <input type="hidden" name="id_calificacion" value="{$id_calificacion}">
                                                            <input type="hidden" class="form-control" name="id_estudiante" value="{$id_estudiante}" required>
                                                                                                                      
                                                            <div class="mb-3">
                                                                <label class="form-label">Trabajo Cotidiano</label>
                                                                <input type="number" step="0.01" class="form-control" name="trabajo_cotidiano" value="{$trabajo_cotidiano}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Tareas</label>
                                                                <input type="number" step="0.01" class="form-control" name="tareas" value="{$tareas}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Proyecto</label>
                                                                <input type="number" step="0.01" class="form-control" name="proyecto" value="{$proyecto}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Asistencia</label>
                                                                <input type="number" step="0.01" class="form-control" name="asistencia" value="{$asistencia}" required>
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
                                        <div class="modal fade" id="deleteModal{$id_calificacion}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Eliminar Calificación</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>¿Estás seguro de que deseas eliminar esta calificación?</p>
                                                        <form action="./Acciones/Calificacion/eliminar.php" method="POST">
                                                            <input type="hidden" name="action" value="eliminar">
                                                            <input type="hidden" name="id_calificacion" value="{$id_calificacion}">
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
                                    echo "<tr><td colspan='9'>No se encontraron registros en la tabla <code>CALIFICACIONES</code>.</td></tr>";
                                }
                            } catch (Exception $e) {
                                echo "<tr><td colspan='9'>Error al consultar la base de datos: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
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

    <!-- Calificación Modal -->
    <div class="modal fade" id="calificacionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Calificación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="calificacionForm" action="./Acciones/Calificacion/agregar.php" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Estudiante</label>
                                <select class="form-select" name="id_estudiante" required>
                                    <option value="">Seleccione un estudiante</option>
                                    <?php
                                    foreach ($estudiantes as $estudiante) {
                                        echo "<option value='{$estudiante->getIdEstudiante()}'>{$estudiante->getCedula()} - {$estudiante->getNombreCompleto()}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Trabajo Cotidiano</label>
                                <input type="number" step="0.01" class="form-control" id="trabajo_cotidiano" name="trabajo_cotidiano" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tareas</label>
                                <input type="number" step="0.01" class="form-control" id="tareas" name="tareas" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Proyecto</label>
                                <input type="number" step="0.01" class="form-control" id="proyecto" name="proyecto" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Asistencia</label>
                                <input type="number" step="0.01" class="form-control" id="asistencia" name="asistencia" required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('apply-filters').addEventListener('click', function() {
            const idFilter = document.getElementById('filter-id').value.toLowerCase();
            const cedulaFilter = document.getElementById('filter-cedula').value.toLowerCase();
            const estudianteFilter = document.getElementById('filter-estudiante').value.toLowerCase();

            const rows = document.querySelectorAll('.custom-table tbody tr');
            rows.forEach(row => {
                const id = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const cedula = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const estudiante = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                
                const match =
                    (idFilter === "" || id.includes(idFilter)) &&
                    (cedulaFilter === "" || cedula.includes(cedulaFilter)) &&
                    (estudianteFilter === "" || estudiante.includes(estudianteFilter))
                    
                row.style.display = match ? '' : 'none';
            });
        });
    </script>

</body>

</html>