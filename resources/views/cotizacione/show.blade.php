@extends('adminlte::page')

@section('title', 'Ver Cotización')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="m-0">Detalles de la Cotización</h3>
            <a class="btn btn-primary btn-sm" href="{{ route('cotizaciones.index') }}">Atrás</a>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Información General -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-info-circle mr-2"></i>Información General</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Cotizacion:</strong> #{{ $cotizacione->id }}</p>
                            <p><strong>Fecha Cotización:</strong> {{ $cotizacione->fecha_cotizacion }}</p>
                            <p><strong>Usuario:</strong> {{ $cotizacione->user->name }}</p>
                            <p><strong>Nombre:</strong> {{ $cotizacione->nombre }}</p>
                            <p><strong>Valor:</strong> {{ $cotizacione->valor }}</p>
                            <p><strong>Condiciones de Pago:</strong> {{ $cotizacione->condiciones_pago }}</p>
                            <p><strong>Fecha inicio vigencia:</strong> {{ $cotizacione->fecha_inicio_vigencia ?? 'N/A' }}</p>
                            <p><strong>Fecha fin vigencia:</strong> {{ $cotizacione->fecha_fin_vigencia ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Información del Tercero -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-user mr-2"></i>Información del Tercero</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>NIT:</strong> {{ $cotizacione->tercero->nit }}</p>
                            <p><strong>Tipo de factura:</strong> {{ $cotizacione->tercero->tipo_factura ?? 'N/A' }}</p>
                            <p><strong>Nombre:</strong> {{ $cotizacione->tercero->nombre ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Solicitudes de Compra Relacionadas -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-shopping-cart mr-2"></i>Solicitudes de Compra Relacionadas</h5>
                        </div>
                        <div class="card-body">
                            @if($solicitudesUnicas->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fecha Solicitud</th>
                                                <th>Prefijo</th>
                                                <th>Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($solicitudesUnicas as $solicitudCotizacion)
                                                <tr>
                                                    <td>{{ $solicitudCotizacion->solicitudesCompra->fecha_solicitud ?? 'N/A' }}</td>
                                                    <td>{{ $solicitudCotizacion->solicitudesCompra->prefijo ?? 'N/A' }}</td>
                                                    <td>{{ $solicitudCotizacion->solicitudesCompra->descripcion ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No hay solicitudes de compra asociadas a esta cotización.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Elementos Cotizados -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-list mr-2"></i>Elementos Cotizados</h5>
                        </div>
                        <div class="card-body">
                            @if($cotizacione->solicitudesCotizaciones->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Elemento</th>
                                                <th>Cantidad</th>
                                                <th>Descuento</th>
                                                <th>Impuesto</th>
                                                <th>Precio</th>
                                                <th>Descripcion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cotizacione->solicitudesCotizaciones as $solicitudCotizacion)
                                                <tr>
                                                    <td>{{ $solicitudCotizacion->solicitudesElemento->nivelesTres->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $solicitudCotizacion->consolidacionOferta->consolidacione->cantidad }}</td>
                                                    <td>{{ $solicitudCotizacion->descuento }}</td>
                                                    <td>{{ $solicitudCotizacion->impuesto->tipo ?? 'N/A' }}</td>
                                                    <td>{{ $solicitudCotizacion->precio ?? 'N/A' }}</td>
                                                    <td>{{ $solicitudCotizacion->consolidacionOferta->descripcion ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No hay elementos cotizados asociados a esta cotización.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection