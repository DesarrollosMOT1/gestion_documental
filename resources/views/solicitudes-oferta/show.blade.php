@extends('adminlte::page')

@section('title', 'Detalles de Solicitud de Oferta')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="m-0">Detalles de la Solicitud de Oferta</h3>
            <a class="btn btn-primary btn-sm" href="{{ route('solicitudes-ofertas.index') }}">Atrás</a>
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
                            <p><strong>Tercero:</strong> {{ $solicitudesOferta->tercero->nombre ?? 'N/A' }}</p>
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
                                                <th>Cantidad</th>
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
                                                    <td>{{ $consolidacion->estado ? 'Activo' : 'Inactivo' }}</td>
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