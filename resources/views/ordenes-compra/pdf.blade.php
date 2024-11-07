<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Compra</title>
    <link href="{{ public_path('css/pdf-styles.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <img src="{{ public_path('logo.png') }}" alt="Logo Maestri On Track SAS">
        <h1>Maestri On Track SAS</h1>
        <p>Orden de Compra N° {{ $ordenesCompra->id }}</p>
    </header>

    <!-- Información de la Orden de Compra -->
    <table class="info-table">
        <tr>
            <th>Información de la Orden de Compra</th>
            <th>Información del Tercero</th>
        </tr>
        <tr>
            <td>
                <strong>Fecha Emisión:</strong> {{ $ordenesCompra->fecha_emision }}<br>
                <strong>Usuario:</strong> {{ $ordenesCompra->user->name ?? 'N/A' }}
            </td>
            <td>
                <strong>NIT:</strong> {{ $ordenesCompra->tercero->nit ?? 'N/A' }}<br>
                <strong>Nombre:</strong> {{ $ordenesCompra->tercero->nombre ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <!-- Elementos de la Orden de Compra -->
    <h3>Elementos</h3>
    @if($ordenesCompra->ordenesCompraCotizaciones->isNotEmpty())
        <table class="details-table">
            <thead>
                <tr>
                    <th>Elemento</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>IVA</th>
                    <th>Descuento</th>
                    <th>Descripcion</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ordenesCompra->ordenesCompraCotizaciones as $ordenCompraCotizacion)
                    <tr>
                        <td>{{ $ordenCompraCotizacion->solicitudesElemento->nivelesTres->nombre ?? 'N/A' }}</td>
                        <td>{{ $ordenCompraCotizacion->consolidacione->cantidad ?? 'N/A' }}</td>
                        <td>{{ number_format($ordenCompraCotizacion->solicitudesCotizacione->precio ?? 0, 2) }}</td>
                        <td>{{ $ordenCompraCotizacion->solicitudesCotizacione->impuesto->tipo ?? 'N/A' }} ({{ $ordenCompraCotizacion->solicitudesCotizacione->impuesto->porcentaje ?? 'N/A' }}%)</td>
                        <td>{{ $ordenCompraCotizacion->solicitudesCotizacione->descuento ?? 'N/A' }}</td>
                        <td>{{ $ordenCompraCotizacion->solicitudesCotizacione->consolidacionOferta->descripcion ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay elementos asociados a esta orden de compra.</p>
    @endif

    <footer>
        <p>Maestri On Track SAS - {{ date('Y') }} - Todos los derechos reservados</p>
        <p>PDF generado por {{ config('app.name') }}</p>
    </footer>
</body>
</html>
