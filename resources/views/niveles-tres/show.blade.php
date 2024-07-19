@extends('adminlte::page')

@section('title', 'Ver Niveles Tres')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Niveles Tre</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('niveles-tres.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $nivelesTre->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Niveles Dos:</strong>
                                    {{ $nivelesTre->id_niveles_dos }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Referencias Gastos:</strong>
                                    {{ $nivelesTre->id_referencias_gastos }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
