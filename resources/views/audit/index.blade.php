@extends('adminlte::page')

@section('title', 'Auditoria')

@section('content')
<br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Registro de auditoria') }}
                            </span>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Tipo de Usuario</th>
                                        <th>Nombre Usuario</th>
                                        <th>Fecha</th> 
                                        <th>Evento</th>
                                        <th>Tabla</th>
                                        <th>ID</th>
                                        <th>Valores Antiguos</th>
                                        <th>Valores Nuevos</th>
                                        <th>URL</th>
                                        <th>Dirección IP</th>
                                        <th>Agente de Usuario</th>
                                        <th>Etiquetas</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($audits as $audit)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
                                        <td>{{ class_basename($audit->user_type) }}</td>
                                        <td>{{ optional($audit->user)->name }}</td>
                                        <td>{{ $audit->created_at->format('d/m/Y H:i:s') }}</td> 
										<td >{{ $audit->event }}</td>
										<td >{{ class_basename($audit->auditable_type) }}</td>
										<td >{{ $audit->auditable_id }}</td>
										<td >{{ $audit->old_values }}</td>
										<td >{{ $audit->new_values }}</td>
										<td >{{ $audit->url }}</td>
										<td >{{ $audit->ip_address }}</td>
										<td >{{ $audit->user_agent }}</td>
										<td >{{ $audit->tags }}</td>

                                            <td>
                                                <a class="btn btn-sm btn-primary " href="{{ route('audits.show', $audit->id) }}"><i class="fa fa-fw fa-eye"></i></a>
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
