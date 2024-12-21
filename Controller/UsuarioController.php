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

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $apellido = trim($_POST['apellido']);
            $correo = trim($_POST['correo']);
            $password = trim($_POST['password']);
            if (empty($nombre) || empty($apellido) || empty($correo) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                return;
            }
            // Encriptar la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Escapar valores
            $nombre = $this->db->escapeString($nombre);
            $apellido = $this->db->escapeString($apellido);
            $correo = $this->db->escapeString($correo);
            $hashedPassword = $this->db->escapeString($hashedPassword);
            // Insertar en la base de datos
            $query = "INSERT INTO usuario (nombre, apellido, correo, contrasena) VALUES ('$nombre', '$apellido', '$correo', '$hashedPassword')";
            if ($this->db->query($query)) {
                echo json_encode(['success' => true, 'message' => 'Usuario registrado correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario']);
            }
        }
    }
}
// Determinar si se llama al login o al registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UsuarioController();
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        $controller->register();
    } else {
        $controller->login();
    }
}
