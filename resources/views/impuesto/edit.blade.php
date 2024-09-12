@extends('adminlte::page')

@section('title', 'editar Impuesto')

@section('content')
    <br>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Impuesto</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('impuestos.update', $impuesto->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('impuesto.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
