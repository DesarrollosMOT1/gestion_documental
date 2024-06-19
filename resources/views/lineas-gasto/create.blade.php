@extends('adminlte::page')

@section('title', 'Crear Linea')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Lineas Gasto</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('lineas-gastos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('lineas-gasto.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
