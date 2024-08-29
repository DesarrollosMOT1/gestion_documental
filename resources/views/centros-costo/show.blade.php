@extends('adminlte::page')

@section('title', 'Ver Centro Costo')

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Centros de Costos</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('centros-costos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Codigo Mekano:</strong>
                                    {{ $centrosCosto->codigo_mekano }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $centrosCosto->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Clasificacion Centro:</strong>
                                    {{ $centrosCosto->clasificacionesCentro->nombre }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
