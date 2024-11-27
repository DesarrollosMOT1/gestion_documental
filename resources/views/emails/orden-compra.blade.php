<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        {{ file_get_contents(public_path('css/email-styles.css')) }}
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