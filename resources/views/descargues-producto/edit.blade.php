@extends('adminlte::page')

@section('template_title')
    {{ __('Update') }} Descargues Producto
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Descargues Producto</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('descargues-productos.update', $descarguesProducto->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('descargues-producto.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
