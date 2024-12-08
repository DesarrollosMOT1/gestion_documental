@extends('adminlte::page')

@section('title', 'Solicitudes Compra')

@section('content')
<br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Solicitudes Compras') }}
                            </span>

                            <div class="float-right">  
                                <!-- Botón para Generar Consolidación -->
                                <button type="button" id="btnGenerarConsolidacion" class="btn btn-secondary btn-sm float-right ml-2" data-bs-toggle="modal" data-bs-target="#consolidacionModal" disabled>
                                    {{ __('Generar Consolidación') }}
                                </button>     
                                <a href="{{ route('solicitudes-compras.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                {{ __('Crear Nuevo') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
                    @endif

                    <div class="card-body bg-white">
                        <form method="GET" action="{{ route('solicitudes-compras.index') }}" class="mb-4">
                            @csrf
                            <x-filtro-fechas />
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable">
                                <thead class="thead">
                                    <tr>
                                        <th>
                                            <div class="form-check ms-2">
                                                <input class="form-check-input" type="checkbox" id="select_all" />
                                            </div>
                                        </th>
                                        <th>No</th>
                                        <th>Fecha Solicitud</th>
                                        <th>Usuario</th>
                                        <th>Prefijo</th>
                                        <th>Descripcion</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitudesCompras as $solicitudesCompra)
                                        <tr>
                                            <td>
                                                <div class="form-check ms-2">
                                                    <input class="form-check-input select_item" type="checkbox" value="{{ $solicitudesCompra->id }}" />
                                                </div>
                                            </td>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $solicitudesCompra->fecha_solicitud }}</td>
                                            <td>{{ $solicitudesCompra->user->name }}</td>
                                            <td>{{ $solicitudesCompra->prefijo }}</td>
                                            <td>{{ $solicitudesCompra->descripcion }}</td>
                                            <td>
                                                <form action="{{ route('solicitudes-compras.destroy', $solicitudesCompra->id) }}" class="delete-form" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('solicitudes-compras.show', $solicitudesCompra->id) }}"><i class="fa fa-fw fa-eye"></i></a>
                                                    {{-- <a class="btn btn-sm btn-success" href="{{ route('solicitudes-compras.edit', $solicitudesCompra->id) }}"><i class="fa fa-fw fa-edit"></i></a> --}}
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i></button> --}}
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

<!-- Modal para Consolidación -->
<x-modal id="consolidacionModal" title="{{ __('Generar Consolidación') }}" size="lg">
    <form id="consolidacionForm" method="POST" action="{{ route('agrupaciones-consolidaciones.store') }}">
        @csrf
        <div class="row padding-1 p-1">
            <div class="col-md-12">
                @include('agrupaciones-consolidacione.form', ['agrupaciones-consolidaciones' => new \App\Models\AgrupacionesConsolidacione])
            </div>    
        </div>
    </form>
</x-modal>

@endsection

@push('js')
    <script src="{{ asset('js/consolidaciones/generarConsolidaciones.js') }}"></script>
@endpush
