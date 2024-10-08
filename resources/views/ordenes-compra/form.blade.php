<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="fecha_emision" class="form-label">{{ __('Fecha Emision') }}</label>
            <input type="date" name="fecha_emision" class="form-control @error('fecha_emision') is-invalid @enderror" value="{{ old('fecha_emision', $ordenesCompra?->fecha_emision) }}" id="fecha_emision" placeholder="Fecha Emision">
            {!! $errors->first('fecha_emision', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
</div>

<div id="formularioOrdenesCompra" class="row g-3">
    <!-- Aquí se van a cargar dinámicamente las tarjetas con JS -->
</div>

<div class="col-md-12 mt-2">
    <button type="submit" id="btnEnviarOrden" class="btn btn-primary" disabled>{{ __('Crear') }}</button>
</div>
