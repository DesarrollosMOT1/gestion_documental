@extends('adminlte::page')

@section('title', 'Editar Cotizacion')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Cotizacione</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('cotizaciones.update', $cotizacione->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('cotizacione.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection