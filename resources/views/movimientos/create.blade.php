@extends('adminlte::page')

@section('template_title')
    {{ __('Create') }} Movimiento
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Movimiento</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('movimientos.store') }}"  role="form" enctype="multipart/form-data" id="movimientoForm">
                            @csrf

                            @include('movimientos.form')
                            <input type="hidden" name="registros" id="registrosInput">
                        </form>
                        <x-product-add-form/>
                        <div class="col-md-12 mt20 mt-2">
                            <button type="submit" class="btn btn-primary" form="movimientoForm">{{ __('Crear Movimiento') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
