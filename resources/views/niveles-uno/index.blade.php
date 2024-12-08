@extends('adminlte::page')

@section('title', 'Niveles Jerárquicos')

@section('css')
<style>
    .scrollable-list {
        max-height: 300px;
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
                        <span id="card_title">{{ __('Niveles Jerárquicos') }}</span>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
                @endif
                <div class="card-body bg-white">
                    <div class="row">
                        <!-- Columna Nivel Uno -->
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Nivel Uno</h5>
                                <a href="{{ route('niveles-unos.create') }}" class="btn btn-primary btn-sm">
                                    {{ __('Crear Nuevo') }}
                                </a>
                            </div>
                            <!-- Importar nivel uno -->
                            <form action="{{ route('niveles-unos.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" aria-label="Upload" required>
                                    <button class="btn btn-secondary" type="submit">Importar</button>
                                    {!! $errors->first('file', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>
                                <br>
                            </form>
                            @if ($message = Session::get('success'))
                                <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
                            @endif
                            <div class="list-group scrollable-list" id="nivelesUnoList">
                                @foreach ($nivelesUnos as $nivelUno)
                                    <a href="#" class="list-group-item list-group-item-action" data-id="{{ $nivelUno->id }}">
                                        {{ $nivelUno->nombre }}
                                        <!-- Enlace de edición -->
                                        <a href="{{ route('niveles-unos.edit', $nivelUno->id) }}" class="btn btn-warning btn-sm float-right" data-placement="left">
                                            {{ __('Editar') }}
                                        </a>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Columna Nivel Dos -->
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Nivel Dos</h5>
                                <a href="{{ route('niveles-dos.create') }}" class="btn btn-primary btn-sm">
                                    {{ __('Crear Nuevo') }}
                                </a>
                            </div>
                            <!-- Importar nivel dos -->
                            <form action="{{ route('niveles-dos.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" aria-label="Upload" required>
                                    <button class="btn btn-secondary" type="submit">Importar</button>
                                    {!! $errors->first('file', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>
                                <br>
                            </form>
                            <div class="list-group scrollable-list" id="nivelesDosList">
                                <div class="alert alert-info">No se ha seleccionado ningún nivel uno aún.</div>
                            </div>
                        </div>

                        <!-- Columna Nivel Tres -->
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Nivel Tres</h5>
                                <a href="{{ route('niveles-tres.create') }}" class="btn btn-primary btn-sm">{{ __('Crear Nuevo') }}</a>
                            </div>

                            <!-- Lista de niveles tres -->
                            <form action="{{ route('niveles-tres.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" aria-label="Upload" required>
                                    <button class="btn btn-secondary" type="submit">Importar</button>
                                    {!! $errors->first('file', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>
                                <br>
                            </form>
                            <div class="list-group scrollable-list" id="nivelesTresList">
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