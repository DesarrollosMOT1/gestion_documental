@extends('adminlte::page')

@section('title', 'Detalles de Solicitud de Oferta')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="m-0">Detalles de la Solicitud de Oferta</h3>
            <a class="btn btn-primary btn-sm" href="{{ route('solicitudes-ofertas.index') }}">Atrás</a>
            <a href="{{ route('solicitudes-ofertas.pdf', $solicitudesOferta->id) }}" target="_blank" class="btn btn-danger btn-sm">Generar PDF <i class="fa fa-file-pdf"></i></a>
        </div>
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

                <!-- Información del Tercero -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-user mr-2"></i>Información del Tercero</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>NIT:</strong> {{ $solicitudesOferta->tercero->nit }}</p>
                            <p><strong>Tipo de factura:</strong> {{ $solicitudesOferta->tercero->tipo_factura ?? 'N/A' }}</p>
                            <p><strong>Nombre:</strong> {{ $solicitudesOferta->tercero->nombre ?? 'N/A' }}</p>
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
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($solicitudesOferta->consolidacionesOfertas as $consolidacion)
                                                <tr>
                                                    <td>{{ $consolidacion->id }}</td>
                                                    <td>{{ $consolidacion->solicitudesCompra->descripcion ?? 'N/A' }}</td>
                                                    <td>{{ $consolidacion->solicitudesElemento->nivelesTres->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $consolidacion->cantidad }}</td>
                                                    <td>
                                                        <input type="checkbox" class="estado-checkbox"
                                                            data-id="{{ $consolidacion->id }}"
                                                            {{ $consolidacion->estado == 1 ? 'checked' : '' }}>
                                                    </td>
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
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('js/solicitudes-oferta/actualizarEstado.js') }}"></script>
@endpush