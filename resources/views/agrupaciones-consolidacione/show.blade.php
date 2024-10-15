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
                    <table class="table table-hover table-bordered table-striped border-dark">
                        <thead class="table-light">
                            <tr>
                                <th colspan="4" class="bg-success bg-opacity-50 text-center border-dark text-dark">Consolidaciones</th>
                                <th colspan="{{ count($cotizacionesPorTercero) }}" class="text-center border-dark">Terceros con cotizaciones vigentes</th>
                            </tr>
                            <tr>
                                <th class="bg-success bg-opacity-50 border-dark text-dark">
                                    <div class="form-check ms-2">
                                        <input class="form-check-input" type="checkbox" id="selected_all" />
                                    </div>
                                </th>
                                <th class="bg-success bg-opacity-50 border-dark text-dark">Acciones</th>
                                <th class="bg-success bg-opacity-50 border-dark text-dark">Elemento</th>
                                <th class="bg-success bg-opacity-50 border-dark text-dark">Cant</th>
                                @foreach($cotizacionesPorTercero->keys() as $tercero)
                                    @php
                                        $cotizaciones = $cotizacionesPorTercero->get($tercero);
                                        $cotizacion = $cotizaciones->first();
                                        $diferenciaDias = $cotizacion->diferencia_dias ?? null;
                                        $estadoVigencia = $cotizacion->estado_vigencia ?? '';
                                    @endphp
                                    <th class="border-dark">
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
                                @foreach($consolidaciones as $consolidacion)
                                    @if(!auth()->user()->can('ver_consolidaciones_jefe') || $consolidacion->cotizacionesPrecio->where('estado', 1)->isNotEmpty())
                                        <tr>
                                            <td class="bg-success bg-opacity-50 border-dark text-dark">
                                                <div class="form-check ms-2">
                                                    <input class="form-check-input selected_item" type="checkbox" value="{{ $consolidaciones->first()->id }}" />
                                                </div>
                                            </td>
                                            <td class="text-center bg-success bg-opacity-50 border-dark text-dark">
                                                @if($consolidaciones->first()->elementosConsolidados->count() > 0)
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalElementosConsolidados{{ $consolidaciones->first()->id }}">
                                                            <i class="fa fa-exclamation-circle"></i>
                                                        </button>
                                                @endif
                                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistorialCotizaciones{{ $consolidaciones->first()->solicitudesElemento->nivelesTres->id }}">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </div>
                                            </td>
                                            <td class="font-weight-bold bg-success bg-opacity-50 border-dark text-dark">{{ $elementoNombre }}</td>
                                            <td class="bg-success bg-opacity-50 border-dark text-dark">{{ $consolidaciones->first()->cantidad }}</td>
                
                                            @if($cotizacionesPorTercero->isNotEmpty())
                                                @foreach($cotizacionesPorTercero as $tercero => $cotizaciones)
                                                @php
                                                    $cotizacionElemento = $cotizaciones->firstWhere('solicitudesElemento.nivelesTres.id', $consolidaciones->first()->solicitudesElemento->nivelesTres->id);
                                                    $cotizacionPrecio = $cotizacionElemento ? $cotizacionElemento->cotizacionesPrecios->firstWhere('id_agrupaciones_consolidaciones', $agrupacion->id) : null;
                                                    $estadoSwitch = $cotizacionPrecio ? $cotizacionPrecio->estado : 0;
                                                    $estadoJefe = $cotizacionPrecio ? $cotizacionPrecio->estado_jefe : 0;
                                                @endphp
                                                <td class="border-dark">
                                                    @if($cotizacionElemento)
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <div class="form-check ms-2">
                                                                <input type="checkbox" 
                                                                    class="form-check-input estado-jefe-checkbox" 
                                                                    data-id="{{ $cotizacionElemento->id }}" 
                                                                    data-id-agrupacion="{{ $agrupacion->id }}" 
                                                                    data-id-solicitud-elemento="{{ $cotizacionElemento->id_solicitud_elemento }}"
                                                                    data-id-consolidaciones="{{ $consolidaciones->first()->id }}" 
                                                                    id="estadoJefe{{ $cotizacionElemento->id }}" 
                                                                    {{ $estadoJefe == 1 ? 'checked' : '' }} 
                                                                    {{ !auth()->user()->can('editar_consolidacion_estado_jefe') ? 'disabled' : '' }} 
                                                                    data-permiso="editar_consolidacion_estado_jefe"
                                                                />
                                                            </div>
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
                                                                <input type="checkbox" 
                                                                    class="form-check-input estado-checkbox" 
                                                                    data-id="{{ $cotizacionElemento->id }}" 
                                                                    data-id-agrupacion="{{ $agrupacion->id }}" 
                                                                    data-id-solicitud-elemento="{{ $cotizacionElemento->id_solicitud_elemento }}"
                                                                    data-id-consolidaciones="{{ $consolidaciones->first()->id }}" 
                                                                    id="estado{{ $cotizacionElemento->id }}" 
                                                                    {{ $estadoSwitch == 1 ? 'checked' : '' }} 
                                                                    {{ !auth()->user()->can('editar_consolidacion_estado') ? 'disabled' : '' }} 
                                                                    data-permiso="editar_consolidacion_estado"
                                                                />
                                                                <label class="form-check-label" for="estado{{ $cotizacionElemento->id }}">
                                                                    <i class="estado-icon fas {{ $estadoSwitch == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" id="icono-estado{{ $cotizacionElemento->id }}"></i>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        
                                                    <!-- Modal de Detalle de Cotización -->
                                                    <x-modal id="detalleCotizacionModal{{ $cotizacionElemento->id }}" title="Detalle de Cotización" size="lg">
                                                        @include('agrupaciones-consolidacione.detalle_cotizacion', ['cotizacionElemento' => $cotizacionElemento, 'elementoNombre' => $elementoNombre, 'agrupacion' => $agrupacion])
                                                    </x-modal>
                                                    @else
                                                        <p class="text-muted">No hay cotizaciones vigentes</p>
                                                    @endif
                                                </td>
                                            @endforeach
                                            @else
                                                <td class="border-dark" colspan="{{ count($cotizacionesPorTercero) + 3 }}">
                                                    <p class="text-muted">No hay cotizaciones vigentes para mostrar.</p>
                                                </td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
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
        <p>Esta cotización tiene un precio mayor que las demás. Por favor, justifique la selección:</p>
        <textarea id="justificacionTexto" class="form-control" rows="3" maxlength="255" required></textarea>
        <small id="charCount" class="form-text text-muted">0/255 caracteres</small>
        <div id="justificacionError" class="invalid-feedback">Por favor, proporcione una justificación.</div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="guardarJustificacion">Guardar</button>
        </div>
    </x-modal>

    <!-- Modal para solicitudes-oferta -->
    <x-modal id="solicitudesOfertaModal" title="{{ __('Generar Solicitud Oferta') }}" size="lg">
        <form id="solicitudesOfertaForm" method="POST" action="{{ route('solicitudes-ofertas.store') }}">
            @csrf
            <div class="row padding-1 p-1">
                <div class="col-md-12">
                    @include('solicitudes-oferta.form', ['solicitudes-ofertas' => new \App\Models\SolicitudesOferta])
                </div>
            </div>
        </form>
    </x-modal>

    <!-- Modal para el formulario de creación -->
    <x-modal id="createSolicitudesCompraModal" title="{{ __('Crear Solicitud de Compra') }}" size="xl">
        <form action="{{ route('agrupaciones-consolidacione.storeSolicitudesCompra', $agrupacion->id) }}" method="POST" id="solicitudesCompras">
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
        <form action="{{ route('ordenes-compras.store') }}" method="POST" id="formularioOrden">
            @csrf
            <input type="hidden" name="agrupaciones_consolidaciones_id" id="agrupaciones_consolidaciones_id" value="{{ $agrupacionesConsolidacione->id }}">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consolidacion->elementosConsolidados as $elementoConsolidado)
                                <tr>
                                    <td>{{ $elementoConsolidado->solicitudesCompra->id }}</td>
                                    <td> {{ $elementoConsolidado->solicitudesCompra->fecha_solicitud }} </td>
                                    <td>{{ $elementoConsolidado->solicitudesCompra->user->name }} </td>
                                    <td>{{ $elementoConsolidado->solicitudesCompra->descripcion }} </td>
                                    <td>{{ $elementoConsolidado->solicitudesElemento->nivelesTres->nombre }}</td>
                                    <td>{{ $elementoConsolidado->solicitudesElemento->cantidad }}</td>
                                    <td>{{ $elementoConsolidado->solicitudesElemento->centrosCosto->nombre }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-modal>
            @endif
    @endforeach

    @foreach($elementosConsolidados as $elementoNombre => $consolidaciones)
        <!-- Modal para el historial de cotizaciones de cada elemento -->
        <x-modal id="modalHistorialCotizaciones{{ $consolidaciones->first()->solicitudesElemento->nivelesTres->id }}" title="Historial de Cotizaciones para {{ $elementoNombre }}" size="lg">
            @php
                // Filtrar el historial para el nivel tres actual
                $historialElemento = $historialCotizaciones->where('solicitudesElemento.nivelesTres.id', $consolidaciones->first()->solicitudesElemento->nivelesTres->id);
            @endphp
            @if($historialElemento->isNotEmpty())
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Elemento</th>
                            <th>Tercero</th>
                            <th>Usuario</th>
                            <th>Precio</th>
                            <th>Descuento</th>
                            <th>Fecha de Vigencia</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historialElemento as $cotizacion)
                            <tr>
                                <td> {{ $elementoNombre }} </td>
                                <td>{{ $cotizacion->cotizacione->tercero->nombre ?? 'N/A' }}</td>
                                <td>{{ $cotizacion->cotizacione->user->name ?? 'N/A'}}</td>
                                <td>${{ number_format($cotizacion->precio, 2) }}</td>
                                <td>{{ $cotizacion->descuento ?? '0' }}%</td>
                                <td>{{ $cotizacion->cotizacione->fecha_inicio_vigencia }} - {{ $cotizacion->cotizacione->fecha_fin_vigencia }}</td>
                                <td>
                                    @php
                                        $fechaFinVigencia = \Carbon\Carbon::parse($cotizacion->cotizacione->fecha_fin_vigencia);
                                        $estado = now()->gt($fechaFinVigencia) ? 'Expirada' : 'Vigente';
                                    @endphp
                                    {{ $estado }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No hay historial de cotizaciones disponible para este elemento.</p>
            @endif
        </x-modal>
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
    <script src="{{ asset('js/ordenes-compra/generarOrdenesCompra.js') }}"></script>
@endpush