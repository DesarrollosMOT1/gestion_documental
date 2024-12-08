@extends('adminlte::page')

@section('title', 'Ver Orden')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="m-0">Orden de Compra</h3>
            <a class="btn btn-primary btn-sm" href="{{ route('ordenes-compras.index') }}">Atrás</a>
        </div>
        @if ($message = Session::get('success'))
            <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
        @endif
        <div class="card-body">
            <div class="row">
                <!-- Información de la Orden de Compra -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-file-invoice mr-2"></i>Información de la Orden de Compra</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Orden de compra:</strong> #{{ $ordenesCompra->id }}</p>
                            <p><strong>Fecha Emisión:</strong> {{ $ordenesCompra->fecha_emision }}</p>
                            <p><strong>Usuario:</strong> {{ $ordenesCompra->user->name ?? 'N/A' }}</p>
                            
                            <div class="tercero-card mb-3">
                                <h6>Información del Tercero</h6>
                                <p><strong>NIT:</strong> {{ $ordenesCompra->tercero->nit ?? 'N/A' }}</p>
                                <p><strong>Nombre:</strong> {{ $ordenesCompra->tercero->nombre ?? 'N/A' }}</p>
                                <p><strong>Tipo de Factura:</strong> {{ $ordenesCompra->tercero->tipo_factura ?? 'N/A' }}</p>
                                <p><strong>Email:</strong> {{ $ordenesCompra->tercero->email ?? 'N/A' }}</p>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#terceroModal{{ $ordenesCompra->tercero->id }}">
                                        <i class="fas fa-envelope"></i> Gestionar Email
                                    </button>
                                    <a href="{{ route('ordenes-compra.pdf', $ordenesCompra->id) }}" 
                                        target="_blank" class="btn btn-danger btn-sm">
                                        <i class="fa fa-file-pdf"></i> Ver PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @include('components.email-modal', [
                    'modelo' => $ordenesCompra,
                    'tercero' => $ordenesCompra->tercero,
                    'tipo' => 'orden-compra'
                ])

                <!-- Elementos de la Orden de Compra -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-list mr-2"></i>Elementos de la Orden de Compra</h5>
                        </div>
                        <div class="card-body">
                            @if($ordenesCompra->ordenesCompraCotizaciones->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead class="thead">
                                            <tr>
                                                <th>Elemento</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>IVA</th>
                                                <th>Descuento</th>
                                                <th>Consolidación</th>
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
                                                    <td>{{ $ordenCompraCotizacion->consolidacione->id ?? 'N/A' }}</td>
                                                    <td>{{ $ordenCompraCotizacion->solicitudesCotizacione->consolidacionOferta->descripcion ?? 'N/A' }}</td>
                                                    <td>
                                                        @if($ordenCompraCotizacion->consolidacione && $ordenCompraCotizacion->consolidacione->elementosConsolidados->isNotEmpty())
                                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalElementosConsolidados{{ $ordenCompraCotizacion->consolidacione->id }}">
                                                                <i class="fas fa-eye"></i> Ver Consolidados
                                                            </button>
                                                        @else
                                                            <span class="text-muted">No Consolidado</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No hay elementos asociados a esta orden de compra.</p>
                            @endif
                        </div>
                    </div>
                </div>

                @foreach($ordenesCompra->ordenesCompraCotizaciones as $ordenCompraCotizacion)
                    @if($ordenCompraCotizacion->consolidacione && $ordenCompraCotizacion->consolidacione->elementosConsolidados->isNotEmpty())
                        <x-modal id="modalElementosConsolidados{{ $ordenCompraCotizacion->consolidacione->id }}" title="Elementos Consolidados - Consolidación {{ $ordenCompraCotizacion->consolidacione->id }}" size="lg">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Solicitud</th>
                                        <th>Fecha solicitud</th>
                                        <th>Solicitante</th>
                                        <th>Descripcion</th>
                                        <th>Elemento</th>
                                        <th>Cantidad Unidad</th>
                                        <th>Centro Costo</th>
                                        <th>Descripción Elemento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ordenCompraCotizacion->consolidacione->elementosConsolidados as $elementoConsolidado)
                                        <tr>
                                            <td>{{ $elementoConsolidado->solicitudesCompra->id }}</td>
                                            <td>{{ $elementoConsolidado->solicitudesCompra->fecha_solicitud }}</td>
                                            <td>{{ $elementoConsolidado->solicitudesCompra->user->name }}</td>
                                            <td>{{ $elementoConsolidado->solicitudesCompra->descripcion }}</td>
                                            <td>{{ $elementoConsolidado->solicitudesElemento->nivelesTres->nombre }}</td>
                                            <td>{{ $elementoConsolidado->solicitudesElemento->cantidad }}</td>
                                            <td>{{ $elementoConsolidado->solicitudesElemento->centrosCosto->nombre }}</td>
                                            <td>{{ $elementoConsolidado->solicitudesElemento->descripcion_elemento }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </x-modal>
                    @endif
                @endforeach

                <!-- Trazabilidad desde Consolidaciones -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-project-diagram mr-2"></i>Trazabilidad</h5>
                        </div>
                        <div class="card-body">
                            @if($ordenesCompra->ordenesCompraCotizaciones->isNotEmpty())
                                <div class="row">
                                    @foreach($ordenesCompra->ordenesCompraCotizaciones as $index => $ordenCompraCotizacion)
                                        @if($ordenCompraCotizacion->consolidacione)
                                            <div class="col-md-4 mb-4">
                                                <div class="card h-100">
                                                    <div class="card-header bg-success">
                                                        <h6 class="m-0">Agrupación Consolidación #{{ $ordenCompraCotizacion->consolidacione->agrupacioneConsolidaciones->pluck('id')->implode('-') }}
                                                            <a href="{{ route('agrupaciones-consolidaciones.show', $ordenCompraCotizacion->consolidacione->agrupacioneConsolidaciones->pluck('id')->implode('-')) }}" target="_blank" class="btn btn-sm btn-warning ms-2">Ir</a>
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <p><strong>Consolidó:</strong> {{ $ordenCompraCotizacion->consolidacione->agrupacioneConsolidaciones->pluck('user.name')->implode('-') }}</p>
                                                        <p><strong>Consolidación:</strong> #{{ $ordenCompraCotizacion->consolidacione->id }}</p>
                                                        <p><strong>Elemento:</strong> {{ $ordenCompraCotizacion->solicitudesElemento->nivelesTres->nombre ?? 'N/A' }}</p>
                                                        <p><strong>Cantidad Consolidada:</strong> {{ $ordenCompraCotizacion->consolidacione->cantidad }}</p>
                                                        <hr>
                                                        <h6 class="text-muted">Información de Solicitud de Compra</h6>
                                                        <p><strong>Solicitud de Compra:</strong> #{{ $ordenCompraCotizacion->consolidacione->solicitudesCompra->id ?? 'N/A' }}
                                                            @if($ordenCompraCotizacion->consolidacione->solicitudesCompra)
                                                                <a href="{{ route('solicitudes-compras.show', $ordenCompraCotizacion->consolidacione->solicitudesCompra->id) }}" target="_blank" class="btn btn-sm btn-warning ms-2">Ir</a>
                                                            @endif
                                                        </p>    
                                                        <p><strong>Prefijo de Solicitud:</strong> {{ $ordenCompraCotizacion->consolidacione->solicitudesCompra->prefijo ?? 'N/A' }}</p>
                                                        <p><strong>Fecha Solicitud:</strong> {{ $ordenCompraCotizacion->consolidacione->solicitudesCompra->fecha_solicitud ?? 'N/A' }}</p>
                                                        <p><strong>Usuario Solicitante:</strong> {{ $ordenCompraCotizacion->consolidacione->solicitudesCompra->user->name ?? 'N/A' }}</p>
                                                        <p><strong>Descripcion:</strong> {{ $ordenCompraCotizacion->consolidacione->solicitudesCompra->descripcion ?? 'N/A' }}</p>
                                                        <hr>
                                                        <h6 class="text-muted">Información de Cotización</h6>
                                                        <p><strong>Cotización:</strong> #{{ $ordenCompraCotizacion->solicitudesCotizacione->cotizacione->id ?? 'N/A' }}
                                                            @if($ordenCompraCotizacion->solicitudesCotizacione->cotizacione)
                                                                <a href="{{ route('cotizaciones.show', $ordenCompraCotizacion->solicitudesCotizacione->cotizacione->id) }}" target="_blank" class="btn btn-sm btn-warning ms-2">Ir</a>
                                                            @endif
                                                        </p>
                                                        <p><strong>Fecha de Cotizacion:</strong>{{ $ordenCompraCotizacion->solicitudesCotizacione->cotizacione->fecha_cotizacion ?? 'N/A' }}</p>
                                                        <p><strong>Nombre:</strong> #{{ $ordenCompraCotizacion->solicitudesCotizacione->cotizacione->nombre ?? 'N/A' }}</p>
                                                        <p><strong>Usuario:</strong> {{ $ordenCompraCotizacion->solicitudesCotizacione->cotizacione->user->name ?? 'N/A' }}</p>
                                                        <p><strong>Condiciones de Pago: </strong>{{ $ordenCompraCotizacion->solicitudesCotizacione->cotizacione->condiciones_pago ?? 'N/A' }}</p>
                                                        <p><strong>Fecha de Inicio Vigencia: </strong>{{ $ordenCompraCotizacion->solicitudesCotizacione->cotizacione->fecha_inicio_vigencia ?? 'N/A' }}</p>
                                                        <p><strong>Fecha de Fin Vigencia: </strong>{{ $ordenCompraCotizacion->solicitudesCotizacione->cotizacione->fecha_fin_vigencia ?? 'N/A' }}</p>
                                                        
                                                        <p><strong>Justificación de la Cotización:</strong> {{ $ordenCompraCotizacion->cotizacionesPrecio->descripcion ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No hay información de trazabilidad disponible.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection