@extends('adminlte::page')

@section('title', 'Ver Niveles Dos')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Niveles Dos</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('niveles-dos.index') }}"> {{ __('Atrás') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $nivelesDo->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Nivel Uno:</strong>
                                    {{ $nivelesDo->nivelesUno->nombre }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
