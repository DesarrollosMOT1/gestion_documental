@extends('adminlte::page')

@section('title', 'Cotizaciones')

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
                                {{ __('Cotizaciones') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('cotizaciones.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
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
                                        
									<th >Fecha Cotizacion</th>
									<th >Nombre</th>
									<th >Valor</th>
									<th >Condiciones Pago</th>
									<th >Descuento</th>
									<th >Id Terceros</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cotizaciones as $cotizacione)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $cotizacione->fecha_cotizacion }}</td>
										<td >{{ $cotizacione->nombre }}</td>
										<td >{{ $cotizacione->valor }}</td>
										<td >{{ $cotizacione->condiciones_pago }}</td>
										<td >{{ $cotizacione->descuento }}</td>
										<td >{{ $cotizacione->id_terceros }}</td>

                                            <td>
                                                <form action="{{ route('cotizaciones.destroy', $cotizacione->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('cotizaciones.show', $cotizacione->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('cotizaciones.edit', $cotizacione->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $cotizaciones->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection