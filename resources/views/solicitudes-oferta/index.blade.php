@extends('adminlte::page')

@section('title', 'Solicitudes Oferta')

@section('content')
<br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Solicitudes Ofertas') }}
                            </span>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
                    @endif

                    <div class="card-body bg-white">
                        <form method="GET" action="{{ route('solicitudes-ofertas.index') }}" class="mb-4">
                            <x-filtro-fechas />
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
									<th >Fecha Solicitud Oferta</th>
									<th >Usuario</th>
									<th >Tercero</th>
                                    <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitudesOfertas as $solicitudesOferta)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $solicitudesOferta->fecha_solicitud_oferta }}</td>
										<td >{{ $solicitudesOferta->user->name }}</td>
                                        <td>
                                            @if($solicitudesOferta->terceros->isNotEmpty())
                                                {{ $solicitudesOferta->terceros->pluck('nombre')->implode(', ') }}
                                            @else
                                                No hay terceros asociados
                                            @endif
                                        </td>
                                            <td>
                                                <form action="{{ route('solicitudes-ofertas.destroy', $solicitudesOferta->id) }}" class="delete-form" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('solicitudes-ofertas.show', $solicitudesOferta->id) }}"><i class="fa fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('solicitudes-ofertas.edit', $solicitudesOferta->id) }}"><i class="fa fa-fw fa-edit"></i></a>
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
                {!! $solicitudesOfertas->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
