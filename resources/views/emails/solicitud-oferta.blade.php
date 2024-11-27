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
            <h1>Solicitud de Oferta</h1>
        </div>
        
        <div class="content">
            <p>Estimado/a <strong>{{ $tercero->nombre }}</strong>,</p>
            
            <p>Esperamos que este mensaje le encuentre bien. Nos ponemos en contacto con usted para hacerle llegar una solicitud de oferta para su consideración.</p>

            <p>Adjunto a este correo encontrará el documento detallado de la solicitud de oferta en formato PDF. Le agradecemos revisar cuidadosamente todos los requisitos y especificaciones incluidos.</p>

            <p>Si tiene alguna pregunta o necesita aclaraciones adicionales, no dude en contactarnos.</p>

            <p>Agradecemos de antemano su tiempo y consideración.</p>

            <div class="important-info">
                <h3>Información de contacto:</h3>
                <div class="user-info">
                    <p><strong>Responsable:</strong> {{ $solicitudOferta->user->name }}</p>
                    <p><strong>Área:</strong> {{ $solicitudOferta->user->area->nombre }}</p>
                    <p><strong>Correo electrónico:</strong> {{ $solicitudOferta->user->email }}</p>
                </div>
            </div>

            <p>Cordialmente,</p>
            <p><strong>{{ config('app.name') }}</strong></p>
        </div>

        <div class="footer">
            <p>Este es un correo electrónico automático, por favor no responda a este mensaje.</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>