<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $nivelesTre?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_niveles_dos" class="form-label">{{ __('Nivel Dos') }}</label>
            <select name="id_niveles_dos" class="form-control select2 @error('id_niveles_dos') is-invalid @enderror" id="id_niveles_dos">
                <option value="">{{ __('Seleccione un nivel dos') }}</option>
                @foreach($nivelesDos as $nivelDos)
                    <option value="{{ $nivelDos->id }}" {{ old('id_niveles_dos', $nivelesTre?->id_niveles_dos) == $nivelDos->id ? 'selected' : '' }}>
                        {{ $nivelDos->nombre }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('id_niveles_dos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="id_referencias_gastos" class="form-label">{{ __('Referencia Gasto') }}</label>
            <select name="id_referencias_gastos" class="form-control select2 @error('id_referencias_gastos') is-invalid @enderror" id="id_referencias_gastos">
                <option value="">{{ __('Seleccione una referencia de gasto') }}</option>
                @foreach($referenciasGastos as $referenciaGasto)
                    <option value="{{ $referenciaGasto->id }}" {{ old('id_referencias_gastos', $nivelesTre?->id_referencias_gastos) == $referenciaGasto->id ? 'selected' : '' }}>
                        {{ $referenciaGasto->codigo_mekano}} - {{ $referenciaGasto->nombre }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('id_referencias_gastos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <!-- Añadir el nuevo select de unidades aquí -->
        <div class="form-group mb-2 mb20">
            <label for="unidad_id" class="form-label">{{ __('Unidad') }}</label>
            <select name="unidad_id" class="form-control select2 @error('unidad_id') is-invalid @enderror" id="unidad_id">
                <option value="">{{ __('Seleccione una unidad') }}</option>
                @foreach($unidades as $unidad)
                    <option value="{{ $unidad->id }}" {{ old('unidad_id', $nivelesTre?->unidad_id) == $unidad->id ? 'selected' : '' }}>
                        {{ $unidad->nombre }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('unidad_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <!-- Checkbox de Inventario -->
        <div class="form-group mb-2 mb20">
            <label for="inventario" class="form-label">{{ __('Inventario') }}</label>
            <input type="checkbox" name="inventario" id="inventario" value="1" {{ old('inventario', $nivelesTre?->inventario) ? 'checked' : '' }}>
        </div>
        

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>