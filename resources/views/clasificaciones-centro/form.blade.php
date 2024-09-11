<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $clasificacionesCentro?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_areas" class="form-label">{{ __('Área(s)') }}</label>
            <select name="id_areas[]" class="form-control select2 @error('id_areas') is-invalid @enderror" id="id_areas" multiple>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ in_array($area->id, old('id_areas', $clasificacionesCentro?->areas->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                        {{ $area->nombre }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('id_areas', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>              

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>