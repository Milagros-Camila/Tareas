async function login(event) {
  event.preventDefault();

  const nombreUsuario = document.getElementById("username").value;
  const claveUsuario = document.getElementById("password").value;
  try {
    const respuesta = await fetch("auth/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        nombreUsuario,
        claveUsuario,
      }),
    });

    const respuestaJson = await respuesta.json();

    if (respuestaJson.status === "error") {
      showAlertAuth("loginAlert", "error", respuestaJson.message);
      return false;
    }

    //Redireccionar a la pagina web
    window.location.href = "home";
  } catch (error) {
    showAlertAuth("loginAlert", "error", "Error al iniciar sesión: ".error);
    return false;
  }
}

async function register(event) {
  event.preventDefault();

  // Obtener valores de los campos del formulario
  const fullName = document.getElementById('full_name')?.value.trim();
  const username = document.getElementById('username')?.value.trim();
  const email = document.getElementById('email')?.value.trim();
  const password = document.getElementById('password')?.value.trim();
  const confirmPassword = document.getElementById('confirm_password')?.value.trim();

  // Verificar que todos los campos estén completos
  if (!fullName || !username || !email || !password || !confirmPassword) {
      alert('Todos los campos son obligatorios.');
      return;
  }

  // Verificar que las contraseñas coincidan
  if (password !== confirmPassword) {
      alert('Las contraseñas no coinciden.');
      return;
  }

  try {
    const registerUrl = `${BASE_URL}/auth/register`; // Asegúrate de que BASE_URL esté definido en el HTML principal

    // Configuración de la solicitud
    const response = await fetch(registerUrl, {
        method: 'POST', // Método HTTP
        headers: {
            'Content-Type': 'application/json', // Encabezado para enviar JSON
        },
        body: JSON.stringify({ 
            full_name: fullName, 
            username: username, 
            email: email, 
            password: password, 
            confirm_password: confirmPassword 
        }), // Cuerpo de la solicitud
    });

    const result = await response.json(); // Procesar la respuesta como JSON

    if (result.status === 'success') {
        alert(result.message); // Mostrar mensaje de éxito
        window.location.href = `${BASE_URL}/login`; // Redirigir al login
    } else {
        alert(result.message); // Mostrar mensaje de error del servidor
    }
} catch (error) {
    console.error('Error al registrar:', error); // Log de errores en consola
    alert('Error al registrar. Inténtalo nuevamente.'); // Mensaje genérico para el usuario
}



function showAlertAuth(containerId, type, message) {
  const container = document.getElementById(containerId);
  container.innerHTML = `
        <div class="alert alert-${
          type === "error" ? "danger" : "success"
        } alert-dismissible fade show">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

  // Auto-cerrar después de 5 segundos
  setTimeout(() => {
    const alert = container.querySelector(".alert");
    if (alert) {
      alert.remove();
    }
  }, 5000);
}
}
