<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #2c5282;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666666;
            border-top: 1px solid #eeeeee;
            margin-top: 30px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4299e1;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .important-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #4299e1;
            margin: 20px 0;
        }
        .user-info {
            margin-left: 15px;
        }

        .user-info p {
            margin: 5px 0;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $message->embed(public_path('logo.png')) }}" alt="Logo" class="logo">
            <h1>Orden de Compra</h1>
        </div>
        
        <div class="content">
            <p>Estimado/a <strong>{{ $tercero->nombre }}</strong>,</p>
            
            <p>Nos complace enviarle la orden de compra #{{ $ordenCompra->id }} para su procesamiento.</p>

            <p>Adjunto encontrará el documento detallado de la orden de compra en formato PDF.</p>

            <div class="important-info">
                <h3>Información de contacto:</h3>
                <div class="user-info">
                    <p><strong>Responsable:</strong> {{ $ordenCompra->user->name }}</p>
                    <p><strong>Área:</strong> {{ $ordenCompra->user->area->nombre }}</p>
                    <p><strong>Correo electrónico:</strong> {{ $ordenCompra->user->email }}</p>
                </div>
            </div>

            <p>Cordialmente,</p>
        </div>

        <div class="footer">
            <p>Este es un correo electrónico automático, por favor no responda a este mensaje.</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>