@extends('adminlte::page')

@section('template_title')
    Clases Movimientos
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Clases Movimientos') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('clases-movimientos.create') }}" class="btn btn-primary btn-sm float-right"
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
                                        <th>Descripcion</th>
                                        <th>Tipo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clasesMovimientos as $clasesMovimiento)
                                        <tr>
                                            <td>{{ $clasesMovimiento->id }}</td>
                                            <td>{{ $clasesMovimiento->nombre }}</td>
                                            <td>{{ $clasesMovimiento->descripcion }}</td>
                                            <td>{{ $clasesMovimiento->tipo }}</td>
                                            <td>
                                                <form
                                                    action="{{ route('clases-movimientos.destroy', $clasesMovimiento->id) }}"
                                                    method="POST" class="delete-form">
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ route('clases-movimientos.show', $clasesMovimiento->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i> </a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('clases-movimientos.edit', $clasesMovimiento->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> </a>
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
