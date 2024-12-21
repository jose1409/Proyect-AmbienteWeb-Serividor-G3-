<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="View/assets/css/login.css">
</head>
<!-- form login -->

<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Iniciar Sesión</h2>
            <p class="text-muted">Ingrese sus credenciales para continuar</p>
        </div>
        <form id="loginForm" action="Controller/UsuarioController.php" method="POST">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" id="email" placeholder="Correo electrónico" required>
            </div>
            <div class="password-field">
                <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña" required>
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye" id="togglePassword"></i>
                </button>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="rememberMe">
                <label class="form-check-label text-muted" for="rememberMe">
                    Recordarme
                </label>
            </div>
            <button type="submit" class="btn btn-login">Ingresar</button>
            <div class="forgot-password">
                <a href="register.php">¿No tienes cuenta? Regístrate aquí</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = new FormData(e.target);
            try {
                const response = await fetch(e.target.action, {
                    method: 'POST',
                    body: form,
                });
                const result = await response.json();
                if (result.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: result.message,
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                    }).then(() => {
                        window.location.href = 'dashboard.php';
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: result.message,
                        icon: 'error',
                        confirmButtonText: 'Intentar de nuevo',
                    });
                }
            } catch (error) {
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un problema inesperado. Intente de nuevo más tarde.',
                    icon: 'error',
                    confirmButtonText: 'Cerrar',
                });
            }
        });

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