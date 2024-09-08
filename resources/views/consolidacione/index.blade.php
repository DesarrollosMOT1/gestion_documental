@extends('adminlte::page')

@section('title', 'Consolidaciones')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.foundation.min.css">
@endsection

@section('content')
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Consolidaciones') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('consolidaciones.create') }}" class="btn btn-primary btn-sm float-right"
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
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

                                        <th>Id Solicitudes Compras</th>
                                        <th>Id Solicitud Elemento</th>
                                        <th>Estado</th>
                                        <th>Cantidad</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($consolidaciones as $consolidacione)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $consolidacione->id_solicitudes_compras }}</td>
                                            <td>{{ $consolidacione->id_solicitud_elemento }}</td>
                                            <td>{{ $consolidacione->estado }}</td>
                                            <td>{{ $consolidacione->cantidad }}</td>

                                            <td>
                                                <form action="{{ route('consolidaciones.destroy', $consolidacione->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('consolidaciones.show', $consolidacione->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i> {{ __('Mostrar') }}</a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('consolidaciones.edit', $consolidacione->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i
                                                            class="fa fa-fw fa-trash"></i> {{ __('eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $consolidaciones->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
