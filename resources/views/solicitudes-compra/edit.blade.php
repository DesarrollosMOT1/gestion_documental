@extends('adminlte::page')

@section('title', 'editar Solicitud')

@section('content')
    <br>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Solicitudes Compra</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('solicitudes-compras.update', $solicitudesCompra->id) }}"
                            role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('solicitudes-compra.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
