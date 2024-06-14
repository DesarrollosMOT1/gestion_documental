@extends('adminlte::page')

@section('title', 'Referencia')

@section('content')
<br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Referencia Gastos') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('referencia-gastos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Codigo</th>
									<th >Nombre</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($referenciaGastos as $referenciaGasto)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $referenciaGasto->codigo }}</td>
										<td >{{ $referenciaGasto->nombre }}</td>

                                            <td>
                                                <form action="{{ route('referencia-gastos.destroy', $referenciaGasto->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('referencia-gastos.show', $referenciaGasto->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('referencia-gastos.edit', $referenciaGasto->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $referenciaGastos->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
