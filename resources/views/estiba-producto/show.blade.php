@extends('adminlte::page')

@section('template_title')
    {{ $estibaProducto->name ?? __('Show') . " " . __('Estiba Producto') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Estiba Producto</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('estiba-productos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">

                                <div class="form-group mb-2 mb20">
                                    <strong>Estiba:</strong>
                                    {{ $estibaProducto->estiba }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Descargue:</strong>
                                    {{ $estibaProducto->descargue }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Cantidad Producto:</strong>
                                    {{ $estibaProducto->cantidad_producto }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
