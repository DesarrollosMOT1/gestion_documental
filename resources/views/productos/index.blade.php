@extends('adminlte::page')

@section('template_title')
    Productos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Productos') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm float-right"
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

                                        <th>Codigo Producto</th>
                                        <th>Nombre</th>
                                        <th>Peso Bruto</th>
                                        <th>Unidad Medida Peso</th>
                                        <th>Medida Volumen</th>
                                        <th>Ean</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td>{{ $producto->codigo_producto }}</td>
                                            <td>{{ $producto->nombre }}</td>
                                            <td>{{ $producto->peso_bruto }}</td>
                                            <td>{{ $producto->unidad_medida_peso }}</td>
                                            <td>{{ $producto->medida_volumen }}</td>
                                            <td>{{ $producto->ean }}</td>

                                            <td>
                                                <form action="{{ route('productos.destroy', $producto->codigo_producto) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('productos.show', $producto->codigo_producto) }}"><i
                                                            class="fa fa-fw fa-eye"></i> {{ __('Mostrar') }}</a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('productos.edit', $producto->codigo_producto) }}"><i
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
                {!! $productos->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
