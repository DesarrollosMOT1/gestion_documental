@extends('adminlte::page')

@section('template_title')
    {{ $unidadesEquivalente->name ?? __('Show') . " " . __('Unidades Equivalente') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Unidades Equivalente</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('unidades-equivalentes.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">

                                <div class="form-group mb-2 mb20">
                                    <strong>Unidad Principal:</strong>
                                    {{ $unidadesEquivalente->unidad_principal }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Unidad Equivalente:</strong>
                                    {{ $unidadesEquivalente->unidad_equivalente }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Cantidad:</strong>
                                    {{ $unidadesEquivalente->cantidad }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
