<div class="card">
    <div class="card-header">
        <h4>Unidades Equivalentes de {{ $producto->nombre }}</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre del Producto</th>
                    <th>Unidad Equivalente</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $nombre => $unidadEquivalente)
                    <tr>
                        <td>{{ $nombre }}</td>
                        <td>{{ $unidadEquivalente }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn btn-primary" href="{{ route('productos.index') }}">Volver a la lista de productos</a>
    </div>
</div>
