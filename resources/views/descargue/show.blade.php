@extends('adminlte::page')

@section('template_title')
    {{ $descargue->name ?? __('Show') . " " . __('Descargue') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Descargue</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('descargues.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">

                                <div class="form-group mb-2 mb20">
                                    <strong>Cliente Id:</strong>
                                    {{ $descargue->cliente_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Descargue:</strong>
                                    {{ $descargue->fecha_descargue }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
