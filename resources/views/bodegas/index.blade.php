@extends('adminlte::page')

@section('template_title')
    Bodegas
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Bodegas') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('bodegas.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Crear Nuevo') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <!-- Añadir la clase "datatable" a la tabla para futuros usos de DataTables -->
                            <table class="table table-striped table-hover datatable">
                                <thead class="thead">
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Dirección</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bodegas as $bodega)
                                        <tr>
                                            <td>{{ $bodega->id }}</td>
                                            <td>{{ $bodega->nombre }}</td>
                                            <td>{{ $bodega->direccion }}</td>
                                            <td>
                                                <form action="{{ route('bodegas.destroy', $bodega->id) }}" method="POST"
                                                    class="delete-form">
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ route('bodegas.show', $bodega->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> </a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('bodegas.edit', $bodega->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-fw fa-trash"></i></button>
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
