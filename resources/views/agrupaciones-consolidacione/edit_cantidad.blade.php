@if($consolidacion->elementosConsolidados->isNotEmpty())
<div class="table-responsive">
    @foreach($consolidacion->elementosConsolidados as $elementoConsolidado)
        <div class="mb-4"> <!-- Contenedor con margen inferior -->
            <h5 class="text-primary">Elemento Consolidado #{{ $loop->iteration }}</h5>
            <table class="table table-bordered table-striped table-hover">
                <tbody>
                    <tr>
                        <th scope="row">Elemento Consolidado</th>
                        <td>
                            <input type="text" class="form-control" value="{{ $elementoConsolidado->solicitudesElemento->nivelesTres->nombre }}" readonly>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Cantidad</th>
                        <td>
                            <input type="number" class="form-control @error('cantidad') is-invalid @enderror" 
                                id="cantidad" name="cantidad" value="{{ old('cantidad', $elementoConsolidado->solicitudesElemento->cantidad) }}">
                            @error('cantidad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha Solicitud de Compra</th>
                        <td>
                            <input type="text" class="form-control" value="{{ $elementoConsolidado->solicitudesElemento->solicitudesCompra->fecha_solicitud }}" readonly>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Prefijo Solicitud de Compra</th>
                        <td>
                            <input type="text" class="form-control" value="{{ $elementoConsolidado->solicitudesElemento->solicitudesCompra->prefijo }}" readonly>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Descripción Solicitud de Compra</th>
                        <td>
                            <input type="text" class="form-control" value="{{ $elementoConsolidado->solicitudesElemento->solicitudesCompra->descripcion }}" readonly>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Centro de Costo</th>
                        <td>
                            <input type="text" class="form-control" value="{{ $elementoConsolidado->solicitudesElemento->centrosCosto->nombre }}" readonly>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Código Centro de Costo</th>
                        <td>
                            <input type="text" class="form-control" value="{{ $elementoConsolidado->solicitudesElemento->centrosCosto->codigo_mekano }}" readonly>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach
</div>
@else

<div class="table-responsive">
    <h5>Solicitud de compra #{{ $consolidacion->solicitudesElemento->solicitudesCompra->id }}</h5>
    <table class="table table-bordered table-striped table-hover">
        <tbody>
            <tr>
                <th scope="row">Elemento</th>
                <td>
                    <input type="text" class="form-control" id="elemento" value="{{ $consolidacion->solicitudesElemento->nivelesTres->nombre }}" readonly>
                </td>
            </tr>
            
            <tr>
                <th scope="row">Cantidad</th>
                <td>
                    <input type="number" class="form-control @error('cantidad') is-invalid @enderror" 
                        id="cantidad" name="cantidad" value="{{ old('cantidad', $consolidacion->solicitudesElemento->cantidad) }}">
                    @error('cantidad')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </td>
            </tr>

            <tr>
                <th scope="row">Fecha Solicitud de Compra</th>
                <td>
                    <input type="text" class="form-control" value="{{ $consolidacion->solicitudesElemento->solicitudesCompra->fecha_solicitud }}" readonly>
                </td>
            </tr>
            
            <tr>
                <th scope="row">Prefijo Solicitud de Compra</th>
                <td>
                    <input type="text" class="form-control" value="{{ $consolidacion->solicitudesElemento->solicitudesCompra->prefijo }}" readonly>
                </td>
            </tr>
            <tr>
                <th scope="row">Descripción Solicitud de Compra</th>
                <td>
                    <input type="text" class="form-control" value="{{ $consolidacion->solicitudesElemento->solicitudesCompra->descripcion }}" readonly>
                </td>
            </tr>
            
            <tr>
                <th scope="row">Centro de Costo</th>
                <td>
                    <input type="text" class="form-control" value="{{ $consolidacion->solicitudesElemento->centrosCosto->nombre }}" readonly>
                </td>
            </tr>
            <tr>
                <th scope="row">Código Centro de Costo</th>
                <td>
                    <input type="text" class="form-control" value="{{ $consolidacion->solicitudesElemento->centrosCosto->codigo_mekano }}" readonly>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif

<button type="submit" class="btn btn-primary">Enviar</button>