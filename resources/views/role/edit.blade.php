@extends('adminlte::page')

@section('title', 'Editar Rol')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Rol</span>
                    </div>
                    <div class="card-body bg-white">
                        <h3>Rol: {{ $role->name }}</h3>
                        <br>
                        <p>Lista de permisos disponibles:</p>
                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @include('role.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
