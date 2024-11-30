@extends('adminlte::page')

@section('template_title')
    {{ $movimiento['name'] ?? __('Mostrar') . ' ' . __('Movimiento') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ __('Mostrar') }} {{ __('Movimiento') }}</h5>
                        <a class="btn btn-primary btn-sm" href="{{ route('movimientos.index') }}">
                            {{ __('Volver') }}
                        </a>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-3">
                            <strong>Tipo:</strong> {{ $movimiento['tipo_nombre'] }}
                        </div>
                        <div class="form-group mb-3">
                            <strong>Clase:</strong> {{ $movimiento['clase_nombre'] }}
                        </div>
                        <div class="form-group mb-3">
                            <strong>Almacén:</strong> {{ $movimiento['almacen_nombre'] }}
                        </div>
                        <div class="form-group mb-3">
                            <strong>Fecha:</strong> {{ $movimiento['fecha'] }}
                        </div>
                        <div class="form-group mb-3">
                            <strong>Descripción:</strong> {{ $movimiento['descripcion'] }}
                        </div>
                        <div class="form-group mb-3">
                            <strong>Fecha de creación:</strong> {{ $movimiento['created_at'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-4">
        <h2>Registros Asociados</h2>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Producto</th>
                    <th>Unidad</th>
                    <th>Cantidad</th>
                    <th>Tercero</th>
                    <th>Motivo</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registros as $registro)
                    <tr>
                        <td>{{ $registro['producto_nombre'] }}</td>
                        <td>{{ $registro['unidad_nombre'] }}</td>
                        <td>{{ $registro['cantidad'] }}</td>
                        <td>{{ $registro['tercero_nombre'] }}</td>
                        <td>{{ $registro['motivo_nombre'] }}</td>
                        <td>{{ $registro['detalle_registro'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay registros asociados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
