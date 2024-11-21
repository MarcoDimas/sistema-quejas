@extends('layouts.layout')

@section('content')
<div class="container" style="margin-top: -45px">
    <h1 class="text-center" style="color: #4A001F;">Gestión de Usuarios</h1>

    <!-- Barra de búsqueda -->
    <div class="input-group mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre, email, rol, etc.">
        <span class="input-group-text"><i class="bi bi-search fs-6"></i></span>
    </div>

    <!-- Contenedor de Tarjetas con Scroll -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3" 
         id="userCardsContainer" style="max-height: 355px; overflow-y: auto;">
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
                    <button class="btn btn-primary btn-sm px-2">Editar</button>
                    <button class="btn btn-warning btn-sm px-2">Desactivar</button>
                    @if ($usuario->estatus == 0)
                        <button class="btn btn-success btn-sm px-2">Reactivar</button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Filtro Dinámico con JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const userCards = document.querySelectorAll('.user-card');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.toLowerCase();

            userCards.forEach(card => {
                const name = card.getAttribute('data-name');
                const email = card.getAttribute('data-email');
                const rol = card.getAttribute('data-rol');
                const dependencia = card.getAttribute('data-dependencia');

                if (name.includes(query) || email.includes(query) || rol.includes(query) || dependencia.includes(query)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
