@extends('adminlte::page')

@section('title', 'Administración Usuarios')

@section('content')
<br>    
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Usuarios') }}
                        </span>

                        <div class="float-right">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                              {{ __('Crear Nuevo') }}
                            </a>
                          </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover datatable">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Area</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->area->nombre }}</td>
                                    <td>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" class="delete-form" method="POST">
                                            <a class="btn btn-sm btn-success" href="{{ route('admin.users.edit', $user) }}"><i class="fa fa-fw fa-edit"></i></a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
