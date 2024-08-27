@extends('adminlte::page')

@section('title', 'Crear Rol')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Rol</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('roles.store') }}" role="form">
                            @csrf
                            @include('role.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
