@extends('adminlte::page')

@section('template_title')
    {{ __('Create') }} Clases Movimiento
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Clases Movimiento</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('clases-movimientos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('clases-movimiento.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
