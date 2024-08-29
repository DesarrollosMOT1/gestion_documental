<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $nivelesDo?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_niveles_uno" class="form-label">{{ __('Nivel Uno') }}</label>
            <select name="id_niveles_uno" class="form-control select2 @error('id_niveles_uno') is-invalid @enderror" id="id_niveles_uno">
                <option value="">{{ __('Seleccione un nivel uno') }}</option>
                @foreach($nivelesUnos as $nivelUno)
                    <option value="{{ $nivelUno->id }}" {{ old('id_niveles_uno', $nivelesDo?->id_niveles_uno) == $nivelUno->id ? 'selected' : '' }}>
                        {{ $nivelUno->nombre }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('id_niveles_uno', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <!-- Checkbox de Inventario -->
        <div class="form-group mb-2 mb20">
            <label for="inventario" class="form-label">{{ __('Inventario') }}</label>
            <input type="checkbox" name="inventario" id="inventario" value="1" {{ old('inventario', $nivelesDo?->inventario) ? 'checked' : '' }}>
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>