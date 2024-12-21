<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="View/assets/css/login.css">
</head>
<!-- form registro -->

<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Registrarse</h2>
            <p class="text-muted">Complete los datos para crear su cuenta</p>
        </div>
        <form method="POST" action="/Sistema_Academico/Controller/UsuarioController.php">
            <input type="hidden" name="action" value="register">
            <input type="text" name="nombre" class="form-control mb-3" placeholder="Nombre" required>
            <input type="text" name="apellido" class="form-control mb-3" placeholder="Apellido" required>
            <input type="email" name="correo" class="form-control mb-3" placeholder="Correo electrónico" required>
            <div class="password-field">
                <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña" required>
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye" id="togglePassword"></i>
                </button>
            </div>
            <button type="submit" class="btn btn-login">Registrarse</button>
        </form>
        <div class="forgot-password">
            <a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePassword');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>