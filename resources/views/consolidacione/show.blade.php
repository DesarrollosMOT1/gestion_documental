@extends('adminlte::page')

@section('title', 'Ver Consolidacion')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Consolidacione</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('consolidaciones.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Solicitudes Compras:</strong>
                                    {{ $consolidacione->id_solicitudes_compras }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Solicitud Elemento:</strong>
                                    {{ $consolidacione->id_solicitud_elemento }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estado:</strong>
                                    {{ $consolidacione->estado }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Cantidad:</strong>
                                    {{ $consolidacione->cantidad }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection