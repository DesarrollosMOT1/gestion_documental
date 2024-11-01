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
                            <span id="card_title">{{ __('Registro de auditoría') }}</span>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable" data-ajax="{{ route('getAudits') }}" id="audits">
                                <thead>
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
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/auditoria/auditoriaIndex.js') }}"></script>
@endpush
