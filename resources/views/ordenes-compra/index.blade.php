@extends('adminlte::page')

@section('title', 'Ordenes de Compra')

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
                                {{ __('Ordenes Compras') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('ordenes-compras.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Fecha Emision</th>
									<th >Subtotal</th>
									<th >Total</th>
									<th >Cantidad Total</th>
									<th >Nota</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ordenesCompras as $ordenesCompra)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $ordenesCompra->fecha_emision }}</td>
										<td >{{ $ordenesCompra->subtotal }}</td>
										<td >{{ $ordenesCompra->total }}</td>
										<td >{{ $ordenesCompra->cantidad_total }}</td>
										<td >{{ $ordenesCompra->nota }}</td>

                                            <td>
                                                <form action="{{ route('ordenes-compras.destroy', $ordenesCompra->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('ordenes-compras.show', $ordenesCompra->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('ordenes-compras.edit', $ordenesCompra->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $ordenesCompras->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
