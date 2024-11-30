@extends('adminlte::page')

@section('template_title')
    Motivos
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Motivos') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('motivos.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Crear nuevo') }}
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
                                        <th>Descripción</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($motivos as $motivo)
                                        <tr>
                                            <td>{{ $motivo->id }}</td>
                                            <td>{{ $motivo->nombre }}</td>
                                            <td>{{ $motivo->descripcion }}</td>
                                            <td>
                                                <form action="{{ route('motivos.destroy', $motivo->id) }}" method="POST"
                                                    class="delete-form">
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ route('motivos.show', $motivo->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('motivos.edit', $motivo->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i>
                                                    </a>
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
