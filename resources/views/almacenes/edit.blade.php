@extends('adminlte::page')

@section('template_title')
    {{ __('Update') }} Almacenes
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Almacenes</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('Almacenes.update', $Almacenes->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('Almacenes.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
