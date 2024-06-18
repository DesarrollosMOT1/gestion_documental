@extends('adminlte::page')

@section('title', 'Solicitud Compras')

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
                                {{ __('Solicitud Compras') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('solicitud-compras.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                            <table class="table table-striped table-hover" id="solicitud">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
									<th >Fecha Solicitud</th>
									<th >Nombre</th>
									<th >Area</th>
									<th >Tipo Factura</th>
									<th >Prefijo</th>
									<th >Cantidad</th>
									<th >Nota</th>
									<th >Centro Costo</th>
									<th >Referencia Gastos</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitudCompras as $solicitudCompra)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $solicitudCompra->fecha_solicitud }}</td>
										<td >{{ $solicitudCompra->user->name }}</td>
										<td >{{ $solicitudCompra->area }}</td>
										<td >{{ $solicitudCompra->tipo_factura }}</td>
										<td >{{ $solicitudCompra->prefijo }}</td>
										<td >{{ $solicitudCompra->cantidad }}</td>
										<td >{{ $solicitudCompra->nota }}</td>
										<td >{{ $solicitudCompra->centroCosto->nombre }}</td>
										<td >{{ $solicitudCompra->referenciaGasto->nombre }}</td>

                                            <td>
                                                <form action="{{ route('solicitud-compras.destroy', $solicitudCompra->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('solicitud-compras.show', $solicitudCompra->id) }}"><i class="fa fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('solicitud-compras.edit', $solicitudCompra->id) }}"><i class="fa fa-fw fa-edit"></i></a>
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
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.foundation.min.js"></script>
<script>
    new DataTable('#solicitud', {
        responsive: true,
        autoWidth: false,
        "language": {
            "lengthMenu": "Mostrar " +
                `<select class="custom-select custom-select-s form-control form-control-sm">
                                    <option value='10'>10</option>
                                    <option value='25'>25</option>
                                    <option value='50'>50</option>
                                    <option value='100'>100</option>
                                    <option value='-1'>Todo</option>
                                </select>` +
                " Registros por página",
            "zeroRecords": "Nada encontrado - disculpa",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                'next': 'Siguiente',
                'previous': 'Anterior',
            }
        }
    });
</script>

<script>
    $('.formulario-eliminar').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                /* Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success' 
                )*/
                this.submit();
            }
        })
    });
</script>
@endsection
