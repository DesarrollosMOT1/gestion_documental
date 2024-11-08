@extends('adminlte::page')

@section('title', 'Clasificaciones Centro')

@section('css')
<style>
    .scrollable-list {
        max-height: 350px;
        overflow-y: auto;
    }
</style>
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
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="row">
                            <!-- Columna Clasificacion Centro Costo -->
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>Clasificaciones Centros</h5>
                                    <a href="{{ route('clasificaciones-centros.create') }}" class="btn btn-primary btn-sm">{{ __('Crear Nuevo') }}</a>
                                </div>
                                <div class="list-group scrollable-list" id="ClasificacionesCentrosList">
                                    @foreach ($clasificacionesCentros as $clasificacionesCentro)
                                        <a href="#" class="list-group-item list-group-item-action" data-id="{{ $clasificacionesCentro->id }}">
                                            <strong>{{ $clasificacionesCentro->nombre }}</strong>
                                            <p class="card-text"><strong>Áreas:</strong> 
                                                {{ $clasificacionesCentro->areas->pluck('nombre')->implode(', ') }}
                                            </p>
                                            <a href="{{ route('clasificaciones-centros.edit', $clasificacionesCentro->id) }}" class="btn btn-warning btn-sm float-right">{{ __('Editar') }}</a>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
    
                            <!-- Columna Centro Costo -->
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>Centros Costos</h5>
                                    <a href="{{ route('centros-costos.create') }}" class="btn btn-primary btn-sm">{{ __('Crear Nuevo') }}</a>
                                </div>
                                <form action="{{ route('centros-costos.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group">
                                        <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" aria-label="Upload" required>
                                        <button class="btn btn-secondary" type="submit">Importar</button>
                                        {!! $errors->first('file', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                    </div>
                                    <br>
                                </form>
                                <div class="list-group scrollable-list" id="centrosCostosList">
                                    <div class="alert alert-info">No se ha seleccionado ninguna clasificación centro aún.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/clasificaciones-centro/cargarCentroCosto.js') }}"></script>
@endpush
