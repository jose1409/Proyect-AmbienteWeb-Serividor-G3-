<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="View/assets/css/dashboard.css">

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
                <h4 class="mb-0">Dashboard</h4>
                <div>
                    
                    </button>
                    <a href="logout.php" class="btn btn-outline-danger ms-2">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- tarjetas de acceso -->
                <div class="col-md-6 col-lg-3">
                    <div class="module-card">
                        <i class="fas fa-chalkboard-teacher module-icon"></i>
                        <h5>Profesores</h5>
                        <p class="text-muted">Gestión de profesores y asignaciones</p>
                        <a href="profesor.php" class="btn btn-outline-primary w-100">Acceder</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="module-card">
                        <i class="fas fa-user-graduate module-icon"></i>
                        <h5>Estudiantes</h5>
                        <p class="text-muted">Administración de estudiantes</p>
                        <a href="estudiante.php" class="btn btn-outline-primary w-100">Acceder</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="module-card">
                        <i class="fas fa-book module-icon"></i>
                        <h5>Grupos y Asignaturas</h5>
                        <p class="text-muted">Gestión de grupos y materias</p>
                        <a href="grupo.php" class="btn btn-outline-primary w-100">Acceder</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="module-card">
                        <i class="fas fa-star module-icon"></i>
                        <h5>Calificaciones</h5>
                        <p class="text-muted">Registro y consulta de notas</p>
                        <a href="calificacion.php" class="btn btn-outline-primary w-100">Acceder</a>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; 2024 Sistema Académico. Todos los derechos reservados.</p>
        </footer>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>