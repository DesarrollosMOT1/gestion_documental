@extends('adminlte::page')

@section('title', 'Crear Agrupaciones Consolidaciones')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Agrupaciones Consolidaciones</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('agrupaciones-consolidaciones.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('agrupaciones-consolidacione.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
