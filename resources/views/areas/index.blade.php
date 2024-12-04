@extends('layouts.layout')

@section('content')

<div class="container"  style="margin-top: -35px;">
                <div class="titulo mt-2 text-big text-semibold Gibson Medium" 
                style="
                    color: #800020; 
                    border-bottom: 3px solid #800020;
                    font-size: 1.8rem;
                    font-weight: bold;
                    letter-spacing: 1px;
                    padding-bottom: 8px;
                    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
                    position: relative;
                ">
                <i class="bi bi-check-circle-fill me-2" style="color: #800020; font-size: 1.4rem;"></i>
                AREAS
            </div>

            <form method="GET" action="{{ route('areas.index') }}" class="d-flex align-items-end gap-2" style="margin-top:5px">
    <div class="form-group mb-0">
        <label for="dependencia_id" class="sr-only">Selecciona Dependencia:</label>
        <select name="dependencia_id" id="dependencia_id" class="form-control form-control-sm">
            <option value="">Selecciona Dependencia</option>
            @foreach($dependencias as $dependencia)
                <option value="{{ $dependencia->id }}" 
                    {{ request('dependencia_id') == $dependencia->id ? 'selected' : '' }}>
                    {{ $dependencia->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-0">
        <label for="area_id" class="sr-only">Selecciona Área:</label>
        <select name="area_id" id="area_id" class="form-control form-control-sm" disabled>
            <option value="">Selecciona Área</option>
            <!-- Las áreas se cargarán dinámicamente aquí -->
        </select>
    </div>

    <button type="submit" class="btn btn-sm btn-primary">Buscar</button>
    <a href="{{ route('areas.index') }}" class="btn btn-sm btn-secondary">Todos los registros</a>
</form>

        <!-- Mensaje si no hay area -->
        @if($areas->isEmpty())
            <div class="alert alert-warning text-center" role="alert">
                No hay areas registradas.
            </div>
        @else
            <!-- Contenedor con scroll -->
            <div class="scroll-container"  style="margin-top: 6px;">
                <div class="row">
                    @foreach ($areas as $area)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <!-- Icono de area -->
                                        <i class="bi bi-building me-3" style="font-size: 2rem; color: #007bff;"></i>
                                        <h5 class="card-title mb-0">{{ $area->nombre }}</h5>
                                    </div>

                                    <strong>Descripción:</strong> 
                                    {{ $area->descripcion }}
                                    </p>

                                    <strong>Dependencia:</strong> 
                                    {{ $area->dependencia ? $area->dependencia->nombre : 'Sin dependencia asignada' }}
                                    </p>

                                    <!-- Estatus de la area -->
                                    <div class="badge {{ $area->estatus == 0 ? 'bg-danger' : 'bg-success' }} text-white">
                                        {{ $area->estatus == 0 ? 'Inactiva' : 'Activa' }}
                                    </div>

                                    <!-- Botones de acción -->
                                
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>



    <script>
        document.getElementById('dependencia_id').addEventListener('change', function () {
    const dependenciaId = this.value;
    const areaSelect = document.getElementById('area_id');

    // Deshabilita el select de áreas mientras carga
    areaSelect.disabled = true;
    areaSelect.innerHTML = '<option value="">-- Cargando Áreas --</option>';

    if (dependenciaId) {
        fetch(`/areas/por-dependencia?dependencia_id=${dependenciaId}`)
            .then(response => response.json())
            .then(data => {
                areaSelect.innerHTML = '<option value="">-- Seleccione un Área --</option>';
                data.forEach(area => {
                    areaSelect.innerHTML += `<option value="${area.id}">${area.nombre}</option>`;
                });
                areaSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error al cargar las áreas:', error);
                areaSelect.innerHTML = '<option value="">-- Error al cargar --</option>';
            });
    } else {
        areaSelect.innerHTML = '<option value="">-- Seleccione una Dependencia --</option>';
        areaSelect.disabled = true;
    }
});

    </script>

@endsection
