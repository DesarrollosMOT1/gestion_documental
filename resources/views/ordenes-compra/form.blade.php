<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="fecha_emision" class="form-label">{{ __('Fecha Emision') }}</label>
            <input type="text" name="fecha_emision" class="form-control @error('fecha_emision') is-invalid @enderror" value="{{ old('fecha_emision', $ordenesCompra?->fecha_emision) }}" id="fecha_emision" placeholder="Fecha Emision">
            {!! $errors->first('fecha_emision', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_terceros" class="form-label">{{ __('Id Terceros') }}</label>
            <input type="text" name="id_terceros" class="form-control @error('id_terceros') is-invalid @enderror" value="{{ old('id_terceros', $ordenesCompra?->id_terceros) }}" id="id_terceros" placeholder="Id Terceros">
            {!! $errors->first('id_terceros', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
</div>

<div id="formularioOrdenesCompra" class="row g-3">
    <!-- Aquí se van a cargar dinámicamente las tarjetas con JS -->
</div>

<div class="col-md-12 mt-2">
    <button type="submit" id="btnEnviarOrden" class="btn btn-primary" disabled>{{ __('Crear') }}</button>
</div>
