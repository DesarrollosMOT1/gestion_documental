@extends('adminlte::page')

@section('title', 'Actualizar Usuario')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="m-0">Actualizar Usuario</h3>
            <a class="btn btn-primary btn-sm" href="{{ route('admin.users.index') }}">Atrás</a>
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                @include('users.form')
            </form>
        </div>
    </div>
</div>
@endsection
