@extends('adminlte::page')

@section('title', 'Detalles de Solicitud de Oferta')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="m-0">Detalles de la Solicitud de Oferta</h3>
            <a class="btn btn-primary btn-sm" href="{{ route('solicitudes-ofertas.index') }}">Atrás</a>
            <!-- Botón para Crear Cotización -->
<button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#cotizacionesModal">Crear Cotización</button>
        </div>
        @if ($message = Session::get('success'))
            <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
        @endif
        <div class="card-body">
            <div class="row">
                <!-- Información de la Solicitud de Oferta -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-info-circle mr-2"></i>Información de la Solicitud</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>ID:</strong> {{ $solicitudesOferta->id }}</p>
                            <p><strong>Fecha Solicitud:</strong> {{ $solicitudesOferta->fecha_solicitud_oferta }}</p>
                            <p><strong>Usuario:</strong> {{ $solicitudesOferta->user->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-users mr-2"></i>Información de los Terceros Asociados</h5>
                        </div>
                        <div class="card-body">
                            @if($solicitudesOferta->terceros->isNotEmpty())
                                @foreach($solicitudesOferta->terceros as $tercero)
                                    <p><strong>NIT:</strong> {{ $tercero->nit }}</p>
                                    <p><strong>Tipo de factura:</strong> {{ $tercero->tipo_factura ?? 'N/A' }}</p>
                                    <p><strong>Nombre:</strong> {{ $tercero->nombre ?? 'N/A' }}</p>
                                    <a href="{{ route('solicitudes-ofertas.pdf', ['id' => $solicitudesOferta->id, 'terceroId' => $tercero->id]) }}" target="_blank" class="btn btn-danger btn-sm">Generar PDF para este Tercero <i class="fa fa-file-pdf"></i></a>
                                    <hr> <!-- Separador entre terceros -->
                                @endforeach
                            @else
                                <p class="text-muted">No hay terceros asociados a esta solicitud de oferta.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Solicitudes de Compra -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-list-alt mr-2"></i>Solicitudes de Compra</h5>
                        </div>
                        <div class="card-body">
                            @if($solicitudesOferta->consolidacionesOfertas->unique('solicitudesCompra.id')->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID Solicitud</th>
                                                <th>Fecha Solicitud</th>
                                                <th>Solicitante</th>
                                                <th>Prefijo</th>
                                                <th>Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($solicitudesOferta->consolidacionesOfertas->unique('solicitudesCompra.id') as $consolidacion)
                                                <tr>
                                                    <td>{{ $consolidacion->solicitudesCompra->id ?? 'N/A' }}</td>
                                                    <td>{{ $consolidacion->solicitudesCompra->fecha_solicitud ?? 'N/A' }}</td>
                                                    <td>{{ $consolidacion->solicitudesCompra->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $consolidacion->solicitudesCompra->prefijo ?? 'N/A' }}</td>
                                                    <td>{{ $consolidacion->solicitudesCompra->descripcion ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No hay solicitudes de compra asociadas a esta solicitud de oferta.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Consolidaciones de Oferta -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-list mr-2"></i>Consolidaciones de Oferta</h5>
                        </div>
                        <div class="card-body">
                            @if($solicitudesOferta->consolidacionesOfertas->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Solicitud de Compra</th>
                                                <th>Elemento</th>
                                                <th>Cantidad Unidad</th>
                                                <th>Descripcion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($solicitudesOferta->consolidacionesOfertas as $consolidacion)
                                                <tr>
                                                    <td>{{ $consolidacion->id }}</td>
                                                    <td>{{ $consolidacion->solicitudesCompra->descripcion ?? 'N/A' }}</td>
                                                    <td>{{ $consolidacion->solicitudesElemento->nivelesTres->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $consolidacion->cantidad }}</td>
                                                    <td>{{ $consolidacion->descripcion ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No hay consolidaciones de oferta asociadas a esta solicitud.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal para crear cotizaciones -->
                <x-modal id="cotizacionesModal" title="Crear Cotización" size="lg">
                    <div class="modal-body">
                        <form action="{{ route('cotizaciones.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="solicitud_oferta_id" id="solicitud_oferta_id" value="{{ $solicitudesOferta->id }}">
                            <!-- Incluye el formulario para la cotización -->
                            @include('cotizacione.form')
                        </form>
                    </div>
                </x-modal>

                <!-- Sección de cotizaciones relacionadas -->
                <div class="mb-4">
                    <h5>Cotizaciones Relacionadas</h5>
                    @if($cotizacionesRelacionadas->isNotEmpty())
                        <div class="list-group">
                            @foreach($cotizacionesRelacionadas as $cotizacion)
                                <a href="{{ route('cotizaciones.show', $cotizacion->id) }}" 
                                class="list-group-item list-group-item-action" 
                                target="_blank">
                                    {{ $cotizacion->nombre }} - {{ $cotizacion->fecha_cotizacion }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No hay cotizaciones relacionadas para esta solicitud de oferta.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('js/cotizaciones/generarCotizaciones.js') }}"></script>
    <script src="{{ asset('js/cotizaciones/actualizarValorCotizacion.js') }}"></script>
@endpush