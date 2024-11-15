@extends('layouts.layout')

@section('content')

    <div class="container"  style="margin-top: -35px;">
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
            <i class="bi bi-check-circle-fill me-2" style="color: #800020; font-size: 1.4rem;"></i> <!-- Ícono moderno -->
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
        <div class="card shadow-sm" style="margin-top: 25px;" >
            <div class="card-body">
                <!-- Formulario para Crear una Nueva Dependencia -->
                <form action="{{ route('dependencias.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre" class="form-label">
                            <i class="bi bi-building me-2"></i> Nombre de la Dependencia
                        </label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">
                            <i class="bi bi-journal-text me-2"></i> Descripción
                        </label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
                    </div>

                    <!-- Botón para enviar el formulario -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i> Crear Dependencia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
