@extends('adminlte::page')

@section('title', 'Referencia Gasto')

@section('content')
<br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Referencias Gastos') }}
                            </span>

                            <div class="float-right d-flex align-items-center">
                                <form action="{{ route('referencias-gastos.import') }}" method="POST" enctype="multipart/form-data" class="d-flex mr-2">
                                    @csrf
                                    <input type="file" class="form-control mr-2 @error('file') is-invalid @enderror" name="file" aria-label="Upload" required>
                                    {!! $errors->first('file', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                    <button class="btn btn-secondary" type="submit">Importar</button>
                                </form>
                                <a href="{{ route('referencias-gastos.create') }}" class="btn btn-primary btn-sm" data-placement="left">
                                    {{ __('Crear Nuevo') }}
                                </a>
                            </div>
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
                                        
									<th >Codigo Mekano</th>
									<th >Nombre</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($referenciasGastos as $referenciasGasto)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $referenciasGasto->codigo_mekano }}</td>
										<td >{{ $referenciasGasto->nombre }}</td>

                                            <td>
                                                <form action="{{ route('referencias-gastos.destroy', $referenciasGasto->id) }}" class="delete-form" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('referencias-gastos.show', $referenciasGasto->id) }}"><i class="fa fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('referencias-gastos.edit', $referenciasGasto->id) }}"><i class="fa fa-fw fa-edit"></i></a>
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
                {!! $referenciasGastos->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
