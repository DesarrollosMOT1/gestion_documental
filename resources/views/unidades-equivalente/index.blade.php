@extends('adminlte::page')

@section('template_title')
    Unidades Equivalentes
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Unidades Equivalentes') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('unidades-equivalentes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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

									<th >Unidad Principal</th>
									<th >Unidad Equivalente</th>
									<th >Cantidad</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($unidadesEquivalentes as $unidadesEquivalente)
                                        <tr>
                                            <td>{{ ++$i }}</td>

										<td >{{ $unidadesEquivalente->unidad_principal }}</td>
										<td >{{ $unidadesEquivalente->unidad_equivalente }}</td>
										<td >{{ $unidadesEquivalente->cantidad }}</td>

                                            <td>
                                                <form action="{{ route('unidades-equivalentes.destroy', $unidadesEquivalente->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('unidades-equivalentes.show', $unidadesEquivalente->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('unidades-equivalentes.edit', $unidadesEquivalente->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $unidadesEquivalentes->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
