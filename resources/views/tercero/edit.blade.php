@extends('adminlte::page')

@section('title', 'Editar Tercero')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Tercero</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('terceros.update', $tercero->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('tercero.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection