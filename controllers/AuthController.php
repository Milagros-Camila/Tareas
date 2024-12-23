<?php
class AuthController
{
    private $db;
    private $usuario;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
        $this->usuario = new Usuario($this->db);
    }

    public function showLogin()
    {
        include 'views/auth/login.php';
    }

    public function showRegister()
    {
        include 'views/auth/register.php';
    }

    public function login()
    {
        header('Content-Type: application/json');
        try {
            $data = json_decode(file_get_contents("php://input"));
            if (empty($data->username) || empty($data->password)) {
                throw new Exception('Usuario y Contraseña son requeridos');
            }

            $usuario = $this->usuario->login($data->username, $data->password);
            if ($usuario) {
                session_start();
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                echo json_encode(['status' => 'success', 'message' => 'Login exitoso']);
            } else {
                throw new Exception('Usuario o contraseña incorrectos');
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function register()
    {
        header('Content-Type: application/json');
        try {
            $data = json_decode(file_get_contents("php://input"));
            if (empty($data->full_name) || empty($data->username) || empty($data->email) || empty($data->password)) {
                throw new Exception('Todos los campos son obligatorios.');
            }

            $this->usuario->nombre_completo = $data->full_name;
            $this->usuario->nombre_usuario = $data->username;
            $this->usuario->correo = $data->email;
            $this->usuario->clave = password_hash($data->password, PASSWORD_DEFAULT);

            if ($this->usuario->crearUsuario()) {
                echo json_encode(['status' => 'success', 'message' => 'Registro exitoso']);
            } else {
                throw new Exception('Error al registrar el usuario.');
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
