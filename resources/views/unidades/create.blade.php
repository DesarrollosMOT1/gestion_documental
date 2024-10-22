@extends('adminlte::page')

@section('template_title')
    {{ __('Crear') }} Unidades
@endsection

@section('content')
    <section class="content container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Crear') }} Unidades</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('unidades.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf

                            @include('unidades.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
