<?php
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
    <title>Login - Gestión de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Iniciar Sesión</h2>
                        <div id="loginAlert">
                            <!-- Mensajes de error o éxito dinámicos se mostrarán aquí -->
                        </div>
                        <form id="loginForm" onsubmit="login(event)">
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Iniciar Sesión
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <p>¿No tienes cuenta? <a href="<?= BASE_URL ?>/register">Regístrate</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const BASE_URL = "http://localhost/gestion-de-tareas"; // Ajusta la URL base según tu proyecto
    </script>
    <script src="<?= BASE_URL ?>/assets/js/auth.js"></script>
</body>
</html>
