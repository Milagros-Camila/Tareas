<div class="row mb-4">
    <div class="col">
        <h2>Listado de Tareas</h2>
    </div>
    <div class="col text-end">
        <!-- Botón para exportar PDF -->
        <a href="<?= BASE_URL ?>/reporte-tarea/pdf" class="btn btn-secondary">
            <i class="fas fa-file-pdf"></i> Exportar a PDF
        </a>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tareaModal">
            <i class="fas fa-plus"></i> Nueva Tarea
        </button>
    </div>
</div>

<!-- Tabla de tareas -->
<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Fecha de Inicio</th>
                <th>Fecha Límite</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id="tablaTareas">
            <!-- Aquí se cargan las tareas dinámicamente -->
        </tbody>
    </table>
</div>

<!-- Modal para Crear/Editar Tarea -->
<div class="modal fade" id="tareaModal" tabindex="-1" style="display:none" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gua">Nueva Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="tareaForm">
                    <input type="hidden" id="tareaId">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control" id="estado" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Completado">Completado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_limite" class="form-label">Fecha Límite</label>
                        <input type="date" class="form-control" id="fecha_limite" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
                <button type="button" class="btn btn-primary" onclick="guardarTarea()">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
