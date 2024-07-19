@extends('adminlte::page')

@section('title', 'Ver Cotizacion')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Cotizacione</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('cotizaciones.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Cotizacion:</strong>
                                    {{ $cotizacione->fecha_cotizacion }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $cotizacione->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Valor:</strong>
                                    {{ $cotizacione->valor }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Condiciones Pago:</strong>
                                    {{ $cotizacione->condiciones_pago }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Descuento:</strong>
                                    {{ $cotizacione->descuento }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Terceros:</strong>
                                    {{ $cotizacione->id_terceros }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
