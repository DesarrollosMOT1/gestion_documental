@extends('adminlte::page')

@section('title', 'Ver Orden')

@section('content')
    <br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Ordenes Compra</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('ordenes-compras.index') }}">
                                {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Emision:</strong>
                                    {{ $ordenesCompra->fecha_emision }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Terceros:</strong>
                                    {{ $ordenesCompra->id_terceros }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
