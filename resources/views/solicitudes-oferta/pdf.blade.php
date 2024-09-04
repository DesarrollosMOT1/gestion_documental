<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Oferta</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header img {
            max-width: 150px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
            color: #003366;
        }

        .info-table, .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td, .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .info-table tr:nth-child(even), .details-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .info-table th, .details-table th {
            background-color: #003366;
            color: white;
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
        }

        footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('logo.png') }}" alt="Logo Maestri On Track SAS">
        <h1>Maestri On Track SAS</h1>
        <p>Solicitud de Oferta N° {{ $solicitudesOferta->id }}</p>
    </header>

    <table class="info-table">
        <tr>
            <th>Información de la Solicitud</th>
            <th>Información del Tercero</th>
        </tr>
        <tr>
            <td>
                <strong>No:</strong> {{ $solicitudesOferta->id }}<br>
                <strong>Fecha Solicitud:</strong> {{ $solicitudesOferta->fecha_solicitud_oferta }}<br>
                <strong>Usuario:</strong> {{ $solicitudesOferta->user->name }}
            </td>
            <td>
                <strong>NIT:</strong> {{ $tercero->nit }}<br>
                <strong>Nombre:</strong> {{ $tercero->nombre ?? 'N/A' }}<br>
            </td>
        </tr>
    </table>

    <h3>Elementos</h3>
    @if($solicitudesOferta->consolidacionesOfertas->isNotEmpty())
        <table class="details-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Elemento</th>
                    <th>Cantidad Unidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($solicitudesOferta->consolidacionesOfertas as $consolidacion)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $consolidacion->solicitudesElemento->nivelesTres->nombre ?? 'N/A' }}</td>
                        <td>{{ $consolidacion->cantidad }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay consolidaciones de oferta asociadas a esta solicitud.</p>
    @endif

    <footer>
        <p>Maestri On Track SAS - {{ date('Y') }} - Todos los derechos reservados</p>
        <p>PDF generado por {{ config('app.name') }}</p>
    </footer>
</body>
</html>
