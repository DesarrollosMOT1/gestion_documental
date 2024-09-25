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
            @if($elementosConsolidados->isNotEmpty() && $cotizacionesPorTercero->isNotEmpty())
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
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalElementosConsolidados{{ $consolidaciones->first()->id }}">
                                                <i class="fa fa-exclamation-circle"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold">{{ $elementoNombre }}</td>
                                    <td>{{ $consolidaciones->first()->cantidad }}</td>
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
                                                
                                            <!-- Modal -->
                                            <div class="modal fade" id="detalleCotizacionModal{{ $cotizacionElemento->id }}" tabindex="-1" aria-labelledby="detalleCotizacionLabel{{ $cotizacionElemento->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detalleCotizacionLabel{{ $cotizacionElemento->id }}">Detalle de Cotización</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6 class="border-bottom pb-2 mb-3">Detalle de Solicitud de Cotización</h6>
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item"><strong>ID:</strong> {{ $cotizacionElemento->id }}</li>
                                                                        <li class="list-group-item"><strong>Nombre:</strong> {{ $elementoNombre }}</li>
                                                                        <li class="list-group-item"><strong>Cantidad:</strong> {{ $cotizacionElemento->cantidad }}</li>
                                                                        <li class="list-group-item"><strong>Precio:</strong> <span class="badge bg-info text-white">${{ number_format($cotizacionElemento->precio, 2) }}</span></li>
                                                                        <li class="list-group-item"><strong>Descuento:</strong> {{ $cotizacionElemento->descuento }}%</li>
                                                                        <li class="list-group-item"><strong>Impuesto:</strong> {{ $cotizacionElemento->impuesto->nombre ?? 'N/A' }}</li>
                                                                        <li class="list-group-item"><strong>Estado:</strong> <span class="badge {{ $cotizacionElemento->cotizacionesPrecios->firstWhere('id_agrupaciones_consolidaciones', $agrupacion->id) ? $cotizacionElemento->cotizacionesPrecios->firstWhere('id_agrupaciones_consolidaciones', $agrupacion->id)->estado == 1 ? 'bg-success' : 'bg-warning text-dark' : 'bg-secondary' }}">{{ $cotizacionElemento->cotizacionesPrecios->firstWhere('id_agrupaciones_consolidaciones', $agrupacion->id) ? $cotizacionElemento->cotizacionesPrecios->firstWhere('id_agrupaciones_consolidaciones', $agrupacion->id)->estado == 1 ? 'Aprobada' : 'Pendiente' : 'Sin Estado' }}</span></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6 class="border-bottom pb-2 mb-3">Detalle de Cotización</h6>
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item"><strong>Nombre:</strong> {{ $cotizacionElemento->cotizacione->nombre ?? 'N/A' }}</li>
                                                                        <li class="list-group-item"><strong>Valor:</strong> <span class="badge bg-info text-white">${{ number_format($cotizacionElemento->cotizacione->valor, 2) }}</span></li>
                                                                        <li class="list-group-item"><strong>Condiciones de Pago:</strong> {{ $cotizacionElemento->cotizacione->condiciones_pago }}</li>
                                                                        <li class="list-group-item"><strong>Tercero:</strong> {{ $cotizacionElemento->cotizacione->tercero->nombre ?? 'N/A' }}</li>
                                                                        <li class="list-group-item"><strong>Fecha de Cotización:</strong> {{ \Carbon\Carbon::parse($cotizacionElemento->cotizacione->fecha_cotizacion)->format('d/m/Y') }}</li>
                                                                        <li class="list-group-item"><strong>Fecha de inicio vigencia:</strong> {{ \Carbon\Carbon::parse($cotizacionElemento->cotizacione->fecha_inicio_vigencia)->format('d/m/Y') }}</li>
                                                                        <li class="list-group-item"><strong>Fecha de fin vigencia:</strong> {{ \Carbon\Carbon::parse($cotizacionElemento->cotizacione->fecha_fin_vigencia)->format('d/m/Y') }}</li>
                                                                        <li class="list-group-item"><strong>Estado de Vigencia:</strong> <span class="badge {{ $cotizacionElemento->estado_vigencia === 'cercano' ? 'bg-danger' : ($cotizacionElemento->estado_vigencia === 'medio' ? 'bg-warning' : 'bg-success') }}">
                                                                            {{ $cotizacionElemento->estado_vigencia === 'cercano' ? 'Cerca de vencer' : ($cotizacionElemento->estado_vigencia === 'medio' ? 'Pronto a vencer' : 'Válida') }}
                                                                        </span></li>
                                                                        <li class="list-group-item"><strong>Días Restantes:</strong> 
                                                                            <span class="text-muted">
                                                                                @if($cotizacionElemento->estado_vigencia === 'expirado')
                                                                                    Expirada
                                                                                @else
                                                                                    {{ abs(floor(\Carbon\Carbon::parse($cotizacionElemento->cotizacione->fecha_fin_vigencia)->diffInDays(now()))) }} días restantes
                                                                                @endif
                                                                            </span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                                <p class="text-muted">No hay cotizaciones vigentes</p>
                                            @endif
                                        </td>
                                    @endforeach
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

<div class="modal fade" id="justificacionModal" tabindex="-1" aria-labelledby="justificacionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="justificacionModalLabel">Justificación de selección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Esta cotización tiene un precio mayor que las demás. Por favor, justifique la selección:</p>
                <textarea id="justificacionTexto" class="form-control" rows="3" maxlength="255" required></textarea>
                <small id="charCount" class="form-text text-muted">0/255 caracteres</small>
                <div id="justificacionError" class="invalid-feedback">Por favor, proporcione una justificación.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardarJustificacion">Guardar</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal para solicitudes-oferta -->
<div class="modal fade" id="solicitudesOfertaModal" tabindex="-1" aria-labelledby="solicitudesOfertaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="solicitudesOfertaModalLabel">{{ __('Generar Solicitud Oferta') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" inert aria-label="Close"></button>
            </div>
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
            </div>
        </div>
    </div>
</div>

<!-- Modal para el formulario de creación -->
<div class="modal fade" id="createSolicitudesCompraModal" tabindex="-1" role="dialog" aria-labelledby="createSolicitudesCompraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSolicitudesCompraModalLabel">Crear Solicitud de Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('agrupaciones-consolidacione.storeSolicitudesCompra', $agrupacion->id) }}" method="POST">
                    @csrf
                    <div class="row padding-1 p-1">
                        <div class="col-md-12">
                            @include('solicitudes-compra.form', ['solicitudesCompra' => $solicitudesCompra])
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Elementos Consolidados -->
@foreach($agrupacionesConsolidacione->consolidaciones as $consolidacion)
    @if($consolidacion->elementosConsolidados->count() > 0)
        <div class="modal fade" id="modalElementosConsolidados{{ $consolidacion->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $consolidacion->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $consolidacion->id }}">Elementos Consolidados - Consolidación {{ $consolidacion->id }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
    <button type="button" data-toggle="modal" data-target="#createSolicitudesCompraModal" 
        class="btn btn-sm btn-secondary position-fixed top-0 end-0 me-4 d-flex align-items-center justify-content-center" style="margin-top: 5rem !important;">
        {{ __('Crear solicitud de compra') }}
    </button>
    <button type="button" id="btnGenerarSolicitudOferta" 
        class="btn btn-sm btn-primary position-fixed bottom-0 start-1 m-4 d-flex align-items-center justify-content-center"
        data-bs-toggle="modal" data-bs-target="#solicitudesOfertaModal" disabled>
        {{ __('Generar Solicitud Oferta') }}
    </button>
    <button type="button" id="" 
        class="btn btn-sm btn-success position-fixed bottom-0 end-0 m-4 d-flex align-items-center justify-content-center">
        {{ __('Crear orden de compra') }}
    </button>
@endsection

@push('js')
    <script src="{{ asset('js/solicitudes-compra/addElemento.js') }}"></script>
    <script src="{{ asset('js/solicitudes-compra/selectDependiente.js') }}"></script> 
    <script src="{{ asset('js/solicitudes-oferta/generarSolicitudesOferta.js') }}"></script> 
    <script src="{{ asset('js/cotizaciones/actualizarEstadoCotizacion.js') }}"></script>
@endpush