@extends('adminlte::page')

@section('template_title')
    {{ $clasesMovimiento->name ?? __('Mostrar') . ' ' . __('Clases Movimiento') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Clases Movimiento</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('clases-movimientos.index') }}">
                                {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">

                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $clasesMovimiento->nombre }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Descripcion:</strong>
                            {{ $clasesMovimiento->descripcion }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Tipo:</strong>
                            {{ $clasesMovimiento->tipo }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
