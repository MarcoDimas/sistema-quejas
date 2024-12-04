@extends('layouts.layout')

@section('content')
<div class="container" style="margin-top: -45px">
    <h1 class="text-center" style="color: #4A001F;">Gestión de Usuarios</h1>
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

    <!-- Barra de búsqueda -->

    <div class="input-group mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre, email, rol, etc.">
        <span class="input-group-text"><i class="bi bi-search fs-6"></i></span>
    </div>

    @if (auth()->user()->id_roles == 1)

    <form method="GET" action="{{ route('usuarios.index') }}" class="d-flex align-items-end gap-2" style="margin-top:-13px">
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

   

    <button type="submit" class="btn btn-sm btn-primary">Buscar</button>
    <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-secondary">Todos los registros</a>
</form>
@endif
    <!-- Contenedor de Tarjetas con Scroll -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 " 
         id="userCardsContainer" style="max-height: 355px; overflow-y: auto; margin-top: 3px">
        @foreach ($usuarios as $usuario)
        <div class="col user-card" 
             data-name="{{ strtolower($usuario->name) }}" 
             data-email="{{ strtolower($usuario->email) }}" 
             data-rol="{{ strtolower($usuario->rol->nombre ?? 'Sin rol') }}" 
             data-dependencia="{{ strtolower($usuario->dependencia->nombre ?? 'Sin dependencia') }}">
            <div class="card h-100 d-flex flex-column justify-content-between" style="font-size: 0.85rem;">
                <div class="card-header text-white py-2" style="background-color: #6A0F49;">
                    <h6 class="card-title mb-0 text-truncate">{{ $usuario->dependencia->nombre ?? 'Sin dependencia' }}</h6>
                </div>
                <div class="card-body p-2">
                    <p class="mb-1 text-truncate"><strong>Nombre:</strong> {{ $usuario->name }}</p>
                    <p class="mb-1 text-truncate"><strong>Email:</strong> {{ $usuario->email }}</p>
                    <p class="mb-1"><strong>Rol:</strong> {{ $usuario->rol->nombre ?? 'Sin rol' }}</p>
                    <p class="mb-0">
                        <strong>Estado:</strong> 
                        <span class="badge {{ $usuario->estatus == 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $usuario->estatus == 1 ? 'Activo' : 'Inactivo' }}
                        </span>
                    </p>
                </div>
                <div class="card-footer py-1 d-flex justify-content-between">
                    <!-- Botón para editar contraseña -->
                    <button title="EDITAR PASSWORD" type="button" class="btn btn-primary btn-sm "
                        data-bs-toggle="modal" 
                        data-bs-target="#editarPasswordModal{{ $usuario->id }}"
                        @if (!$usuario->estatus) disabled @endif>
                        <i class="bi bi-pencil fs-6"></i>
                    </button>
                    
                    <!-- Botones de estado -->
                    <form method="POST" action="{{ route('usuarios.desactivar', ['id' => $usuario->id]) }}" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button  title="DESACTIVAR USUARIO" type="submit" class="btn btn-warning btn-sm px-2" @if($usuario->estatus == 0) disabled @endif>
                        <i class="bi bi-arrow-down-square fs-6"></i>                   
                         </button>
                    </form>

                    @if ($usuario->estatus == 0)
                        <form method="POST" action="{{ route('usuarios.reactivar', ['id' => $usuario->id]) }}" style="display:inline;">
                            @csrf
                            <button title="REACTIVAR USUARIO" type="submit" class="btn btn-success btn-sm px-2">
                            <i class="bi bi-arrow-up-square fs-6"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal para editar contraseña -->
@foreach ($usuarios as $usuario)
<div class="modal fade" id="editarPasswordModal{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="editarPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="editarPasswordModalLabel">
                    <i class="bi bi-lock-fill"></i> Editar Contraseña
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('actualizar.password', ['id' => $usuario->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Nueva Contraseña:</label>
                        <div class="input-group">
                            <input type="password" class="form-control border-2 rounded-3" id="password-{{ $usuario->id }}" name="password" placeholder="Ingresa la nueva contraseña" autocomplete="new-password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3 rounded-3 py-2">Actualizar Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


<script>
   document.getElementById('searchInput').addEventListener('input', function () {
    const query = this.value.toLowerCase();
    const cards = document.querySelectorAll('.user-card');
    let hasResults = false;

    cards.forEach(card => {
        const name = card.getAttribute('data-name');
        const email = card.getAttribute('data-email');
        const rol = card.getAttribute('data-rol');
        const dependencia = card.getAttribute('data-dependencia');

        const matches = name.includes(query) || email.includes(query) || rol.includes(query) || dependencia.includes(query);
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
