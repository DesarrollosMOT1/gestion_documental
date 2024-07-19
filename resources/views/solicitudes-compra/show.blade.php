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
                            <a class="btn btn-primary btn-sm" href="{{ route('solicitudes-compras.index') }}"> {{ __('Back') }}</a>
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

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
