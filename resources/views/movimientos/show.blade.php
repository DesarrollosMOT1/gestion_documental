@extends('adminlte::page')

@section('template_title')
    {{ $movimiento->name ?? __('Mostrar') . ' ' . __('Movimiento') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Movimiento</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('movimientos.index') }}">
                                {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">

                        <div class="form-group mb-2 mb20">
                            <strong>Tipo:</strong>
                            {{ $movimiento->tipo_nombre }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Clase:</strong>
                            {{ $movimiento->clase_nombre }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Almacén:</strong>
                            {{ $movimiento->almacen_nombre }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Bodega:</strong>
                            {{ $movimiento->bodega_nombre }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Fecha:</strong>
                            {{ $movimiento->fecha }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Descripción:</strong>
                            {{ $movimiento->descripcion }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Fecha de creación:</strong>
                            {{ $movimiento->created_at }}
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
                @foreach ($registros as $registro)
                    <tr>
                        <td>{{ $registro->producto_nombre }}</td>
                        <td>{{ $registro->unidad_nombre }}</td>
                        <td>{{ $registro->cantidad }}</td>
                        <td>{{ $registro->tercero_nombre }}</td>
                        <td>{{ $registro->motivo_nombre }}</td>
                        <td>{{ $registro->detalle_registro }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
