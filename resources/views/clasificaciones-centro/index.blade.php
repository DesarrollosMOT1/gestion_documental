@extends('adminlte::page')

@section('title', 'Clasificaciones Centro')

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
                                {{ __('Clasificaciones Centros') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('clasificaciones-centros.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Nombre</th>
									<th >Id Areas</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clasificacionesCentros as $clasificacionesCentro)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $clasificacionesCentro->nombre }}</td>
										<td >{{ $clasificacionesCentro->area->nombre }}</td>

                                            <td>
                                                <form action="{{ route('clasificaciones-centros.destroy', $clasificacionesCentro->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('clasificaciones-centros.show', $clasificacionesCentro->id) }}"><i class="fa fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('clasificaciones-centros.edit', $clasificacionesCentro->id) }}"><i class="fa fa-fw fa-edit"></i></a>
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
                {!! $clasificacionesCentros->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection