@extends('adminlte::page')

@section('title', 'editar Consolidacion')

@section('content')
    <br>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Consolidacione</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('consolidaciones.update', $consolidacione->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('consolidacione.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
