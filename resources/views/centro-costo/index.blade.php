@extends('adminlte::page')

@section('title', 'Centros')

@section('content')
<br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Centro Costos') }}
                            </span>
                            <form action="{{ route('import-centro') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                <input type="file" name="file" class="btn btn-sm btn-success ml-2" accept=".xlsx, .xls, .csv">
                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-upload"></i> Importar Excel</button>
                            </form>
                             <div class="float-right">
                                <a href="{{ route('centro-costos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Codigo</th>
									<th >Nombre</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($centroCostos as $centroCosto)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $centroCosto->codigo }}</td>
										<td >{{ $centroCosto->nombre }}</td>

                                            <td>
                                                <form action="{{ route('centro-costos.destroy', $centroCosto->codigo) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('centro-costos.show', $centroCosto->codigo) }}"><i class="fa fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('centro-costos.edit', $centroCosto->codigo) }}"><i class="fa fa-fw fa-edit"></i></a>
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
            </div>
        </div>
    </div>
@endsection
