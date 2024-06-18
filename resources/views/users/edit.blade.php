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
                        <p class="h5">Nombre de usuario: {{ $user->name }}</p>
                        <br>
                        <p>Roles disponibles:</p>
                        <form action="{{ route('admin.users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]"
                                           value="{{ $role->id }}" {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach

                        <button type="submit" class="btn btn-primary mt-3">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
