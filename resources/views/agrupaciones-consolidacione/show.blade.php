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

<!-- Cotizaciones Vigentes -->
<div class="col-12 mb-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title m-0"><i class="fas fa-file-invoice mr-2"></i>Cotizaciones Vigentes</h5>
        </div>
        <div class="card-body">
            @if($cotizacionesPorTercero->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Elemento</th>
                                @foreach($cotizacionesPorTercero->keys() as $tercero)
                                    <th>{{ $tercero }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($elementosConsolidados as $elementoNombre => $cotizacionesPorElemento)
                                <tr>
                                    <td>{{ $elementoNombre }}</td>
                                    @foreach($cotizacionesPorTercero as $tercero => $cotizaciones)
                                        @php
                                            $cotizacionElemento = $cotizaciones->firstWhere('solicitudesElemento.nivelesTres.id', $cotizacionesPorElemento->first()->solicitudesElemento->nivelesTres->id);
                                        @endphp
                                        <td>
                                            @if($cotizacionElemento)
                                                <p><strong>Precio:</strong> {{ $cotizacionElemento->precio }}</p>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="cotizaciones[]" value="{{ $cotizacionElemento->id }}" />
                                                    <label class="form-check-label">Seleccionar</label>
                                                </div>
                                            @else
                                                <p class="text-muted">No hay cotizaciones vigentes para este elemento</p>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No hay cotizaciones vigentes para los elementos consolidados.</p>
            @endif
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