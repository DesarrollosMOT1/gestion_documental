@extends('adminlte::page')

@section('template_title')
    {{ __('Create') }} Descargues Producto
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Descargues Producto</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('descargues-productos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('descargues-producto.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
