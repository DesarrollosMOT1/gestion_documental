@extends('adminlte::page')

@section('template_title')
    {{ __('Update') }} Solicitudes Oferta
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Solicitudes Oferta</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('solicitudes-ofertas.update', $solicitudesOferta->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('solicitudes-oferta.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
