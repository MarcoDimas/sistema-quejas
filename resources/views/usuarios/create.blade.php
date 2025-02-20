@extends('layouts.layout')

@section('content')

<div class="container" style="margin-top: -50px;">
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
        <i class="bi bi-person-plus-fill me-2" style="color: #800020; font-size: 1.4rem;"></i> 
        Crear Usuario
    </div>

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

        
    <div class="card shadow-sm" style="margin-top: 5px;">
        <div class="card-body">
            <!-- Formulario para Crear un Nuevo Usuario -->
            <form action="{{ route('usuarios.store') }}" method="POST" class="scroll-container"  style="margin-top: 6px;">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="bi bi-person me-2"></i> Nombre del Usuario
                    </label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope me-2"></i> Correo Electrónico
                    </label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-key-fill me-2"></i> Contraseña
                    </label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="id_roles" class="form-label">
                        <i class="bi bi-shield-lock-fill me-2"></i> Rol del Usuario
                    </label>
                    <select id="id_roles" name="id_roles" class="form-select" required>
                        <option value="" disabled selected>Selecciona un rol</option>
                        @forelse($roles as $rol)
                            <option value="{{ $rol->id }}" {{ old('id_roles') == $rol->id ? 'selected' : '' }}>
                                {{ $rol->nombre }}
                            </option>
                        @empty
                            <option value="" disabled>No hay roles disponibles</option>
                        @endforelse
                    </select>
                </div>

               <div class="mb-3">
                    <label for="id_dependencia" class="form-label">
                        <i class="bi bi-building me-2"></i> Dependencia
                    </label>
                    <select id="id_dependencia" name="id_dependencia" class="form-select" required>
                        <option value="" disabled selected>Selecciona una dependencia</option>
                        @forelse($dependencias as $dependencia)
                            <option value="{{ $dependencia->id }}" {{ old('id_dependencia') == $dependencia->id ? 'selected' : '' }}>
                                {{ $dependencia->nombre }}
                            </option>
                        @empty
                            <option value="" disabled>No hay dependencias disponibles</option>
                        @endforelse
                    </select>
                </div>


                <!-- Botón para enviar el formulario -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i> Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
