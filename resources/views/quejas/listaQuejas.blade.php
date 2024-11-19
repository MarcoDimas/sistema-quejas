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
                Lista Quejas
            </div>

        @if($quejas->isEmpty())
            <div class="alert alert-warning text-center" role="alert">
                No hay quejas registradas.
            </div>
        @else

          <div class="scroll-container"  style="margin-top: 6px;">
                <div class="row">
                    @foreach ($quejas as $queja)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">

                                    <i class="bi bi-building me-3" style="font-size: 2rem; color: #007bff;"></i>
                                        <h5 class="card-title mb-0">{{ $queja->nombre }}</h5>
                                    </div>

                                    <p class="card-text">
                                        <strong>Email:</strong>
                                            {{ $queja->email }}
                                    </p>

                                    <p class="card-text">
                                        <strong>Motivo:</strong>
                                            {{ $queja->motivo }}
                                    </p>

                                    <p class="card-text">
                                        <strong>Descripción:</strong>
                                            {{ $queja->descripcion }}
                                    </p>
                        
                                    <p class="card-text">
                                    <strong>Dependencia:</strong> 
                                    {{ $queja->dependencia ? $queja->dependencia->nombre : 'Sin dependencia asignada' }}
                                    </p>

                                    <p class="card-text">
                                    <strong>Area:</strong> 
                                    {{ $queja->area ? $queja->area->nombre : 'Sin area asignada' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

@endsection
