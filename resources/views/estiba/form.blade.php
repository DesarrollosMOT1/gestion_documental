<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="unidad_medida" class="form-label">{{ __('Unidad Medida') }}</label>
            <input type="text" name="unidad_medida" class="form-control @error('unidad_medida') is-invalid @enderror" value="{{ old('unidad_medida', $estiba?->unidad_medida) }}" id="unidad_medida" placeholder="Unidad Medida">
            {!! $errors->first('unidad_medida', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="medida" class="form-label">{{ __('Medida') }}</label>
            <input type="text" name="medida" class="form-control @error('medida') is-invalid @enderror" value="{{ old('medida', $estiba?->medida) }}" id="medida" placeholder="Medida">
            {!! $errors->first('medida', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>