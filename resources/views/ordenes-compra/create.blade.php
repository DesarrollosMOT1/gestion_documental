@extends('adminlte::page')

@section('title', 'Crear Orden')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Ordenes Compra</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('ordenes-compras.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('ordenes-compra.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
