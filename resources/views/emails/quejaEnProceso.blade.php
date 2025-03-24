<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta a tu Queja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFC3D0; /* Rosa Claro */
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #FFFFFF; /* Blanco */
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 700px;
            width: 100%;
            text-align: center;
        }
        .header {
            background-color: #4A001F; /* Guinda */
            color: #FFFFFF; /* Blanco */
            border-radius: 8px 8px 0 0;
            padding: 20px;
            margin-bottom: 20px;
        }
        .header img {
            margin: 0 10px;
            height: auto;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .important-info {
            background-color: #FFC3D0; /* Rosa Claro */
            border: 2px solid #4A001F; /* Guinda */
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            font-size: 16px;
            color: #4A001F; /* Guinda */
        }
        .details {
            background-color: #FFF;
            border: 1px solid #6A0F49; /* Morado */
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: left;
        }
        .details h2 {
            font-size: 20px;
            color: #6A0F49; /* Morado */
            margin-bottom: 15px;
            border-bottom: 1px solid #6A0F49; /* Morado */
            padding-bottom: 5px;
        }
        .details p, .details ul li {
            font-size: 16px;
            color: #333333;
            margin: 8px 0;
        }
        .footer {
            background-color: #4A001F; /* Guinda */
            color: #FFFFFF; /* Blanco */
            padding: 15px;
            border-radius: 0 0 8px 8px;
            font-size: 14px;
            margin-top: 20px;
        }
        .footer .no-reply {
            margin-top: 10px;
            color: #FFC3D0; /* Rosa Claro */
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <img src="{{ $message->embed(public_path('imagenes/logoFinanzas.png')) }}" alt="Logo Finanzas" style="width: 180px;">
                <img src="{{ $message->embed(public_path('imagenes/Sello Logo  Principal.png')) }}" alt="Sello Principal" style="width: 100px;">
                <img src="{{ $message->embed(public_path('imagenes/200_mejor.png')) }}" alt="Logo 200 Años" style="width: 180px;">
            </div>
            <h1>Estado de tu Queja</h1>
        </div>

        <!-- Important Info -->
        <div class="important-info">
            <p><strong>Hola, {{ $queja->nombre ?? 'Usuario' }}.</strong></p>
            <p>Estamos en proceso sobre tu inconformidad: <strong>{{ $queja->motivo }}</strong> y con número de folio: <strong>{{ $queja->id }}</strong>, le avisaremos por este medio cuando hay sido resuelta, gracias.</p>
            <p><strong>Dependencia:</strong> {{ $queja->dependencia->nombre ?? 'Sin dependencia' }}</p>
            <p><strong>Área:</strong> {{ $queja->area->nombre ?? 'Sin área' }}</p>

       </div>      

        <!-- Footer -->
        <div class="footer">
            <p>Gracias por contactarnos. Si tienes más dudas, por favor, no dudes en comunicarte.</p>
            <p class="no-reply">Favor de no responder a este mensaje, es un envío automático.</p>
        </div>
    </div>
</body>
</html>



