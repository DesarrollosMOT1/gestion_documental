@extends('adminlte::page')

@section('template_title')
    Unidades
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Unidades') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('unidades.create') }}" class="btn btn-primary btn-sm float-right"
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
                            <table class="table table-striped table-hover datatable">
                                <thead class="thead">
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($unidades as $unidad)
                                        <tr>
                                            <td>{{ $unidad->id }}</td>
                                            <td>{{ $unidad->nombre }}</td>
                                            <td>
                                                <form action="{{ route('unidades.destroy', $unidad->id) }}" method="POST"
                                                    class="delete-form">
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ route('unidades.show', $unidad->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i>
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
