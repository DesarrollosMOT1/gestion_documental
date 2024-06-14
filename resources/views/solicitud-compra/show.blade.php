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
                            <span class="card-title">{{ __('Show') }} Solicitud Compra</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('solicitud-compras.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Solicitud:</strong>
                                    {{ $solicitudCompra->fecha_solicitud }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $solicitudCompra->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Area:</strong>
                                    {{ $solicitudCompra->area }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Tipo Factura:</strong>
                                    {{ $solicitudCompra->tipo_factura }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Prefijo:</strong>
                                    {{ $solicitudCompra->prefijo }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Cantidad:</strong>
                                    {{ $solicitudCompra->cantidad }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Nota:</strong>
                                    {{ $solicitudCompra->nota }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Centro Costo:</strong>
                                    {{ $solicitudCompra->id_centro_costo }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Referencia Gastos:</strong>
                                    {{ $solicitudCompra->id_referencia_gastos }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
