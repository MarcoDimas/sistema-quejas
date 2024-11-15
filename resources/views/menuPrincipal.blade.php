@extends('layouts.layout')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma de Quejas en linea</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .titulo {
            color: #61727b;
            border-bottom: 2px solid #61727b;
            padding-bottom: 10px;
            margin-bottom: 20wpx;
            text-align: center;
        }

        .titulo h1 {
            font-size: 2em;
            margin: 0;
        }

        .user-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.2em;
            color: #61727b;
        }

        .description {
            font-size: 1.2em;
            color: #333;
            margin-top: 30px;
            display: none;
            text-align: center;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .titulo2 {
            color: #61727b;
            border-bottom: 2px solid #61727b;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 20px; /* Cambia 24px al tamaño que desees */
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="titulo">
            <h1>PLATAFORMA DE BUZON DE QUEJAS</h1>
        </div>
        <div class="titulo2">
            <p>Esta plataforma innovadora facilita la gestión de quejas por parte del ciudadano.</p>
        </div>
 
    </div>
</body>
</html>
@endsection
