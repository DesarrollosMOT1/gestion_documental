@extends('adminlte::page')

@section('title', 'Ordenes de Compra')


@section('content')
<br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Ordenes Compras') }}
                            </span>
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
									<th>Fecha Emision</th>
									<th>Tercero</th>
                                    <th>NIT</th>
                                    <th>Tipo Factura</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ordenesCompras as $ordenesCompra)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $ordenesCompra->fecha_emision }}</td>
										<td >{{ $ordenesCompra->tercero->nombre }}</td>
                                        <td >{{ $ordenesCompra->tercero->nit }}</td>
                                        <td >{{ $ordenesCompra->tercero->tipo_factura }}</td>

                                            <td>
                                                <form action="{{ route('ordenes-compras.destroy', $ordenesCompra->id) }}" class="delete-form" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('ordenes-compras.show', $ordenesCompra->id) }}"><i class="fa fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('ordenes-compras.edit', $ordenesCompra->id) }}"><i class="fa fa-fw fa-edit"></i></a>
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
