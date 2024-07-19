@extends('adminlte::page')

@section('title', 'Crear Centro Costo')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Centros Costo</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('centros-costos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('centros-costo.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
