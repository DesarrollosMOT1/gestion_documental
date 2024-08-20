@extends('adminlte::page')

@section('title', 'Ver Tercero')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Tercero</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('terceros.index') }}"> {{ __('Atrás') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Nit:</strong>
                                    {{ $tercero->nit }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Tipo Factura:</strong>
                                    {{ $tercero->tipo_factura }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $tercero->nombre }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
