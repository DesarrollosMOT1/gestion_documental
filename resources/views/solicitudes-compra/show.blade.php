@extends('adminlte::page')

@section('title', 'Ver Solicitud')

@section('content')
<br>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="float-left">
                        <span class="card-title">{{ __('Show') }} Solicitudes Compra</span>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('solicitudes-compras.index') }}"> {{ __('Atrás') }}</a>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <div class="form-group mb-2 mb20">
                        <strong>Fecha Solicitud:</strong>
                        {{ $solicitudesCompra->fecha_solicitud }}
                    </div>
                    <div class="form-group mb-2 mb20">
                        <strong>Id Users:</strong>
                        {{ $solicitudesCompra->id_users }}
                    </div>
                    <div class="form-group mb-2 mb20">
                        <strong>Prefijo:</strong>
                        {{ $solicitudesCompra->prefijo }}
                    </div>
                    <div class="form-group mb-2 mb20">
                        <strong>Descripcion:</strong>
                        {{ $solicitudesCompra->descripcion }}
                    </div>
                    <div class="form-group mb-2 mb20">
                        <strong>Estado Solicitud:</strong>
                        {{ $solicitudesCompra->estado_solicitud }}
                    </div>
                    <div class="form-group mb-2 mb20">
                        <strong>Fecha Estado:</strong>
                        {{ $solicitudesCompra->fecha_estado }}
                    </div>

                    <div class="mt-4">
                        <h4>Elementos de la Solicitud</h4>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nivel Tres</th>
                                    <th>Centro de Costos</th>
                                    <th>Cantidad</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($solicitudesCompra->solicitudesElemento as $elemento)
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
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay elementos asociados a esta solicitud de compra.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
    <script src="{{ asset('js/solicitudes-compra/actualizarEstado.js') }}"></script>
@endpush
