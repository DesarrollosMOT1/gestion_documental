@extends('adminlte::page')

@section('title', 'Ver Solicitud de Compra')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="m-0">Detalles de la Solicitud de Compra</h3>
            <a class="btn btn-primary btn-sm" href="{{ route('solicitudes-compras.index') }}">Volver</a>
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
                            <p><strong>Fecha Solicitud:</strong> {{ $solicitudesCompra->fecha_solicitud }}</p>
                            <p><strong>Prefijo:</strong> {{ $solicitudesCompra->prefijo }}</p>
                            <p><strong>Descripción:</strong> {{ $solicitudesCompra->descripcion }}</p>
                        </div>
                    </div>
                </div>

                <!-- Información del Usuario -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-user mr-2"></i>Información del Usuario Solicitante</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>ID Usuario:</strong> {{ $solicitudesCompra->user->id }}</p>
                            <p><strong>Nombre:</strong> {{ $solicitudesCompra->user->name }}</p>
                            <p><strong>Email:</strong> {{ $solicitudesCompra->user->email }}</p>
                            <p><strong>Area:</strong> {{ $solicitudesCompra->user->area->nombre ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Elementos de la Solicitud -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fas fa-list mr-2"></i>Elementos de la Solicitud</h5>
                        </div>
                        <div class="card-body">
                            @if($solicitudesCompra->solicitudesElemento->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Elemento</th>
                                                <th>Centro de Costos</th>
                                                <th>Cantidad</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($solicitudesCompra->solicitudesElemento as $elemento)
                                                <tr>
                                                    <td>{{ $elemento->nivelesTres->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $elemento->centrosCosto->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $elemento->cantidad }}</td>
                                                    <td>
                                                        <input type="checkbox" class="estado-checkbox" 
                                                               data-id="{{ $elemento->id }}" 
                                                               {{ $elemento->estado ? 'checked' : '' }}>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No hay elementos asociados a esta solicitud de compra.</p>
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
    <script src="{{ asset('js/solicitudes-compra/actualizarEstado.js') }}"></script>
@endpush