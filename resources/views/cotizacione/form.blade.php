<div class="row padding-1 p-1">
    @if($tercerosSinCotizacion->isEmpty())
        <div class="alert alert-info" role="alert">
            Ya se han creado todas las cotizaciones para los terceros relacionados.
        </div>
    @endif
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label for="id_terceros" class="form-label">{{ __('Tercero') }}</label>
            <select name="id_terceros" id="id_terceros" class="form-control @error('id_terceros') is-invalid @enderror" required>
                <option value="" disabled selected>Seleccione un tercero</option>
                @forelse($tercerosSinCotizacion as $tercero)
                    <option value="{{ $tercero->nit }}" {{ old('id_terceros', $cotizacione?->id_terceros) == $tercero->nit ? 'selected' : '' }}>
                        {{ $tercero->nombre }} (NIT: {{ $tercero->nit }})
                    </option>
                @empty
                    <option value="" disabled>No hay terceros disponibles</option>
                @endforelse
            </select>
            {!! $errors->first('id_terceros', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label for="fecha_cotizacion" class="form-label">{{ __('Fecha Cotización') }}</label>
            <div class="input-group">
                <input type="date" name="fecha_cotizacion" class="form-control @error('fecha_cotizacion') is-invalid @enderror" value="{{ old('fecha_cotizacion', $cotizacione?->fecha_cotizacion) }}" id="fecha_cotizacion">
            </div>
            {!! $errors->first('fecha_cotizacion', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-2">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="" id="nombre" placeholder="Nombre de la cotización" readonly>
            {!! $errors->first('nombre', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-2">
            <label for="valor" class="form-label">{{ __('Valor') }}</label>
            <input type="text" name="valor" class="form-control @error('valor') is-invalid @enderror" value="{{ old('valor', $cotizacione?->valor) }}" id="valor" placeholder="Valor de la cotización" readonly>
            {!! $errors->first('valor', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
        <small class="text-muted">El valor se actualizara cuando añadas el precio de un elemento!</small>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-2">
            <label for="condiciones_pago" class="form-label">{{ __('Condiciones Pago') }}</label>
            <select name="condiciones_pago" class="form-control select2 @error('condiciones_pago') is-invalid @enderror" id="condiciones_pago">
                <option value="">{{ __('Seleccione una opción') }}</option>
                <option value="30 días" {{ old('condiciones_pago', $cotizacione?->condiciones_pago) == '30 días' ? 'selected' : '' }}>30 días</option>
                <option value="contado" {{ old('condiciones_pago', $cotizacione?->condiciones_pago) == 'contado' ? 'selected' : '' }}>Contado</option>
                <option value="crédito" {{ old('condiciones_pago', $cotizacione?->condiciones_pago) == 'crédito' ? 'selected' : '' }}>Crédito</option>
            </select>
            {!! $errors->first('condiciones_pago', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-2">
            <label for="descuento" class="form-label">{{ __('Descuento') }}</label>
            <input type="text" name="descuento" class="form-control @error('descuento') is-invalid @enderror" value="{{ old('descuento', $cotizacione?->descuento) }}" id="descuento" placeholder="Descuento">
            {!! $errors->first('descuento', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-2">
            <label for="fecha_inicio_vigencia" class="form-label">{{ __('Fecha Inicio Vigencia') }}</label>
            <input type="date" name="fecha_inicio_vigencia" class="form-control @error('fecha_inicio_vigencia') is-invalid @enderror" value="{{ old('fecha_inicio_vigencia', $cotizacione?->fecha_inicio_vigencia) }}" id="fecha_inicio_vigencia">
            {!! $errors->first('fecha_inicio_vigencia', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-2">
            <label for="fecha_fin_vigencia" class="form-label">{{ __('Fecha Fin Vigencia') }}</label>
            <input type="date" name="fecha_fin_vigencia" class="form-control @error('fecha_fin_vigencia') is-invalid @enderror" value="{{ old('fecha_fin_vigencia', $cotizacione?->fecha_fin_vigencia) }}" id="fecha_fin_vigencia">
            {!! $errors->first('fecha_fin_vigencia', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-md-12">
        <h4 class="mb-3">Elementos</h4>
        <!-- Contenedor para los elementos dinámicos -->
        <div id="elementos_container" class="mt-3"></div>
    </div>

    <div class="col-md-12 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>

    <!-- Spinner de carga -->
    <div id="loading-spinner" class="spinner-border text-primary" role="status" style="display:none;">
        <span class="sr-only">Cargando...</span>
    </div>
</div>
