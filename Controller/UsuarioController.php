<?php
require_once __DIR__ . '/../DB/Database.php';

class UsuarioController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['email'] ?? '';
            $contrasena = $_POST['password'] ?? '';

            if (empty($correo) || empty($contrasena)) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                return;
            }

            $correo = $this->db->escapeString($correo);
            $query = "SELECT * FROM usuario WHERE correo = '$correo'";
            $result = $this->db->query($query);

            if ($result->num_rows > 0) {
                $usuario = $result->fetch_assoc();
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    session_start();
                    $_SESSION['usuario'] = $usuario;
                    echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Usuario no registrado']);
            }
        }
    }
}

// Llamar automáticamente al método login si se accede directamente al archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UsuarioController();
    $controller->login();
}