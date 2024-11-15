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
                DEPENDENCIAS
            </div>


        <!-- Mensaje si no hay dependencias -->
        @if($dependencias->isEmpty())
            <div class="alert alert-warning text-center" role="alert">
                No hay dependencias registradas.
            </div>
        @else
            <!-- Contenedor con scroll -->
            <div class="scroll-container"  style="margin-top: 6px;">
                <div class="row">
                    @foreach ($dependencias as $dependencia)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <!-- Icono de Dependencia -->
                                        <i class="bi bi-building me-3" style="font-size: 2rem; color: #007bff;"></i>
                                        <h5 class="card-title mb-0">{{ $dependencia->nombre }}</h5>
                                    </div>

                                    <p class="card-text">{{ $dependencia->descripcion }}</p>

                                    <!-- Estatus de la Dependencia -->
                                    <div class="badge {{ $dependencia->estatus == 0 ? 'bg-danger' : 'bg-success' }} text-white">
                                        {{ $dependencia->estatus == 0 ? 'Inactiva' : 'Activa' }}
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

@endsection