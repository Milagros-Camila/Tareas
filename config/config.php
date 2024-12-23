<?php
// Permitir solicitudes desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");

// Configuración de la base de datos
define('DB_HOST', 'localhost');          // Servidor de la base de datos
define('BD_USER', 'root');               // Usuario de la base de datos
define('DB_PASS', '');                   // Contraseña de la base de datos
define('DB_NAME', 'gestion_tareas');     // Nombre de la base de datos

// Configuración de la URL base
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$server = $_SERVER['SERVER_NAME'];
$folder = dirname($_SERVER['SCRIPT_NAME']);
// define('BASE_URL', $protocol . $server . $folder);
define('BASE_URL', 'http://localhost/gestion-de-tareas');


// Configuración de la ruta para subir archivos o imágenes
define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . $folder . '/assets/uploads/');

// Configuración de la zona horaria
date_default_timezone_set('America/Lima');
?>
