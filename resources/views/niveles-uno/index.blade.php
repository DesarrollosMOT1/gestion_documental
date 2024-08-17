@extends('adminlte::page')

@section('title', 'Niveles Jerárquicos')

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
                        <span id="card_title">{{ __('Niveles Jerárquicos') }}</span>
                        <div class="float-right">
                            <a href="{{ route('niveles-unos.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('Crear Nuevo') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <div class="row">
                        <!-- Columna Nivel Uno -->
                        <div class="col-md-4">
                            <h5 class="mb-3">Nivel Uno</h5>
                            <div class="list-group" id="nivelesUnoList">
                                @foreach ($nivelesUnos as $nivelUno)
                                    <a href="#" class="list-group-item list-group-item-action" data-id="{{ $nivelUno->id }}">
                                        {{ $nivelUno->nombre }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Columna Nivel Dos -->
                        <div class="col-md-4">
                            <h5 class="mb-3">Nivel Dos</h5>
                            <div class="list-group" id="nivelesDosList">
                                <div class="alert alert-info">No se ha seleccionado ningún nivel uno aún.</div>
                            </div>
                        </div>

                        <!-- Columna Nivel Tres -->
                        <div class="col-md-4">
                            <h5 class="mb-3">Nivel Tres</h5>
                            <div class="list-group" id="nivelesTresList">
                                <div class="alert alert-info">No se ha seleccionado ningún nivel dos aún.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! $nivelesUnos->withQueryString()->links() !!}
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('js/niveles-uno/cargarNiveles.js') }}"></script>
@endpush
