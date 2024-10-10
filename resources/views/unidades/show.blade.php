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
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($equivalencias->isNotEmpty())
                                    @foreach ($equivalencias as $equivalencia)
                                        <tr>
                                            <td>
                                                {{ $equivalencia->nombre_equivalente ?? 'Unidad no encontrada' }}
                                            </td>
                                            <td>
                                                {{ $equivalencia->nombre_equivalente ?? 'Nombre no disponible' }}
                                            </td>
                                            <td>{{ $equivalencia->cantidad }}</td>
                                            <td>
                                                <form action="{{ route('equivalencias.destroy', $equivalencia->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault(); confirm('¿Está seguro de querer borrar esta equivalencia?') ? this.closest('form').submit() : false;">
                                                        <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2">Sin equivalencias</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="float-right">
                            <x-equivalencia-add-modal :idUnidadPrincipal="$unidad->id" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
