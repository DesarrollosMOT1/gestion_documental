@extends('adminlte::page')

@section('title', 'Clasificaciones Centro')

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
                            <div class="float-right d-flex align-items-center">
                                <a href="{{ route('clasificaciones-centros.create') }}" class="btn btn-primary btn-sm" data-placement="left">
                                    {{ __('Crear Nuevo') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div id="success-message" data-message="{{ $message }}" style="display: none;"></div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Nombre</th>
                                        <th>Áreas</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clasificacionesCentros as $clasificacionesCentro)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $clasificacionesCentro->nombre }}</td>
                                            <td>
                                                {{ $clasificacionesCentro->areas->pluck('nombre')->implode(', ') }}
                                            </td>
                                            <td>
                                                <form action="{{ route('clasificaciones-centros.destroy', $clasificacionesCentro->id) }}" class="delete-form" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('clasificaciones-centros.show', $clasificacionesCentro->id) }}"><i class="fa fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('clasificaciones-centros.edit', $clasificacionesCentro->id) }}"><i class="fa fa-fw fa-edit"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i></button>
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
@endsection
