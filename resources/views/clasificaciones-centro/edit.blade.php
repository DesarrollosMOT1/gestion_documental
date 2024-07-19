@extends('adminlte::page')

@section('title', 'Editar Clasificacion Centro')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Clasificaciones Centro</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('clasificaciones-centros.update', $clasificacionesCentro->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('clasificaciones-centro.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
