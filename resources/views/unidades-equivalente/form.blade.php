<div class="row padding-1 p-1">

    <div class="col-md-12">
        <div class="form-group mb-2 mb20">
            <label for="unidad_principal" class="form-label">{{ __('Unidad Principal') }}</label>
            <input type="text" name="unidad_principal" class="form-control @error('unidad_principal') is-invalid @enderror" value="{{ old('unidad_principal', $unidadesEquivalente?->unidad_principal) }}" id="unidad_principal" placeholder="Unidad Principal">
            {!! $errors->first('unidad_principal', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="unidad_equivalente" class="form-label">{{ __('Unidad Equivalente') }}</label>
            <input type="text" name="unidad_equivalente" class="form-control @error('unidad_equivalente') is-invalid @enderror" value="{{ old('unidad_equivalente', $unidadesEquivalente?->unidad_equivalente) }}" id="unidad_equivalente" placeholder="Unidad Equivalente">
            {!! $errors->first('unidad_equivalente', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="cantidad" class="form-label">{{ __('Cantidad') }}</label>
            <input type="text" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad', $unidadesEquivalente?->cantidad) }}" id="cantidad" placeholder="Cantidad">
            {!! $errors->first('cantidad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
