@extends('adminlte::page')

@section('template_title')
    {{ __('Create') }} Solicitudes Oferta
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Solicitudes Oferta</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('solicitudes-ofertas.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('solicitudes-oferta.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
