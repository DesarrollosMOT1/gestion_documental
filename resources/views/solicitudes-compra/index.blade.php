@extends('adminlte::page')

@section('title', 'Solicitudes Compra')

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
                                {{ __('Solicitudes Compras') }}
                            </span>

                             <div class="float-right">  
                                <!-- Deshabilitar el botón por defecto -->
                                <button type="button" id="btnGenerarCotizacion" class="btn btn-secondary btn-sm float-right ml-2" data-bs-toggle="modal" data-bs-target="#cotizacionModal" disabled>
                                    {{ __('Generar Cotización') }}
                                </button>              
                                <a href="{{ route('solicitudes-compras.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>
                                            <input type="checkbox" id="select_all" />
                                        </th>
                                        <th>No</th>
                                        <th>Fecha Solicitud</th>
                                        <th>Id Users</th>
                                        <th>Prefijo</th>
                                        <th>Descripcion</th>
                                        <th>Estado Solicitud</th>
                                        <th>Fecha Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitudesCompras as $solicitudesCompra)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="select_item" value="{{ $solicitudesCompra->id }}" />
                                            </td>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $solicitudesCompra->fecha_solicitud }}</td>
                                            <td>{{ $solicitudesCompra->id_users }}</td>
                                            <td>{{ $solicitudesCompra->prefijo }}</td>
                                            <td>{{ $solicitudesCompra->descripcion }}</td>
                                            <td>{{ $solicitudesCompra->estado_solicitud }}</td>
                                            <td>{{ $solicitudesCompra->fecha_estado }}</td>
                                            <td>
                                                <form action="{{ route('solicitudes-compras.destroy', $solicitudesCompra->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('solicitudes-compras.show', $solicitudesCompra->id) }}"><i class="fa fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('solicitudes-compras.edit', $solicitudesCompra->id) }}"><i class="fa fa-fw fa-edit"></i></a>
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
                {!! $solicitudesCompras->withQueryString()->links() !!}
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="cotizacionModal" tabindex="-1" aria-labelledby="cotizacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cotizacionModalLabel">{{ __('Generar Cotización') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cotizacionForm" method="POST" action="{{ route('cotizaciones.store') }}">
                    @csrf
                    <div class="row padding-1 p-1">
                        <div class="col-md-12">
                            @include('cotizacione.form', ['cotizacione' => new \App\Models\Cotizacione])
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/cotizaciones/generarCotizaciones.js') }}"></script>
    <script>
        var impuestos = @json($impuestos);
        var csrfToken = '{{ csrf_token() }}';
    </script>
@endpush
