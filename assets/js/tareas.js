document.addEventListener("DOMContentLoaded", function () {
    obtenerTareas();
});

const BASE_URL = "http://localhost/gestion-de-tareas";

async function obtenerTareas() {
    try {
        const respuesta = await fetch(`${BASE_URL}/tareas/obtenerTareas`);
        const resultado = await respuesta.json();

        if (resultado.status === "error") {
            throw new Error(resultado.message);
        }

        const tbody = document.getElementById("tablaTareas");
        if (!tbody) throw new Error("Elemento con id 'tablaTareas' no encontrado.");

        tbody.innerHTML = resultado.data
            .map(
                (tarea) => `
                <tr>
                    <td>${tarea.id}</td>
                    <td>${tarea.titulo}</td>
                    <td>${tarea.descripcion}</td>
                    <td>${tarea.estado}</td>
                    <td>${tarea.fecha_inicio}</td>
                    <td>${tarea.fecha_limite}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="dataEditar(${JSON.stringify(tarea).replace(/"/g, '&quot;')})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarTarea(${tarea.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`
            )
            .join("");
    } catch (error) {
        console.error(error.message);
        showAlert("error", "Error al cargar tareas.");
    }
}

async function guardarTarea() {
    const id_tarea = document.getElementById("tareaId").value;
    if (id_tarea) {
        actualizarTarea();
    } else {
        crearTarea();
    }
}

async function crearTarea() {
    try {
        const tarea = {
            titulo: document.getElementById("titulo").value,
            descripcion: document.getElementById("descripcion").value,
            estado: document.getElementById("estado").value,
            fecha_inicio: document.getElementById("fecha_inicio").value,
            fecha_limite: document.getElementById("fecha_limite").value,
        };

        const response = await fetch(`${BASE_URL}/tareas/guardar`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(tarea),
        });

        const resultado = await response.json();

        if (resultado.status === "error") {
            throw new Error(resultado.message);
        }

        obtenerTareas();
        resetForm();
        showAlert("success", "Tarea creada exitosamente.");
    } catch (error) {
        showAlert("error", error.message);
    }
}

function resetForm() {
    document.getElementById("tareaForm").reset();
    document.getElementById("tareaId").value = "";
}

function dataEditar(tarea) {
    document.getElementById("tareaId").value = tarea.id;
    document.getElementById("titulo").value = tarea.titulo;
    document.getElementById("descripcion").value = tarea.descripcion;
    document.getElementById("estado").value = tarea.estado;
    document.getElementById("fecha_inicio").value = tarea.fecha_inicio;
    document.getElementById("fecha_limite").value = tarea.fecha_limite;

    const modal = new bootstrap.Modal(document.getElementById("tareaModal"));
    modal.show();
}

async function actualizarTarea() {
    try {
        const tarea = {
            id: document.getElementById("tareaId").value,
            titulo: document.getElementById("titulo").value,
            descripcion: document.getElementById("descripcion").value,
            estado: document.getElementById("estado").value,
            fecha_inicio: document.getElementById("fecha_inicio").value,
            fecha_limite: document.getElementById("fecha_limite").value,
        };

        const response = await fetch(`${BASE_URL}/tareas/actualizar`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(tarea),
        });

        const resultado = await response.json();

        if (resultado.status === "error") {
            throw new Error(resultado.message);
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById("tareaModal"));
        modal.hide();

        showAlert("success", "Tarea actualizada exitosamente.");
        obtenerTareas();
        resetForm();
    } catch (error) {
        showAlert("error", error.message);
    }
}

async function eliminarTarea(id) {
    try {
        if (!confirm("¿Está seguro de que desea eliminar esta tarea?")) {
            return;
        }

        const response = await fetch(`${BASE_URL}/tareas/eliminar`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ id }),
        });

        const resultado = await response.json();

        if (resultado.status === "error") {
            throw new Error(resultado.message);
        }

        showAlert("success", "Tarea eliminada correctamente.");
        obtenerTareas();
    } catch (error) {
        showAlert("error", error.message);
    }
}

function showAlert(type, message) {
    const alertContainer = document.getElementById("alertContainer");

    if (!alertContainer) {
        console.error("No se encontró el contenedor de alertas.");
        return;
    }

    const alert = document.createElement("div");
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.role = "alert";
    alert.innerHTML = `
        <strong>${type.toUpperCase()}:</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    alertContainer.appendChild(alert);

    setTimeout(() => {
        alert.remove();
    }, 5000);
}
