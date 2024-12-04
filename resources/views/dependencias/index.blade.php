@extends('layouts.layout')

@section('content')
<div class="container" style="margin-top: -35px;">
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
        DEPENDENCIAS
    </div>

    <!-- Buscador en vivo -->
    <div class="input-group mt-3 mb-3">
        <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Buscar por nombre o descripción">
        <span class="input-group-text"><i class="bi bi-search fs-6"></i></span>
    </div>

    <!-- Contenedor de resultados -->
    <div id="resultsContainer" class="row">
        @foreach ($dependencias as $dependencia)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-light">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-building me-3" style="font-size: 2rem; color: #007bff;"></i>
                            <h5 class="card-title mb-0">{{ $dependencia->nombre }}</h5>
                        </div>
                        <p class="card-text">{{ $dependencia->descripcion }}</p>
                        <div class="badge {{ $dependencia->estatus == 0 ? 'bg-danger' : 'bg-success' }} text-white">
                            {{ $dependencia->estatus == 0 ? 'Inactiva' : 'Activa' }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const resultsContainer = document.getElementById('resultsContainer');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value;

            fetch(`/dependencias/search?search=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = ''; // Limpiar resultados anteriores
                    if (data.length === 0) {
                        resultsContainer.innerHTML = `
                            <div class="col-12">
                                <div class="alert alert-warning text-center" role="alert">
                                    No se encontraron dependencias.
                                </div>
                            </div>
                        `;
                        return;
                    }

                    data.forEach(dependencia => {
                        const card = `
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm border-light">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-building me-3" style="font-size: 2rem; color: #007bff;"></i>
                                            <h5 class="card-title mb-0">${dependencia.nombre}</h5>
                                        </div>
                                        <p class="card-text">${dependencia.descripcion}</p>
                                        <div class="badge ${dependencia.estatus === 0 ? 'bg-danger' : 'bg-success'} text-white">
                                            ${dependencia.estatus === 0 ? 'Inactiva' : 'Activa'}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        resultsContainer.innerHTML += card;
                    });
                })
                .catch(error => console.error('Error fetching dependencias:', error));
        });
    });
</script>
