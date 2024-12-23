<?php
class TareaController
{
    private $db;
    private $tarea;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
        $this->tarea = new Tarea($this->db);
    }

    public function tareas()
    {
        include 'views/layouts/header.php';
        include 'views/tareas/index.php';
        include 'views/layouts/footer.php';
    }

    public function obtenerTareas()
    {
        header('Content-Type: application/json');
        try {
            $resultado = $this->tarea->obtenerTareas();
            $tareas = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['status' => 'success', 'data' => $tareas]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function guardarTarea()
    {
        header('Content-Type: application/json');
        try {
            $data = json_decode(file_get_contents("php://input"));

            if (empty($data->titulo) || empty($data->descripcion)) {
                throw new Exception("Todos los campos son obligatorios.");
            }

            $this->tarea->titulo = $data->titulo;
            $this->tarea->descripcion = $data->descripcion;
            $this->tarea->estado = $data->estado ?? 'Pendiente'; // Valor por defecto
            $this->tarea->fecha_inicio = $data->fecha_inicio;
            $this->tarea->fecha_limite = $data->fecha_limite;

            if ($this->tarea->crearTarea()) {
                echo json_encode(["status" => "success", "message" => "Tarea creada exitosamente."]);
            } else {
                throw new Exception("Error al crear tarea.");
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function actualizarTarea()
    {
        header('Content-Type: application/json');
        try {
            $data = json_decode(file_get_contents("php://input"));

            if (
                empty($data->id) || // Cambiado a id
                empty($data->titulo) ||
                empty($data->descripcion) ||
                empty($data->estado) ||
                empty($data->fecha_inicio) ||
                empty($data->fecha_limite)
            ) {
                throw new Exception('Todos los campos son obligatorios.');
            }

            $this->tarea->id = $data->id; // Cambiado a id
            $this->tarea->titulo = $data->titulo;
            $this->tarea->descripcion = $data->descripcion;
            $this->tarea->estado = $data->estado;
            $this->tarea->fecha_inicio = $data->fecha_inicio;
            $this->tarea->fecha_limite = $data->fecha_limite;

            if ($this->tarea->actualizarTarea()) {
                echo json_encode(['status' => 'success', 'message' => 'Tarea actualizada correctamente.']);
            } else {
                throw new Exception('Error al actualizar la tarea.');
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function eliminarTarea()
    {
        header('Content-Type: application/json');
        try {
            $data = json_decode(file_get_contents("php://input"));

            if (empty($data->id)) { // Cambiado a id
                throw new Exception('El ID de la tarea es obligatorio.');
            }

            $this->tarea->id = $data->id; // Cambiado a id

            if ($this->tarea->eliminarTarea()) {
                echo json_encode(['status' => 'success', 'message' => 'Tarea eliminada correctamente.']);
            } else {
                throw new Exception('Error al eliminar la tarea.');
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
