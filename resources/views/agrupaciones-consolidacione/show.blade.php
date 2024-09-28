@extends('adminlte::page')

@section('title', 'Ver Agrupaciones Consolidaciones')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="m-0">Detalles de la Agrupación de Consolidaciones</h3>
            <a class="btn btn-primary btn-sm" href="{{ route('agrupaciones-consolidaciones.index') }}">Atrás</a>
        </div>
        @if ($message = Session::get('success'))
            <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
        @endif
        <div class="card-body">
            <div class="row">
                <!-- Información de la Agrupación -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-info-circle mr-2"></i>Información de la Agrupación</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Usuario:</strong> {{ $agrupacionesConsolidacione->user->name }}</p>
                            <p><strong>Fecha Consolidacion:</strong> {{ $agrupacionesConsolidacione->fecha_consolidacion }}</p>
                        </div>
                    </div>
                </div>

                

                <!-- Solicitudes Consolidadas -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-list-alt mr-2"></i>Solicitudes Consolidadas</h5>
                        </div>
                        <div class="card-body">
                            @if($agrupacionesConsolidacione->consolidaciones->isNotEmpty())
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
                                            @foreach($agrupacionesConsolidacione->consolidaciones->unique('solicitudesCompra.id') as $consolidacion)
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
                                <p class="text-muted">No hay solicitudes consolidadas en esta agrupación.</p>
                            @endif
                        </div>
                    </div>
                </div>


<!-- Cotizaciones Vigentes -->
<div class="col-12 mb-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title m-0">
                <i class="fas fa-list mr-2"></i>Consolidaciones y Cotizaciones
            </h5>
        </div>
        <div class="card-body">
            @if($elementosConsolidados->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <input type="checkbox" id="selected_all" />
                                </th>
                                <th></th>
                                <th>Elemento</th>
                                <th>Cant</th>
                                @foreach($cotizacionesPorTercero->keys() as $tercero)
                                    @php
                                        $cotizaciones = $cotizacionesPorTercero->get($tercero);
                                        $cotizacion = $cotizaciones->first();
                                        $diferenciaDias = $cotizacion->diferencia_dias ?? null;
                                        $estadoVigencia = $cotizacion->estado_vigencia ?? '';
                                    @endphp
                                    <th>
                                        {{ $tercero }}
                                        @if($diferenciaDias !== null)
                                            <br>
                                            <small class="text-muted">
                                                @if($estadoVigencia === 'expirado')
                                                    (Expirada)
                                                @else
                                                    ({{ abs(floor($diferenciaDias)) }} días restantes)
                                                @endif
                                            </small>
                                        @endif
                                        <span class="badge {{ $estadoVigencia === 'cercano' ? 'bg-danger' : ($estadoVigencia === 'medio' ? 'bg-warning' : 'bg-success') }}">
                                            {{ $estadoVigencia === 'cercano' ? 'Cerca de vencer' : ($estadoVigencia === 'medio' ? 'Pronto a vencer' : ($estadoVigencia === 'expirado' ? 'Expirada' : 'Válida')) }}
                                        </span>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($elementosConsolidados as $elementoNombre => $consolidaciones)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="selected_item" value="{{ $consolidaciones->first()->id }}" />
                                    </td>
                                    <td class="text-center">
                                        @if($consolidaciones->first()->elementosConsolidados->count() > 0)
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalElementosConsolidados{{ $consolidaciones->first()->id }}">
                                                <i class="fa fa-exclamation-circle"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold">{{ $elementoNombre }}</td>
                                    <td>{{ $consolidaciones->first()->cantidad }}</td>
        
                                    @if($cotizacionesPorTercero->isNotEmpty())
                                        @foreach($cotizacionesPorTercero as $tercero => $cotizaciones)
                                        @php
                                            $cotizacionElemento = $cotizaciones->firstWhere('solicitudesElemento.nivelesTres.id', $consolidaciones->first()->solicitudesElemento->nivelesTres->id);
                                            $cotizacionPrecio = $cotizacionElemento ? $cotizacionElemento->cotizacionesPrecios->firstWhere('id_agrupaciones_consolidaciones', $agrupacion->id) : null;
                                            $estadoSwitch = $cotizacionPrecio ? $cotizacionPrecio->estado : 0;
                                            $estadoJefe = $cotizacionPrecio ? $cotizacionPrecio->estado_jefe : 0;
                                        @endphp
                                        <td>
                                            @if($cotizacionElemento)
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check ms-2">
                                                            <input type="checkbox" class="form-check-input estado-jefe-checkbox" data-id="{{ $cotizacionElemento->id }}" data-id-agrupacion="{{ $agrupacion->id }}" data-id-solicitud-elemento="{{ $cotizacionElemento->id_solicitud_elemento }}"
                                                                data-id-consolidaciones="{{ $consolidaciones->first()->id }}" id="estadoJefe{{ $cotizacionElemento->id }}"{{ $estadoJefe == 1 ? 'checked' : '' }} />
                                                        </div>
                                                        <i class="fas fa-money-bill-wave ms-1"></i>
                                                        <span class="badge bg-info text-white fs-6 ms-2">
                                                            ${{ number_format($cotizacionElemento->precio) }}
                                                        </span>
                                                        @if(!empty($cotizacionPrecio->descripcion))
                                                            <i class="fas fa-comment-dots ms-2 text-primary" title="{{ $cotizacionPrecio->descripcion }}" data-bs-toggle="tooltip"></i>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex align-items-center ms-2">
                                                        <!-- Botón para Detalle de Cotización -->
                                                        <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#detalleCotizacionModal{{ $cotizacionElemento->id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input estado-checkbox" data-id="{{ $cotizacionElemento->id }}" data-id-agrupacion="{{ $agrupacion->id }}" data-id-solicitud-elemento="{{ $cotizacionElemento->id_solicitud_elemento }}"
                                                                data-id-consolidaciones="{{ $consolidaciones->first()->id }}" id="estado{{ $cotizacionElemento->id }}"{{ $estadoSwitch == 1 ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="estado{{ $cotizacionElemento->id }}">
                                                                <i class="estado-icon fas {{ $estadoSwitch == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" id="icono-estado{{ $cotizacionElemento->id }}"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            <!-- Modal de Detalle de Cotización -->
                                            <x-modal id="detalleCotizacionModal{{ $cotizacionElemento->id }}" title="Detalle de Cotización" size="lg">
                                                <div class="modal-body">
                                                    @include('agrupaciones-consolidacione.detalle_cotizacion', ['cotizacionElemento' => $cotizacionElemento, 'elementoNombre' => $elementoNombre, 'agrupacion' => $agrupacion])
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </x-modal>
                                            @else
                                                <p class="text-muted">No hay cotizaciones vigentes</p>
                                            @endif
                                        </td>
                                    @endforeach
                                    @else
                                        <td colspan="{{ count($cotizacionesPorTercero) + 3 }}">
                                            <p class="text-muted">No hay cotizaciones vigentes para mostrar.</p>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle mr-2"></i>No hay consolidaciones o cotizaciones vigentes para mostrar.
                </div>
            @endif
        </div>
    </div>
</div>

    <!-- Modal de Justificación -->
    <x-modal id="justificacionModal" title="Justificación de selección" size="md">
        <div class="modal-body">
            <p>Esta cotización tiene un precio mayor que las demás. Por favor, justifique la selección:</p>
            <textarea id="justificacionTexto" class="form-control" rows="3" maxlength="255" required></textarea>
            <small id="charCount" class="form-text text-muted">0/255 caracteres</small>
            <div id="justificacionError" class="invalid-feedback">Por favor, proporcione una justificación.</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="guardarJustificacion">Guardar</button>
        </div>
    </x-modal>

    <!-- Modal para solicitudes-oferta -->
    <x-modal id="solicitudesOfertaModal" title="{{ __('Generar Solicitud Oferta') }}" size="lg">
        <div class="modal-body">
            <form id="solicitudesOfertaForm" method="POST" action="{{ route('solicitudes-ofertas.store') }}">
                @csrf
                <div class="row padding-1 p-1">
                    <div class="col-md-12">
                        @include('solicitudes-oferta.form', ['solicitudes-ofertas' => new \App\Models\SolicitudesOferta])
                    </div>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Modal para el formulario de creación -->
    <x-modal id="createSolicitudesCompraModal" title="{{ __('Crear Solicitud de Compra') }}" size="xl">
        <form action="{{ route('agrupaciones-consolidacione.storeSolicitudesCompra', $agrupacion->id) }}" method="POST">
            @csrf
            <div class="row padding-1 p-1">
                <div class="col-md-12">
                    @include('solicitudes-compra.form', ['solicitudesCompra' => $solicitudesCompra])
                </div>
            </div>
        </form>
    </x-modal>

    <!-- Modal para el formulario de creación -->
    <x-modal id="createOrdenesCompraModal" title="{{ __('Crear Orden de Compra') }}" size="xl">
        <form action="{{ route('ordenes-compras.store') }}" method="POST">
            @csrf
            <div class="row padding-1 p-1">
                <div class="col-md-12">
                    @include('ordenes-compra.form', ['ordenesCompra' => $ordenesCompra])
                </div>
            </div>
        </form>
    </x-modal>

    @foreach($agrupacionesConsolidacione->consolidaciones as $consolidacion)
            @if($consolidacion->elementosConsolidados->count() > 0)
                <!-- Modal para Elementos Consolidados -->
                <x-modal id="modalElementosConsolidados{{ $consolidacion->id }}" title="Elementos Consolidados - Consolidación {{ $consolidacion->id }}" size="lg">
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID Solicitud</th>
                                    <th>Elemento</th>
                                    <th>Cantidad Unidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($consolidacion->elementosConsolidados as $elementoConsolidado)
                                    <tr>
                                        <td>{{ $elementoConsolidado->solicitudesCompra->id }}</td>
                                        <td>{{ $elementoConsolidado->solicitudesElemento->nivelesTres->nombre }}</td>
                                        <td>{{ $elementoConsolidado->solicitudesElemento->cantidad }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-modal>
            @endif
@endforeach
</div>
    <!-- Botón para Crear Solicitud de Compra -->
    <button type="button" data-bs-toggle="modal" data-bs-target="#createSolicitudesCompraModal" 
            class="btn btn-sm btn-secondary position-fixed top-0 end-0 me-4 d-flex align-items-center justify-content-center" style="margin-top: 5rem !important;">
        {{ __('Crear solicitud de compra') }}
    </button>
    <button type="button" id="btnGenerarSolicitudOferta" 
        class="btn btn-sm btn-primary position-fixed bottom-0 start-1 m-4 d-flex align-items-center justify-content-center"
        data-bs-toggle="modal" data-bs-target="#solicitudesOfertaModal" disabled>
        {{ __('Generar Solicitud Oferta') }}
    </button>
    <button type="button" id="btnCrearOrdenCompra" 
        class="btn btn-sm btn-success position-fixed bottom-0 end-0 m-4 d-flex align-items-center justify-content-center"
        data-bs-toggle="modal" data-bs-target="#createOrdenesCompraModal"> {{ __('Crear orden de compra') }}
    </button>
@endsection

@push('js')
    <script src="{{ asset('js/solicitudes-compra/addElemento.js') }}"></script>
    <script src="{{ asset('js/solicitudes-compra/selectDependiente.js') }}"></script> 
    <script src="{{ asset('js/solicitudes-oferta/generarSolicitudesOferta.js') }}"></script> 
    <script src="{{ asset('js/cotizaciones/actualizarEstadoCotizacion.js') }}"></script>
@endpush