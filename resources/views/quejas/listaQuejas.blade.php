@extends('layouts.layout')

@section('content')
<div class="container" style="margin-top: -45px">
    <h1 class="text-center" style="color: #4A001F;">Listado de Quejas</h1>

    @if(session('success'))
        <div class="alert alert-success custom-alert-success" style="margin-top: 4px; background-color: #4caf50; color: #fff;">
            <i class="bi bi-check-circle me-2"></i> <!-- Icono de palomita -->
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger custom-alert-error" style="margin-top: 4px; background-color: #f44336; color: #fff;">
            <i class="bi bi-x-circle me-2"></i> <!-- Icono de tache -->
            {{ session('error') }}
        </div>
    @endif

    @if (session('reload'))
        <script>
            setTimeout(function() {
                location.reload();
            }, 1500); // Espera 1.5 segundos antes de recargar
        </script>
    @endif

    <!-- Barra de búsqueda -->
    <form method="GET" action="{{ route('quejas.listaQuejas') }}">
    <div class="row mb-4">
        <!-- Filtro de Dependencia -->
        @if (auth()->user()->id_roles == 1 || auth()->user()->id_roles == 2)

        <div class="col-md-3">
            <label for="dependencia_id" class="form-label">Dependencia:</label>
            <select name="dependencia_id" id="dependencia_id" class="form-select" onchange="cargarAreas()">
                <option value="">-- Todas las dependencias --</option>
                @foreach($dependencias as $dependencia)
                    <option value="{{ $dependencia->id }}" {{ request('dependencia_id') == $dependencia->id ? 'selected' : '' }}>
                        {{ $dependencia->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filtro de Área -->
        <div class="col-md-3">
            <label for="area_id" class="form-label">Área:</label>
            <select name="area_id" id="area_id" class="form-select">
                <option value="">-- Todas las áreas --</option>
            </select>
        </div>

        @endif

        <!-- Filtro de Estado -->
        <div class="col-md-3">
            <label for="estado" class="form-label">Estado:</label>
            <select name="estado" id="estado" class="form-select">
                <option value="">-- Todos los estados --</option>
                @foreach($estados as $estado)
                    <option value="{{ $estado }}" {{ request('estado') == $estado ? 'selected' : '' }}>
                        {{ ucfirst($estado) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Botón de búsqueda -->
        <div class="col-md-3 mt-4">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{ route('quejas.listaQuejas') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </div>
</form>

<!-- Script para cargar áreas dinámicamente -->
<script>
    // Cargar áreas dinámicamente basado en la dependencia seleccionada
    const dependencias = @json($dependencias);

    function cargarAreas() {
        const dependenciaId = document.getElementById('dependencia_id').value;
        const areaSelect = document.getElementById('area_id');

        // Limpiar opciones de áreas
        areaSelect.innerHTML = '<option value="">-- Todas las áreas --</option>';

        if (dependenciaId) {
            // Buscar las áreas de la dependencia seleccionada
            const areas = dependencias.find(dep => dep.id == dependenciaId)?.areas || [];
            areas.forEach(area => {
                const option = new Option(area.nombre, area.id);
                areaSelect.add(option);
            });
        }
    }

    // Cargar áreas al iniciar si hay una dependencia seleccionada
    window.onload = cargarAreas;
</script>


    <!-- Contenedor de Tarjetas con Scroll -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-1" 
         id="userCardsContainer" style="max-height: 355px; max-width: 1100px; overflow-y: auto;">
        @foreach ($quejas as $queja)
        <div class="col user-card" 
             data-nombre="{{ strtolower($queja->nombre) }}" 
             data-email="{{ strtolower($queja->email) }}" 
             data-motivo="{{ strtolower($queja->motivo) }}" 
             data-descripcion="{{ strtolower($queja->descripcion) }}" 
             data-dependencia="{{ strtolower($queja->dependencia->nombre ?? 'Sin dependencia') }}">
            <div class="card h-100 d-flex flex-column justify-content-between" style="font-size: 0.85rem;">
                <div class="card-header text-white py-2" 
                     style="background-color: {{ $queja->estado === 'pendiente' ? '#FFC107' : 
                                             ($queja->estado === 'en proceso' ? '#17A2B8' : 
                                             ($queja->estado === 'resuelta' ? '#28A745' : '#DC3545')) }};">
                    <h6 class="card-title mb-0 text-truncate">
                        {{ $queja->area->nombre ?? 'Sin área' }} 
                        <span class="badge bg-light text-dark">{{ ucfirst($queja->estado) }}</span>
                    </h6>
                </div>

                <div class="card-body p-2">
                    <p class="mb-1 text-truncate"><strong>Nombre:</strong> {{ $queja->nombre }}</p>
                    <p class="mb-1 text-truncate"><strong>Email:</strong> {{ $queja->email }}</p>
                    <p class="mb-1"><strong>Dependencia.:</strong> {{ $queja->dependencia->nombre ?? 'Sin dependencia' }}</p>
                    <p class="mb-1 text-truncate"><strong>Motivo:</strong> {{ $queja->motivo }}</p>
                    <p class="mb-1 text-truncate"><strong>Descripción:</strong> {{ Str::limit($queja->descripcion, 100) }}</p> <!-- Mostrar solo una parte de la descripción -->
                </div>

                <!-- Botón "Ver" para abrir el Modal -->
                <div class="card-footer py-1 d-flex justify-content-start gap-2">
                    <!-- Formulario para cambiar el estado -->
                    @if (auth()->user()->id_roles == 1 || auth()->user()->id_roles == 2)

                    <form action="{{ route('quejas.updateStatus', $queja->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="estado" value="{{ $queja->estado }}">

                        @if ($queja->estado === 'pendiente')
                            <button  title="Clic para marcar como en proceso esta queja"  type="submit" class="btn btn-warning btn-sm px-2 py-1 rounded-pill shadow" onclick="this.form.estado.value='en proceso'">
                                <i class="fas fa-spinner me-1" style="font-size: 0.8rem;"></i> P
                            </button>
                        @elseif ($queja->estado === 'en proceso')
                            <button  title="Clic para marcar como resuelta esta queja" type="submit" class="btn btn-success btn-sm px-2 py-1 rounded-pill shadow" onclick="this.form.estado.value='resuelta'">
                                <i class="fas fa-check me-1" style="font-size: 0.8rem;"></i> R
                            </button>
                        @endif

                        @if ($queja->estado !== 'rechazada')
                            <button type="submit" class="btn btn-danger btn-sm px-2 py-1 rounded-pill shadow" onclick="this.form.estado.value='rechazada'" title="Rechazar esta queja">
                                <i class="fas fa-ban me-1" style="font-size: 0.8rem;"></i> 
                            </button>
                        @endif
                    </form>



                    <!-- Formulario para eliminar la queja -->
                    <form action="{{ route('quejas.eliminarQueja', $queja->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button  title="Elimina esta queja" type="submit" class="btn btn-danger btn-sm px-2 py-1 rounded-pill shadow">
                            <i class="fas fa-trash me-1" style="font-size: 0.8rem;"></i> 
                        </button>
                    </form>

                    @endif

                    
                    <button title="Ver esta queja" 
                        type="button" 
                        class="btn btn-info btn-sm px-2 py-1 rounded-pill shadow verQuejaBtn" 
                        data-bs-toggle="modal" 
                        data-bs-target="#quejaModal"
                        data-nombre="{{ $queja->nombre }}"
                        data-email="{{ $queja->email }}"
                        data-dependencia="{{ $queja->dependencia->nombre ?? 'Sin dependencia' }}"
                        data-motivo="{{ $queja->motivo }}"
                        data-descripcion="{{ $queja->descripcion }}"
                        data-archivo="{{ $queja->archivo ? asset('storage/' . $queja->archivo) : '' }}">
                        <i class="fas fa-eye me-1" style="font-size: 0.8rem;"></i>
                    </button>

                    @if (auth()->user()->id_roles == 1 || auth()->user()->id_roles == 2)

                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                            data-bs-target="#respuestaModal" 
                            data-id="{{ $queja->id }}" 
                            data-email="{{ $queja->email }}"
                            title="Responde a esta queja">
                            <i class="bi bi-send-plus fs-6" ></i>
                    </button>

                    @endif



                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal para mostrar información completa de la queja -->
<div class="modal fade" id="quejaModal" tabindex="-1" aria-labelledby="quejaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Encabezado del Modal -->
            <div class="modal-header" style="background-color: #4A001F; color: #fff;">
                <h5 class="modal-title" id="quejaModalLabel"><i class="fas fa-info-circle me-2"></i>Detalles de la Queja</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <!-- Nombre y Email -->
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <p class="mb-2"><strong>Nombre:</strong> <span id="modalNombre"></span></p>
                                    <p class="mb-0"><strong>Email:</strong> <span id="modalEmail"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Dependencia y Motivo -->
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <p class="mb-2"><strong>Dependencia:</strong> <span id="modalDependencia"></span></p>
                                    <p class="mb-0"><strong>Area:</strong>  {{ $queja->area->nombre ?? 'Sin área' }}</p>

                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="col-12" style="margin-bottom: 20px;">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                <p class="mb-0"><strong>Motivo:</strong> <span id="modalMotivo"></span></p>

                                    <p class="mb-0"><strong>Descripción:</strong></p>
                                    <p class="text-muted" id="modalDescripcion" style="white-space: pre-line;"></p>
                                </div>
                            </div>
                        </div>
            

                        <!-- Sección del archivo adjunto -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p><strong>Archivo adjunto:</strong></p>
                                <div id="archivoAdjunto">
                                    <p class="text-muted">No se adjuntó ningún archivo.</p>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>

            <!-- Pie del Modal -->
            <div class="modal-footer" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Modal para responder a una queja -->
<div class="modal fade" id="respuestaModal" tabindex="-1" aria-labelledby="respuestaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg rounded">
            <form id="respuestaForm" method="POST" action="{{ route('quejas.responder') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background-color: #4A001F; color: white;">
                    <h5 class="modal-title" id="respuestaModalLabel">Responder Queja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="queja_id" id="quejaId">
                    <input type="hidden" name="email" id="quejaEmail">

                    <!-- Campo de "Respondido por" -->
                    <div class="mb-3">
                        <label for="respondidoPor" class="form-label" style="color: #6A0F49;">Respondido por:</label>
                        <input type="text" name="respondido_por" id="respondidoPor" class="form-control" placeholder="Nombre del encargado" required>
                    </div>

                    <!-- Campo de "Correo del encargado" -->
                    <div class="mb-3">
                        <label for="correoEncargado" class="form-label" style="color: #6A0F49;">Correo del encargado:</label>
                        <input type="email" name="correo_encargado" id="correoEncargado" class="form-control" placeholder="Correo electrónico" required>
                    </div>

                    <!-- Campo de "Descripción" -->
                    <div class="mb-3">
                        <label for="descripcion" class="form-label" style="color: #6A0F49;">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" rows="4" class="form-control" placeholder="Escribe tu respuesta aquí" required></textarea>
                    </div>

                    <!-- Campo de "Adjuntar archivo" -->
                    <div class="mb-3">
                        <label for="archivo" class="form-label" style="color: #6A0F49;">Adjuntar archivo:</label>
                        <input type="file" name="archivo" id="archivo" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #FFC3D0; color: #4A001F;">Cerrar</button>
                    <button type="submit" class="btn" style="background-color: #4A001F; color: white;">Enviar Respuesta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script para cargar los datos dinámicamente en el Modal -->
<script>
    const quejaModal = document.getElementById('quejaModal');
    quejaModal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget; // El botón que abrió el modal
        const nombre = button.getAttribute('data-nombre');
        const email = button.getAttribute('data-email');
        const dependencia = button.getAttribute('data-dependencia');
        const motivo = button.getAttribute('data-motivo');
        const descripcion = button.getAttribute('data-descripcion');
        const archivo = button.getAttribute('data-archivo');

        const archivoAdjunto = document.getElementById('archivoAdjunto');
            if (archivo) {
                // Detectar el tipo de archivo por la extensión
                const extension = archivo.split('.').pop().toLowerCase();

                let previewHtml = '';

                if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
                    // Vista previa de imágenes
                    previewHtml = `
                        <img src="${archivo}" alt="Vista previa" class="img-fluid rounded" style="max-width: 300px; display: block; margin-bottom: 10px;">
                        <a href="${archivo}" target="_blank" class="btn btn-link">Ver o descargar archivo</a>`;
                } else if (extension === 'pdf') {
                    // Vista previa de PDF (iframe para mostrar el contenido)
                    previewHtml = `
                        <iframe src="${archivo}" width="100%" height="400px" style="border: none;"></iframe>
                        <a href="${archivo}" target="_blank" class="btn btn-link">Ver en pantalla completa</a>`;
                } else {
                    // Otros tipos de archivos (docx, etc.)
                    previewHtml = `<a href="${archivo}" target="_blank" class="btn btn-link">Descargar archivo</a>`;
                }

                archivoAdjunto.innerHTML = previewHtml;
            } else {
                archivoAdjunto.innerHTML = `<p class="text-muted">No se adjuntó ningún archivo.</p>`;
            }
        // Asignar los valores al modal
        document.getElementById('modalNombre').textContent = nombre;
        document.getElementById('modalEmail').textContent = email;
        document.getElementById('modalDependencia').textContent = dependencia;
        document.getElementById('modalMotivo').textContent = motivo;
        document.getElementById('modalDescripcion').textContent = descripcion;
    });
    
</script>

<script>
    document.getElementById('respuestaModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Botón que activó el modal
    const quejaId = button.getAttribute('data-id');
    const email = button.getAttribute('data-email');

    // Llenar los campos ocultos del formulario
    document.getElementById('quejaId').value = quejaId;
    document.getElementById('quejaEmail').value = email;
});

</script>



<script>
   document.getElementById('searchInput').addEventListener('input', function () {
    const query = this.value.toLowerCase();
    const cards = document.querySelectorAll('.user-card');
    let hasResults = false;

    cards.forEach(card => {
        const nombre = card.getAttribute('data-nombre');
        const email = card.getAttribute('data-email');
        const motivo = card.getAttribute('data-motivo');
        const descripcion = card.getAttribute('data-descripcion');
        const dependencia = card.getAttribute('data-dependencia');

        const matches = nombre.includes(query) || email.includes(query) || motivo.includes(query) || descripcion.includes(query) || dependencia.includes(query);
        card.style.display = matches ? '' : 'none';

        if (matches) {
            hasResults = true;
        }
    });

    // Mostrar u ocultar el mensaje "No se encontraron resultados"
    document.getElementById('noResultsMessage').style.display = hasResults ? 'none' : 'block';
});

</script>
@endsection
