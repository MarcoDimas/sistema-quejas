@extends('layouts.layout')

@section('content')

    <div class="container" style="margin-top: -35px;">
    <div class="ms-5 titulo   mt-2 text-big text-semibold Gibson Medium" style="color:#61727b; border-bottom: 2px solid #61727b;">
        ALTA DEPENDENCIA
    </div>
           @if(session('success'))
                <div class="alert alert-success custom-alert-success" style="margin-top: 4px; background-color: #4caf50; color: #fff;">
                    <i class="bi bi-check-circle me-2"></i> <!-- Icono de palomita -->
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger custom-alert-error" style="margin-top: 4px; background-color: #4caf50; color: #fff;">
                    <i class="bi bi-x-circle me-2"></i> <!-- Icono de tache -->
                    {{ session('error') }}
                </div>
            @endif

            @if (session('reload'))
                <script>
                    setTimeout(function() {
                        location.reload();
                    }, 1500); // Espera 2 segundos antes de recargar
                </script>
            @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Formulario para Crear una Nueva Área -->
                <form action="{{ route('areas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre" class="form-label">
                            <i class="bi bi-geo-alt-fill me-2"></i> Nombre del Área
                        </label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">
                            <i class="bi bi-file-text me-2"></i> Descripción
                        </label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                    <select class="form-control" name="id_dependencia" id="id_dependencia" style="width: 330px;  display: block; background-color: #f9f9f9; text-transform: uppercase;">
                                <option disabled>SELECCIONA DEPENDENCIA</option> 
                                    <!-- Si el usuario tiene el rol 1, mostrar todas las dependencias -->
                                    @foreach($dependencias as $dependencia)
                                        <option value="{{ $dependencia->id }}">{{ $dependencia->nombre }}</option>
                                    @endforeach 
                    </select>
                    </div>

                    <!-- Botón para enviar el formulario -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i> Crear Área
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
