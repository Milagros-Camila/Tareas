<?php
class Tarea
{
    private $conn;

    public $id;
    public $titulo;
    public $descripcion;
    public $estado;
    public $fecha_inicio;
    public $fecha_limite;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function obtenerTareas()
    {
        $query = "SELECT * FROM tareas ORDER BY fecha_inicio DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function crearTarea()
    {
        $query = "INSERT INTO tareas (titulo, descripcion, estado, fecha_inicio, fecha_limite) 
                  VALUES (:titulo, :descripcion, :estado, :fecha_inicio, :fecha_limite)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':fecha_inicio', $this->fecha_inicio);
        $stmt->bindParam(':fecha_limite', $this->fecha_limite);

        return $stmt->execute();
    }

    public function actualizarTarea()
    {
        $query = "UPDATE tareas 
                  SET titulo = :titulo, descripcion = :descripcion, estado = :estado, 
                      fecha_inicio = :fecha_inicio, fecha_limite = :fecha_limite 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':fecha_inicio', $this->fecha_inicio);
        $stmt->bindParam(':fecha_limite', $this->fecha_limite);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    public function eliminarTarea()
    {
        $query = "DELETE FROM tareas WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
