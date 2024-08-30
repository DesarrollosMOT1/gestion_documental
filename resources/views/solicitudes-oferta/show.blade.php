@extends('adminlte::page')

@section('template_title')
    {{ $solicitudesOferta->name ?? __('Show') . " " . __('Solicitudes Oferta') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Solicitudes Oferta</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('solicitudes-ofertas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Solicitud Oferta:</strong>
                                    {{ $solicitudesOferta->fecha_solicitud_oferta }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Users:</strong>
                                    {{ $solicitudesOferta->id_users }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Terceros:</strong>
                                    {{ $solicitudesOferta->id_terceros }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
