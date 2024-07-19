<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="fecha_cotizacion" class="form-label">{{ __('Fecha Cotizacion') }}</label>
            <input type="text" name="fecha_cotizacion" class="form-control @error('fecha_cotizacion') is-invalid @enderror" value="{{ old('fecha_cotizacion', $cotizacione?->fecha_cotizacion) }}" id="fecha_cotizacion" placeholder="Fecha Cotizacion">
            {!! $errors->first('fecha_cotizacion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $cotizacione?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="valor" class="form-label">{{ __('Valor') }}</label>
            <input type="text" name="valor" class="form-control @error('valor') is-invalid @enderror" value="{{ old('valor', $cotizacione?->valor) }}" id="valor" placeholder="Valor">
            {!! $errors->first('valor', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="condiciones_pago" class="form-label">{{ __('Condiciones Pago') }}</label>
            <input type="text" name="condiciones_pago" class="form-control @error('condiciones_pago') is-invalid @enderror" value="{{ old('condiciones_pago', $cotizacione?->condiciones_pago) }}" id="condiciones_pago" placeholder="Condiciones Pago">
            {!! $errors->first('condiciones_pago', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="descuento" class="form-label">{{ __('Descuento') }}</label>
            <input type="text" name="descuento" class="form-control @error('descuento') is-invalid @enderror" value="{{ old('descuento', $cotizacione?->descuento) }}" id="descuento" placeholder="Descuento">
            {!! $errors->first('descuento', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_terceros" class="form-label">{{ __('Id Terceros') }}</label>
            <input type="text" name="id_terceros" class="form-control @error('id_terceros') is-invalid @enderror" value="{{ old('id_terceros', $cotizacione?->id_terceros) }}" id="id_terceros" placeholder="Id Terceros">
            {!! $errors->first('id_terceros', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>