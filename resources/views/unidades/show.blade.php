@extends('adminlte::page')

@section('template_title')
    {{ $unidad->nombre ?? __('Mostrar') . ' ' . __('Unidad') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Unidad</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('unidades.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>id:</strong>
                            {{ $unidad->id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $unidad->nombre }}
                        </div>

                        <h5>Equivalencias</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Unidad Equivalente</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($unidad->equivalencias->isNotEmpty())
                                    @foreach ($unidad->equivalencias as $equivalencia)
                                        <tr>
                                            <td>{{ $equivalencia->unidad_equivalente ? $equivalencia->unidad_equivalente : 'Unidad no encontrada' }}
                                            </td>
                                            <td>{{ $equivalencia->cantidad }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2">Sin equivalencias</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
