@extends('adminlte::page')

@section('title', 'Editar Linea')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Lineas Gasto</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('lineas-gastos.update', $lineasGasto->codigo) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('lineas-gasto.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
