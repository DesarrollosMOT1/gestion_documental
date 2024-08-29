<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="codigo_mekano" class="form-label">{{ __('Codigo Mekano') }}</label>
            <input type="text" name="codigo_mekano" class="form-control @error('codigo_mekano') is-invalid @enderror" value="{{ old('codigo_mekano', $referenciasGasto?->codigo_mekano) }}" id="codigo_mekano" placeholder="Codigo Mekano">
            {!! $errors->first('codigo_mekano', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $referenciasGasto?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>