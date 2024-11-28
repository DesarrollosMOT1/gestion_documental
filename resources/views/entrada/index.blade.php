@extends('adminlte::page')

@section('title', 'Entradas')

@section('content')
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Entradas') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('entradas.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Crear Nuevo') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

                                        <th>Fecha Recepcion Factura</th>
                                        <th>Adjunto</th>
                                        <th>Numero</th>
                                        <th>Id Users</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entradas as $entrada)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $entrada->fecha_recepcion_factura }}</td>
                                            <td>{{ $entrada->adjunto }}</td>
                                            <td>{{ $entrada->numero }}</td>
                                            <td>{{ $entrada->id_users }}</td>
                                            <td>{{ $entrada->fecha }}</td>
                                            <td>{{ $entrada->estado }}</td>

                                            <td>
                                                <form action="{{ route('entradas.destroy', $entrada->id) }}"
                                                    class="delete-form" method="POST">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('entradas.show', $entrada->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('entradas.edit', $entrada->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i></a>
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
