@extends('adminlte::page')

@section('title', 'Crear Clasificacion Centro')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Clasificaciones Centro</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('clasificaciones-centros.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('clasificaciones-centro.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
