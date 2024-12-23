<?php
// Manejo de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cargar el archivo de configuración
require_once 'config/config.php';

// Autoload de clases
spl_autoload_register(function ($class_name) {
    $directories = [
        'controllers/',
        'models/',
        'config/',
        'utils/',
        ''
    ];

    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Crear una instancia del router
$router = new Router();

// Rutas públicas
$router->add('GET', '/login', 'AuthController', 'showLogin');
$router->add('GET', '/register', 'AuthController', 'showRegister');
$router->add('POST', '/auth/login', 'AuthController', 'login');
$router->add('POST', '/auth/register', 'AuthController', 'register');

// Rutas privadas
$router->add('GET', '/home', 'HomeController', 'index');

// CRUD Tareas
$router->add('GET', '/tareas', 'TareaController', 'tareas');
$router->add('GET', '/tareas/obtenerTareas', 'TareaController', 'obtenerTareas');
$router->add('POST', '/tareas/guardar', 'TareaController', 'guardarTarea');
$router->add('POST', '/tareas/actualizar', 'TareaController', 'actualizarTarea');
$router->add('DELETE', '/tareas/eliminar', 'TareaController', 'eliminarTarea');

//PDF
$router->add('GET', 'reporte-tarea/pdf', 'ReporteControllerTarea', 'reportePdf');


// Despachar rutas
try {
    $router->dispatch(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include 'views/errors/404.php';
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}
