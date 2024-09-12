@extends('adminlte::page')

@section('title', 'Cambiar Contraseña')

@section('content')

    <!--- Mensajes -->
    @include('users.msjs')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h1 class="text-center">Cambiar Contraseña</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('changePassword') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <div class="form-group mt-3">
                                <label for="password_actual">Clave Actual</label>
                                <input type="password" name="password_actual"
                                    class="form-control @error('password_actual') is-invalid @enderror" required>
                                @error('password_actual')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="new_password ">Nueva Clave</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="confirm_password">Confirmar nueva Clave</label>
                                <input type="password" name="confirm_password"
                                    class="form-control @error('confirm_password') is-invalid @enderror" required>
                                @error('confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row text-center mb-4 mt-5">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" id="formCrear">Guardar Cambios</button>
                                    <a href="/home" class="btn btn-secondary">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
