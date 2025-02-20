@extends('layouts.layout')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma de Quejas en Línea</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
      
        /* Estilo del contenedor */
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #FFF;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
        }

        /* Título principal */
        .titulo h1 {
            font-size: 3rem;
            margin: 0;
            color: #4A001F;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1.5s ease-out;
        }

        /* Subtítulo */
        .titulo2 {
            font-size: 1.5rem;
            color: #4A001F;
            border-top: 2px solid #FFC3D0;
            padding-top: 15px;
            margin-top: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
            animation: fadeIn 2s ease-out;
        }

        /* Animaciones */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Botón opcional */
        .cta-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4A001F;
            color: #FFC3D0;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }

        .cta-button:hover {
            background-color: #FFC3D0;
            color: #4A001F;
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="titulo">
            <h1>GESTOR DE QUEJAS</h1>
        </div>
        <div class="titulo2">
            <p>Esta plataforma innovadora facilita la gestión de quejas por parte del ciudadano.</p>
        </div>

        <a href="{{ route('quejas.create') }}" class="cta-button">Enviar una Queja</a>

    </div>
</body>
</html>
@endsection
