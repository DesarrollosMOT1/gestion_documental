@extends('adminlte::page')

@section('template_title')
    {{ $Almacenes->name ?? __('Mostrar') . ' ' . __('Almacenes') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Almacenes</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('Almacenes.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">

                        <div class="form-group mb-2 mb20">
                            <strong>Bodega:</strong>
                            {{ $Almacenes->bodega }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $Almacenes->nombre }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
