<div class="row">
    <div class="col-md-6">
        <h6 class="border-bottom pb-2 mb-3">Detalle de Solicitud de Cotización</h6>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>ID:</strong> {{ $cotizacionElemento->id }}</li>
            <li class="list-group-item"><strong>Nombre:</strong> {{ $elementoNombre }}</li>
            <li class="list-group-item"><strong>Descripcion:</strong> {{ $cotizacionElemento->consolidacionOferta->descripcion ?? 'N/A' }}</li>
            <li class="list-group-item"><strong>Cantidad:</strong> {{ $cotizacionElemento->consolidacionOferta->consolidacione->cantidad }}</li>
            <li class="list-group-item"><strong>Precio:</strong> <span class="badge bg-info text-white">${{ number_format($cotizacionElemento->precio, 2) }}</span></li>
            <li class="list-group-item"><strong>Descuento:</strong> {{ $cotizacionElemento->descuento }}%</li>
            <li class="list-group-item"><strong>Impuesto:</strong> {{ $cotizacionElemento->impuesto->nombre ?? 'N/A' }}</li>
            <li class="list-group-item"><strong>Estado:</strong> <span class="badge {{ $cotizacionElemento->cotizacionesPrecios->firstWhere('id_agrupaciones_consolidaciones', $agrupacion->id) ? $cotizacionElemento->cotizacionesPrecios->firstWhere('id_agrupaciones_consolidaciones', $agrupacion->id)->estado == 1 ? 'bg-success' : 'bg-warning text-dark' : 'bg-secondary' }}">{{ $cotizacionElemento->cotizacionesPrecios->firstWhere('id_agrupaciones_consolidaciones', $agrupacion->id) ? $cotizacionElemento->cotizacionesPrecios->firstWhere('id_agrupaciones_consolidaciones', $agrupacion->id)->estado == 1 ? 'Aprobada' : 'Pendiente' : 'Sin Estado' }}</span></li>
            @can('editar_consolidacion_estado_jefe')
            <div class="mt-3">
                <p>Justificación del Jefe:</p>
                <textarea 
                    id="justificacionJefe{{ $cotizacionElemento->id }}" 
                    class="form-control justificacion-jefe-textarea" 
                    rows="3" 
                    maxlength="255" 
                    data-id="{{ $cotizacionElemento->id }}"
                    data-id-agrupacion="{{ $agrupacion->id }}"
                    data-id-consolidaciones="{{ $consolidaciones->first()->id }}"
                >{{ $cotizacionPrecio->justificacion_jefe ?? '' }}</textarea>
                <small id="charCountJefe{{ $cotizacionElemento->id }}" class="form-text text-muted">0/255 caracteres</small>
                <div id="justificacionJefeError{{ $cotizacionElemento->id }}" class="invalid-feedback">Por favor, proporcione una justificación.</div>
                <button 
                    type="button" 
                    class="btn btn-primary mt-2 guardar-justificacion-jefe" 
                    data-id="{{ $cotizacionElemento->id }}"
                    data-id-agrupacion="{{ $agrupacion->id }}"
                    data-id-consolidaciones="{{ $consolidaciones->first()->id }}"
                >
                    Guardar Justificación
                </button>
            </div>
            @endcan
        </ul>
    </div>
    <div class="col-md-6">
        <h6 class="border-bottom pb-2 mb-3">Detalle de Cotización</h6>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Nombre:</strong> {{ $cotizacionElemento->cotizacione->nombre ?? 'N/A' }}</li>
            <li class="list-group-item"><strong>Nombre:</strong> {{ $cotizacionElemento->cotizacione->user->name ?? 'N/A' }}</li>
            <li class="list-group-item"><strong>Valor:</strong> <span class="badge bg-info text-white">${{ number_format($cotizacionElemento->cotizacione->valor, 2) }}</span></li>
            <li class="list-group-item"><strong>Condiciones de Pago:</strong> {{ $cotizacionElemento->cotizacione->condiciones_pago }}</li>
            <li class="list-group-item"><strong>Tercero:</strong> {{ $cotizacionElemento->cotizacione->tercero->nombre ?? 'N/A' }}</li>
            <li class="list-group-item"><strong>Fecha de Cotización:</strong> {{ \Carbon\Carbon::parse($cotizacionElemento->cotizacione->fecha_cotizacion)->format('d/m/Y') }}</li>
            <li class="list-group-item"><strong>Fecha de inicio vigencia:</strong> {{ \Carbon\Carbon::parse($cotizacionElemento->cotizacione->fecha_inicio_vigencia)->format('d/m/Y') }}</li>
            <li class="list-group-item"><strong>Fecha de fin vigencia:</strong> {{ \Carbon\Carbon::parse($cotizacionElemento->cotizacione->fecha_fin_vigencia)->format('d/m/Y') }}</li>
            <li class="list-group-item"><strong>Estado de Vigencia:</strong> <span class="badge {{ $cotizacionElemento->estado_vigencia === 'cercano' ? 'bg-danger' : ($cotizacionElemento->estado_vigencia === 'medio' ? 'bg-warning' : 'bg-success') }}">
                {{ $cotizacionElemento->estado_vigencia === 'cercano' ? 'Cerca de vencer' : ($cotizacionElemento->estado_vigencia === 'medio' ? 'Pronto a vencer' : 'Válida') }}
            </span></li>
            <li class="list-group-item"><strong>Días Restantes:</strong> 
                <span class="text-muted">
                    @if($cotizacionElemento->estado_vigencia === 'expirado')
                        Expirada
                    @else
                        {{ abs(floor(\Carbon\Carbon::parse($cotizacionElemento->cotizacione->fecha_fin_vigencia)->diffInDays(now()))) }} días restantes
                    @endif
                </span>
            </li>
        </ul>
    </div>
</div>