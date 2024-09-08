@extends('adminlte::page')

@section('title', 'editar Permiso')

@section('content')
    <br>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Permiso</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('permissions.update', $permission->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('permission.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
