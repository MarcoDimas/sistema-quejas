

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
    <h1>Lista De Quejas</h1>


    <a href="{{ route('quejas.create') }}" class="btn btn-primary">Crear Nueva Queja</a>

<ul>
    @foreach ($quejas as $queja)
        <li>
            <a href="{{ route('quejas.show', $queja->id) }}">{{ $queja->titulo }}</a>
            - {{ $queja->estado }}
        </li>
    @endforeach
</ul>
</body>
</html>

@endsection