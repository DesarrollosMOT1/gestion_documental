@extends('adminlte::page')

@section('title', 'Ver Agrupaciones Consolidaciones')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="m-0">Detalles de la Agrupación de Consolidaciones</h3>
            <a class="btn btn-primary btn-sm" href="{{ route('agrupaciones-consolidaciones.index') }}">Atrás</a>
            <!-- Botón para abrir el modal -->
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#createSolicitudesCompraModal">
                Crear Solicitud de Compra
            </button>
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

    <!-- Consolidaciones Asociadas -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0"><i class="fas fa-list mr-2"></i>Consolidaciones Asociadas</h5>
            </div>
            <div class="card-body">
                @if($agrupacionesConsolidacione->consolidaciones->contains(function ($consolidacion) {
                    return $consolidacion->cotizacionesVigentes->isNotEmpty();
                }))
                    <div class="alert alert-info">
                        Existen cotizaciones vigentes. 
                        <button class="btn btn-success" data-toggle="modal" data-target="#modalCotizacionesVigentes">
                            Usar cotizaciones vigentes
                        </button>
                    </div>
                @endif
                @if($agrupacionesConsolidacione->consolidaciones->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="select_all" />
                                    </th>
                                    <th>ID Consolidación</th>
                                    <th>Solicitud de Compra</th>
                                    <th>Elemento Consolidado</th>
                                    <th>Cantidad Unidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($agrupacionesConsolidacione->consolidaciones as $consolidacion)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="select_item" value="{{ $consolidacion->id }}" />
                                        </td>
                                        <td>{{ $consolidacion->id }}</td>
                                        <td>{{ $consolidacion->solicitudesCompra->descripcion ?? 'N/A' }}</td>
                                        <td>{{ $consolidacion->solicitudesElemento->nivelesTres->nombre ?? 'N/A' }}</td>
                                        <td>{{ $consolidacion->cantidad }}</td>
                                        <td>
                                            @if($consolidacion->elementosConsolidados->count() > 0)
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalElementosConsolidados{{ $consolidacion->id }}">
                                                    Ver Elementos Consolidados
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No hay consolidaciones asociadas a esta agrupación.</p>
                @endif
                <div class="float-right">  
                    <button type="button" id="btnGenerarSolicitudOferta" class="btn btn-secondary btn-sm float-right ml-2" data-bs-toggle="modal" data-bs-target="#solicitudesOfertaModal" disabled>
                        {{ __('Generar Solicitud Oferta') }}
                    </button>        
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para seleccionar cotizaciones vigentes (Modal 1) -->
<div class="modal fade" id="modalCotizacionesVigentes" aria-hidden="true" aria-labelledby="modalCotizacionesLabel" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCotizacionesLabel">Seleccionar Cotizaciones Vigentes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formSeleccionCotizaciones">
                    <div class="row">
                        @foreach($agrupacionesConsolidacione->consolidaciones->groupBy(function($consolidacion) {
                            return $consolidacion->solicitudesElemento->nivelesTres->nombre ?? 'N/A';
                        }) as $elementoNombre => $consolidaciones)
                            <div class="col-12 mb-4">
                                <h4>Cotizaciones encontradas para elemento: {{ $elementoNombre }}</h4>
                                <div class="row">
                                    @foreach($consolidaciones as $consolidacion)
                                        @foreach($consolidacion->cotizacionesVigentes as $cotizacion)
                                            <div class="col-md-4 mb-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title">Cotización ID: {{ $cotizacion->id }}</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <h6 class="card-subtitle mb-2 text-muted">Consolidación ID: {{ $consolidacion->id }}</h6>
                                                        <p class="card-text"><strong>Elemento:</strong> {{ $consolidacion->solicitudesElemento->nivelesTres->nombre ?? 'N/A' }}</p>
                                                        <p class="card-text"><strong>Tercero:</strong> {{ $cotizacion->tercero->nombre ?? 'N/A' }}</p>
                                                        <p class="card-text"><strong>Valor:</strong> {{ $cotizacion->valor }}</p>
                                                        <p class="card-text"><strong>Fecha Cotizacion:</strong> {{ $cotizacion->fecha_cotizacion }}</p>
                                                        <p class="card-text"><strong>Fecha inicio vigencia:</strong> {{ $cotizacion->fecha_inicio_vigencia }}</p>
                                                        <p class="card-text"><strong>Fecha fin vigencia:</strong> {{ $cotizacion->fecha_fin_vigencia }}</p>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" name="cotizaciones[]" value="{{ $cotizacion->id }}" />
                                                            <label class="form-check-label">Seleccionar</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnCrearOrdenCompra" data-bs-target="#modalCrearOrdenCompra" data-bs-toggle="modal">
                    Crear Orden de Compra
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear orden de compra (Modal 2) -->
<div class="modal fade" id="modalCrearOrdenCompra" aria-hidden="true" aria-labelledby="modalCrearOrdenCompraLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrearOrdenCompraLabel">Crear Orden de Compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCrearOrdenCompra">
                    <!-- Aquí irán los campos del formulario para crear la orden de compra -->
                    <div class="mb-3">
                        <label for="fechaEmision" class="form-label">Fecha de Emisión</label>
                        <input type="date" class="form-control" id="fechaEmision" name="fecha_emision" required>
                    </div>
                    <div class="mb-3">
                        <label for="nota" class="form-label">Nota</label>
                        <textarea class="form-control" id="nota" name="nota" rows="3"></textarea>
                    </div>
                    <!-- Aquí se mostrarán las cotizaciones seleccionadas -->
                    <div id="cotizacionesSeleccionadas"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-target="#modalCotizacionesVigentes" data-bs-toggle="modal">Volver</button>
                <button type="button" class="btn btn-primary" id="btnGuardarOrdenCompra">Guardar Orden de Compra</button>
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

@endsection

@push('js')
    <script src="{{ asset('js/solicitudes-compra/addElemento.js') }}"></script>
    <script src="{{ asset('js/solicitudes-compra/selectDependiente.js') }}"></script> 
    <script src="{{ asset('js/solicitudes-oferta/generarSolicitudesOferta.js') }}"></script> 
@endpush