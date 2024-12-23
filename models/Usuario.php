<?php
class Usuario
{
    private $conn;

    public $id_usuario;
    public $nombre_usuario;
    public $clave;
    public $correo;
    public $nombre_completo;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($username, $password)
    {
        $query = "SELECT * FROM usuarios WHERE nombre_usuario = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['clave'])) {
                return $user;
            }
        }
        return false;
    }

    public function crearUsuario()
    {
        $query = "INSERT INTO usuarios (nombre_completo, nombre_usuario, correo, clave) 
                  VALUES (:nombre_completo, :nombre_usuario, :correo, :clave)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre_completo', $this->nombre_completo);
        $stmt->bindParam(':nombre_usuario', $this->nombre_usuario);
        $stmt->bindParam(':correo', $this->correo);
        $stmt->bindParam(':clave', $this->clave);
        return $stmt->execute();
    }
}
