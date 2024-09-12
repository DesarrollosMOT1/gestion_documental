@extends('adminlte::page')

@section('title', 'Ver Entrada')

@section('content')
    <br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Entrada</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('entradas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">

                        <div class="form-group mb-2 mb20">
                            <strong>Fecha Recepcion Factura:</strong>
                            {{ $entrada->fecha_recepcion_factura }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Adjunto:</strong>
                            {{ $entrada->adjunto }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Numero:</strong>
                            {{ $entrada->numero }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Id Users:</strong>
                            {{ $entrada->id_users }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Fecha:</strong>
                            {{ $entrada->fecha }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Estado:</strong>
                            {{ $entrada->estado }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
