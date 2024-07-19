<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="estiba" class="form-label">{{ __('Estiba') }}</label>
            <input type="text" name="estiba" class="form-control @error('estiba') is-invalid @enderror" value="{{ old('estiba', $estibaProducto?->estiba) }}" id="estiba" placeholder="Estiba">
            {!! $errors->first('estiba', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="descargue" class="form-label">{{ __('Descargue') }}</label>
            <input type="text" name="descargue" class="form-control @error('descargue') is-invalid @enderror" value="{{ old('descargue', $estibaProducto?->descargue) }}" id="descargue" placeholder="Descargue">
            {!! $errors->first('descargue', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="cantidad_producto" class="form-label">{{ __('Cantidad Producto') }}</label>
            <input type="text" name="cantidad_producto" class="form-control @error('cantidad_producto') is-invalid @enderror" value="{{ old('cantidad_producto', $estibaProducto?->cantidad_producto) }}" id="cantidad_producto" placeholder="Cantidad Producto">
            {!! $errors->first('cantidad_producto', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>