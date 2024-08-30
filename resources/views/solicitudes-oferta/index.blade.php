@extends('adminlte::page')

@section('template_title')
    Solicitudes Ofertas
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Solicitudes Ofertas') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('solicitudes-ofertas.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Fecha Solicitud Oferta</th>
									<th >Id Users</th>
									<th >Id Terceros</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitudesOfertas as $solicitudesOferta)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $solicitudesOferta->fecha_solicitud_oferta }}</td>
										<td >{{ $solicitudesOferta->id_users }}</td>
										<td >{{ $solicitudesOferta->id_terceros }}</td>

                                            <td>
                                                <form action="{{ route('solicitudes-ofertas.destroy', $solicitudesOferta->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('solicitudes-ofertas.show', $solicitudesOferta->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('solicitudes-ofertas.edit', $solicitudesOferta->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $solicitudesOfertas->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
