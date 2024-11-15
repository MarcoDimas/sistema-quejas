

@extends('layouts.layout')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quejas</title>
</head>
<body>
<h1>Crear Nueva Queja</h1>

<form action="{{ route('quejas.store') }}" method="POST">
        @csrf
        <div>
            <label for="titulo">Título de la queja</label>
            <input type="text" name="titulo" id="titulo" required>
        </div>

        <div>
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="4" required></textarea>
        </div>

        <div>
            <label for="dependencia">Dependencia</label>
            <select name="dependencia_id" id="dependencia">
                @foreach ($dependencias as $dependencia)
                    <option value="{{ $dependencia->id }}">{{ $dependencia->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="area">Área</label>
            <select name="area_id" id="area">
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Enviar Queja</button>
    </form>
</body>
</html>

@endsection