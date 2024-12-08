@extends('adminlte::page')

@section('title', 'editar Nivel Uno')

@section('content')
    <br>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Niveles Uno</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('niveles-unos.update', $nivelesUno->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('niveles-uno.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
