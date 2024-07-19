@extends('adminlte::page')

@section('template_title')
    {{ $producto->name ?? __('Show') . " " . __('Producto') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Producto</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('productos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">

                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $producto->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Codigo Producto:</strong>
                                    {{ $producto->codigo_producto }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Unidad Medida:</strong>
                                    {{ $producto->unidad_medida }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Medida:</strong>
                                    {{ $producto->medida }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="float-right">
            <a href="{{ route('productos.unidades-equivalentes.create', ['producto' => $producto->codigo_producto]) }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                {{ __('Create New') }}
            </a>
        </div>
    </section>
@endsection
