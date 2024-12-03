<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos - Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="View/assets/css/grupo.css">
</head>

<body>
<?php
        include 'menu.php';
    ?>

    <!-- main -->
    <main class="main-content">
        <div class="content-wrapper">
            <div class="top-bar">
                <h4 class="mb-0">Gestión de periodos</h4>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#grupoModal">
                        <i class="fas fa-plus"></i> Nuevo periodo
                    </button>
                </div>
            </div>

            <!-- search bar-filtro -->
            <div class="search-box mb-4">
                <div class="row">
                    <div class="col-md-5">
                        <label>Nombre</label>
                        <input type="text" class="form-control" placeholder="Buscar por nombre de periodo">
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-6">
                                <label>Fecha Inicio</label>
                                <input type="date" class="form-control" placeholder="Fecha inicial">
                            </div>
                            <div class="col-6">
                                <label>Fecha Fin</label>
                                <input type="date" class="form-control" placeholder="Fecha final">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label> <!-- Espacio vacío para alinear con los otros elementos -->
                        <button class="btn btn-primary w-100" onclick="searchByFilters()">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>

            <!-- tabla de instituciones -->
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del periodo</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- la tabla se poblara segun la base de datos -->
                            <tr>
                                <td>1</td>
                                <td>Primer semestre 2024</td>
                                <td>2024-01-01</td>
                                <td>2024-06-30</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Segundo semestre 2024</td>
                                <td>2024-07-01</td>
                                <td>2024-12-31</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; 2024 Sistema Académico. Todos los derechos reservados.</p>
        </footer>
    </main>

    <!-- Grupo Modal -->
    <div class="modal fade" id="grupoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir periodo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="grupoForm">
                        <div class="mb-3">
                            <label class="form-label">Nombre del periodo</label>
                            <input type="text" class="form-control" id="nombre_grupo" name="nombre_grupo" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha de inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha de fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html
