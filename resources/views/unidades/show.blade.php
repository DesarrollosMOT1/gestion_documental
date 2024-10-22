@extends('adminlte::page')

@section('template_title')
    {{ $unidad->nombre ?? __('Mostrar') . ' ' . __('Unidad') }}
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.foundation.min.css">
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
                        <table id="equivalenciasTable" class="table table-striped table-bordered dt-responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Unidad</th>
                                    @foreach ($equivalencias['equivalencias'] as $equivalencia)
                                        <th>Equivale a</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $equivalencias['unidad'] }}</td> <!-- Aquí se muestra la unidad principal -->
                                    @foreach ($equivalencias['equivalencias'] as $equivalencia)
                                        <td>{{ $equivalencia['cantidad'] }} {{ $equivalencia['unidad_equivalente'] }}
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
