<x-modal :id="$modalId" title="Elementos Consolidados - Consolidación {{ $consolidacion->id }}" size="lg">
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>ID Solicitud</th>
                <th>Fecha solicitud</th>
                <th>Solicitante</th>
                <th>Descripcion</th>
                <th>Elemento</th>
                <th>Cantidad Unidad</th>
                <th>Centro Costo</th>
                <th>Descripción Elemento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($elementosConsolidados as $elementoConsolidado)
                <tr>
                    <td>{{ $elementoConsolidado->solicitudesCompra->id }}</td>
                    <td>{{ $elementoConsolidado->solicitudesCompra->fecha_solicitud }}</td>
                    <td>{{ $elementoConsolidado->solicitudesCompra->user->name }}</td>
                    <td>{{ $elementoConsolidado->solicitudesCompra->descripcion }}</td>
                    <td>{{ $elementoConsolidado->solicitudesElemento->nivelesTres->nombre }}</td>
                    <td>{{ $elementoConsolidado->solicitudesElemento->cantidad }}</td>
                    <td>{{ $elementoConsolidado->solicitudesElemento->centrosCosto->nombre }}</td>
                    <td>{{ $elementoConsolidado->solicitudesElemento->descripcion_elemento }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-modal>