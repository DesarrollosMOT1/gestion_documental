@extends('adminlte::page')

@section('title', 'editar Rol')

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
                            @foreach ($permisos as $permiso)
                                <div>
                                    <label>
                                        <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}"
                                            {{ $role->permissions->contains($permiso->id) ? 'checked' : '' }}
                                            class="mr-1">
                                        {{ $permiso->name }}
                                    </label>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary mt-3">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
