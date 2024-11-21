<!DOCTYPE html>
<html>
<head>
    <title>Respuesta a tu Queja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f4f8;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            text-align: center;
        }
        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #61727b;
            padding-bottom: 10px;
        }
        .header img {
            margin: 0 10px;
            height: auto;
        }
        h1 {
            color: #61727b;
            padding-bottom: 20px;
            margin-bottom: 30px;
            font-size: 28px;
        }
        .important-info {
            margin-bottom: 30px;
            text-align: center;
        }
        .important-info p {
            margin: 8px 0;
            font-size: 16px;
            color: black;
        }
        .details {
            border-top: 1px solid #61727b;
            padding-top: 20px;
            text-align: center;
        }
        .details h2 {
            font-size: 22px;
            color: #61727b;
            margin-bottom: 15px;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul li {
            margin-bottom: 10px;
            font-size: 16px;
            color: black;
        }
        ul li strong {
            font-weight: bold;
            color: black;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #61727b;
            font-size: 14px;
            background-color: #DCDCDC;
            padding: 20px;
            border-top: 2px solid #61727b;
        }
        .no-reply {
            margin-top: 10px;
            color: #888;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with logos -->
        <div class="header">
            <img src="{{ $message->embed(public_path('imagenes/logoFinanzas.png')) }}" alt="Logo Finanzas" style="width: 210px;">
            <img src="{{ $message->embed(public_path('imagenes/Sello Logo  Principal.png')) }}" alt="Sello Principal" style="width: 110px;">
            <img src="{{ $message->embed(public_path('imagenes/200_mejor.png')) }}" alt="Logo 200 Años" style="width: 215px;">
        </div>

        <!-- Main content -->
        <h1>Respuesta a tu Queja</h1>
        <div class="important-info">
            <p><strong>Hola, Tu queja ha sido respondida. Aquí están los detalles:</strong></p>
        </div>
        <div class="details">
            <h2>Detalles de la Respuesta:</h2>
            <ul>
                <li><strong>Respondido por:</strong> {{ $respondido_por }}</li>
                <li><strong>Correo del encargado:</strong> {{ $correo_encargado }}</li>
            </ul>
        </div>
        <div class="details">
            <h2>Descripción:</h2>
            <p>{{ $descripcion }}</p>
        </div>
        <br>
        <div class="footer">
            <p class="no-reply">Favor de no responder a este mensaje, es un envío automático.</p>
        </div>
    </div>
</body>
</html>
