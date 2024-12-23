<?php
// Iniciar la sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirigir si ya está autenticado
if (isset($_SESSION['usuario_id'])) {
    header("Location: http://localhost/gestion-de-tareas/home");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Gestión de Tareas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Registro</h2>
                        <div id="registerAlert">
                            <!-- Aquí se mostrarán mensajes dinámicos de error o éxito -->
                        </div>
                        <form id="registerForm" onsubmit="register(event)">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="full_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                        </form>

                        <div class="text-center mt-3">
                            <p>¿Ya tienes cuenta? <a href="http://localhost/gestion-de-tareas/login">Inicia Sesión</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Definir BASE_URL para JavaScript -->
    <script>
        const BASE_URL = "http://localhost/gestion-de-tareas"; // Cambia según tu entorno
    </script>

    <!-- Cargar JavaScript -->
    <script src="http://localhost/gestion-de-tareas/assets/js/auth.js"></script>
</body>

</html>
