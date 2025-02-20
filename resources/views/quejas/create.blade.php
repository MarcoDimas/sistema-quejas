@extends('layouts.layout')

@section('content')

    <div class="container" style="margin-top: -50px;">
        <!-- Título del Formulario -->
        <div class="titulo mt-2 text-big text-semibold Gibson Medium" 
            style="
                color: #800020; /* Color guinda */
                border-bottom: 3px solid #800020;
                font-size: 1.8rem;
                font-weight: bold;
                letter-spacing: 1px;
                padding-bottom: 8px;
                text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
                position: relative;
            ">
            <i class="bi bi-pencil-square me-2" style="color: #800020; font-size: 1.4rem;"></i> <!-- Ícono -->
            CREAR QUEJA
        </div>

        <!-- Mensajes de éxito o error -->
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
                }, 1500); // Recarga después de 1.5 segundos
            </script>
        @endif

        <!-- Tarjeta del formulario -->
        <div class="card shadow-sm" style="margin-top: 10px;"> 
            <div class="card-body">

                <!-- Formulario para Crear una Nueva Queja -->
                <form action="{{ route('quejas.store') }}" method="POST" enctype="multipart/form-data" class="scroll-container"  style="margin-top: 6px;">
                    @csrf


                    <div class="mb-3">
                        <label for="nombre" class="form-label">
                            <i class="bi bi-person-fill-exclamation"></i>  Nombre completo
                        </label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>

                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                        <i class="bi bi-envelope-at"></i>  Email
                        </label>
                        <input type="text" id="email" name="email" class="form-control" required>

                    </div>

                    <div class="mb-3">
                        <label for="dependencia_id" class="form-label">
                            <i class="bi bi-building me-2"></i> Dependencia
                        </label>
                        <select id="dependencia_id" name="dependencia_id" class="form-select" onchange="fetchAreas(this.value)" required>
                            <option value="">-- Selecciona una Dependencia --</option>
                            @foreach ($dependencias as $dependencia)
                                <option value="{{ $dependencia->id }}">{{ $dependencia->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="area_id" class="form-label">
                            <i class="bi bi-geo-alt me-2"></i> Área
                        </label>
                        <select id="area_id" name="area_id" class="form-select" required>
                            <option value="">-- Selecciona un Área --</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="motivo" class="form-label">
                        <i class="bi bi-pencil me-2"></i> Motivo
                        </label>
                        <input type="text" id="motivo" name="motivo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">
                            <i class="bi bi-chat-left-text me-2"></i> Descripción
                        </label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="archivo" class="form-label" style="color: #6A0F49;">Adjuntar archivo:</label>
                        <input type="file" name="archivo" id="archivo" class="form-control">
                    </div>
                
                    <!-- Botón para enviar el formulario -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-envelope me-2"></i> Enviar Queja
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        async function fetchAreas(dependenciaId) {
            const response = await fetch(`/api/dependencias/${dependenciaId}/areas`);
            const areas = await response.json();

            const areaSelect = document.getElementById('area_id');
            areaSelect.innerHTML = '<option value="">-- Selecciona un Área --</option>';

            areas.forEach(area => {
                const option = document.createElement('option');
                option.value = area.id;
                option.textContent = area.nombre;
                areaSelect.appendChild(option);
            });
        }
    </script>

@endsection
