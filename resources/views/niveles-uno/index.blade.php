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
<script>
    $(document).ready(function() {
        // Función para cargar niveles dos
        function cargarNivelesDos(idNivelUno) {
            $.ajax({
                url: '/api/niveles-dos/' + idNivelUno,
                method: 'GET',
                success: function(response) {
                    let nivelesDosList = $('#nivelesDosList');
                    nivelesDosList.empty();
                    $('#nivelesTresList').empty().html('<div class="alert alert-info">No se ha seleccionado ningún nivel dos aún.</div>');
                    if (response.length > 0) {
                        response.forEach(function(nivelDos) {
                            nivelesDosList.append(`
                                <a href="#" class="list-group-item list-group-item-action" data-id="${nivelDos.id}">
                                    ${nivelDos.nombre}
                                </a>
                            `);
                        });
                    } else {
                        nivelesDosList.html('<div class="alert alert-warning">No hay niveles dos disponibles para este nivel uno.</div>');
                    }
                },
                error: function() {
                    console.error('Error al cargar niveles dos.');
                    $('#nivelesDosList').html('<div class="alert alert-danger">Error al cargar niveles dos.</div>');
                }
            });
        }

        // Función para cargar niveles tres
        function cargarNivelesTres(idNivelDos) {
            $.ajax({
                url: '/api/niveles-tres/' + idNivelDos,
                method: 'GET',
                success: function(response) {
                    let nivelesTresList = $('#nivelesTresList');
                    nivelesTresList.empty();
                    if (response.length > 0) {
                        response.forEach(function(nivelTres) {
                            nivelesTresList.append(`
                                <span class="list-group-item">${nivelTres.nombre}</span>
                            `);
                        });
                    } else {
                        nivelesTresList.html('<div class="alert alert-warning">No hay niveles tres disponibles para este nivel dos.</div>');
                    }
                },
                error: function() {
                    console.error('Error al cargar niveles tres.');
                    $('#nivelesTresList').html('<div class="alert alert-danger">Error al cargar niveles tres.</div>');
                }
            });
        }

        // Manejo de eventos de clic para cargar niveles jerárquicos
        $('#nivelesUnoList').on('click', '.list-group-item', function(event) {
            event.preventDefault();
            let idNivelUno = $(this).data('id');
            cargarNivelesDos(idNivelUno);
            $(this).addClass('active').siblings().removeClass('active');
        });

        $('#nivelesDosList').on('click', '.list-group-item', function(event) {
            event.preventDefault();
            let idNivelDos = $(this).data('id');
            cargarNivelesTres(idNivelDos);
            $(this).addClass('active').siblings().removeClass('active');
        });
    });
</script>
@endpush
