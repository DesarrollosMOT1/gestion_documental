@extends('adminlte::page')

@section('template_title')
    {{ $estiba->name ?? __('Show') . " " . __('Estiba') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Estiba</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('estibas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">

                                <div class="form-group mb-2 mb20">
                                    <strong>Unidad Medida:</strong>
                                    {{ $estiba->unidad_medida }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Medida:</strong>
                                    {{ $estiba->medida }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
