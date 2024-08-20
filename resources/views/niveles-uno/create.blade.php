@extends('adminlte::page')

@section('title', 'Crear Nivel Uno')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Niveles Uno</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('niveles-unos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('niveles-uno.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
