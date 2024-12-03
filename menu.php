<?php
// Obtén el nombre del archivo actual
$currentFile = basename($_SERVER['SCRIPT_NAME']);

// Define los elementos del menú
$menuItems = [
    ["link" => "./dashboard.php", "icon" => "fas fa-home", "text" => "Dashboard"],
    ["link" => "./profesor.php", "icon" => "fas fa-chalkboard-teacher", "text" => "Profesores"],
    ["link" => "./estudiante.php", "icon" => "fas fa-user-graduate", "text" => "Estudiantes"],
    ["link" => "./grupo.php", "icon" => "fas fa-book", "text" => "Grupos"],
    ["link" => "./asignatura.php", "icon" => "fas fa-layer-group", "text" => "Asignaturas"],
    ["link" => "./calificacion.php", "icon" => "fas fa-star", "text" => "Calificaciones"],
    ["link" => "./institucion.php", "icon" => "fa-regular fa-building", "text" => "Institución"],
    ["link" => "./periodo.php", "icon" => "fa-regular fa-calendar", "text" => "Periodo"]
];
?>
<!-- Menú lateral -->
<nav class="sidebar">
    <div class="sidebar-header">
        <h4>Sistema Académico</h4>
    </div>

    <ul class="sidebar-menu">
        <?php foreach ($menuItems as $item): ?>
            <li>
                <a href="<?= htmlspecialchars($item['link']) ?>"
                    class="<?= (basename($item['link']) === $currentFile) ? 'active' : '' ?>">
                    <i class="<?= htmlspecialchars($item['icon']) ?>"></i>
                    <?= htmlspecialchars($item['text']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
