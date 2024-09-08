@extends('adminlte::page')

@section('template_title')
    Tipos Movimientos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Tipos Movimientos') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('tipos-movimientos.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('crear nuevo') }}
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
                                        <th>Id</th>

                                        <th>Nombre</th>
                                        <th>Descripcion</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tiposMovimientos as $tiposMovimiento)
                                        <tr>
                                            <td>{{ $tiposMovimiento->id }}</td>

                                            <td>{{ $tiposMovimiento->nombre }}</td>
                                            <td>{{ $tiposMovimiento->descripcion }}</td>

                                            <td>
                                                <form
                                                    action="{{ route('tipos-movimientos.destroy', $tiposMovimiento->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('tipos-movimientos.show', $tiposMovimiento->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i> {{ __('Mostrar') }}</a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('tipos-movimientos.edit', $tiposMovimiento->id) }}"><i
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
                {!! $tiposMovimientos->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
