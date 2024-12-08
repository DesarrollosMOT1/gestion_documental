@extends('adminlte::page')

@section('title', 'Cotizaciones')

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
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
                    @endif

                    <div class="card-body bg-white">
                        <form method="GET" action="{{ route('cotizaciones.index') }}" class="mb-4">
                            @csrf
                            <x-filtro-fechas />
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
									<th >Fecha Cotizacion</th>
									<th >Nombre</th>
									<th >Valor</th>
									<th >Condiciones Pago</th>
									<th >Tercero</th>
									<th >Fecha Inicio Vigencia</th>
									<th >Fecha Fin Vigencia</th>

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
                                        <td >{{ $cotizacione->fecha_inicio_vigencia }}</td>
										<td >{{ $cotizacione->fecha_fin_vigencia }}</td>

                                            <td>
                                                <form action="{{ route('cotizaciones.destroy', $cotizacione->id) }}" class="delete-form" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('cotizaciones.show', $cotizacione->id) }}"><i class="fa fa-fw fa-eye"></i></a>
                                                    {{-- <a class="btn btn-sm btn-success" href="{{ route('cotizaciones.edit', $cotizacione->id) }}"><i class="fa fa-fw fa-edit"></i></a> --}}
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i></button> --}}
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
