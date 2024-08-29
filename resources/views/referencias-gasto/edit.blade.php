@extends('adminlte::page')

@section('title', 'Editar Referencia Gasto')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Referencias Gasto</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('referencias-gastos.update', $referenciasGasto->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('referencias-gasto.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
