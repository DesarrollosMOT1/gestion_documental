@extends('adminlte::page')

@section('title', 'Agrupaciones Consolidaciones')

@section('content')
<br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Agrupaciones Consolidaciones') }}
                            </span>

                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
									<th>Usuario</th>
									<th>Fecha Consolidacion</th>
                                    <th>Area</th>
                                    <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agrupacionesConsolidaciones as $agrupacionesConsolidacione)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $agrupacionesConsolidacione->user->name }}</td>
										<td >{{ $agrupacionesConsolidacione->fecha_consolidacion }}</td>
                                        <td>{{ $agrupacionesConsolidacione->user->area->nombre }}</td>
                                            <td>
                                                <form action="{{ route('agrupaciones-consolidaciones.destroy', $agrupacionesConsolidacione->id) }}" class="delete-form" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('agrupaciones-consolidaciones.show', $agrupacionesConsolidacione->id) }}"><i class="fa fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('agrupaciones-consolidaciones.edit', $agrupacionesConsolidacione->id) }}"><i class="fa fa-fw fa-edit"></i></a>
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