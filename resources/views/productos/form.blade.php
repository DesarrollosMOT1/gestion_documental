<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="codigo_producto" class="form-label">{{ __('Codigo Producto') }}</label>
            <input type="text" name="codigo_producto" inputmode="numeric" pattern="[0-9]*"
                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                class="form-control @error('codigo_producto')
is-invalid
@enderror"
                value="{{ old('codigo_producto', $producto?->codigo_producto) }}" id="codigo_producto"
                placeholder="Codigo Producto">
            {!! $errors->first(
                'codigo_producto',
                '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
            ) !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $producto?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="unidad_medida_peso" class="form-label">{{ __('Unidad Medida Peso') }}</label>
            <select name="unidad_medida_peso" class="form-control @error('unidad_medida_peso') is-invalid @enderror"
                id="unidad_medida_peso">
                <option value="g"
                    {{ old('unidad_medida_peso', $producto?->unidad_medida_peso) == 'g' ? 'selected' : '' }}>Gramos (g)
                </option>
                <option value="kg"
                    {{ old('unidad_medida_peso', $producto?->unidad_medida_peso) == 'kg' ? 'selected' : '' }}>Kilogramos
                    (kg)</option>
                <option value="mg"
                    {{ old('unidad_medida_peso', $producto?->unidad_medida_peso) == 'mg' ? 'selected' : '' }}>Miligramos
                    (mg)</option>
                <option value="lb"
                    {{ old('unidad_medida_peso', $producto?->unidad_medida_peso) == 'lb' ? 'selected' : '' }}>Libras
                    (lb)</option>
                <option value="oz"
                    {{ old('unidad_medida_peso', $producto?->unidad_medida_peso) == 'oz' ? 'selected' : '' }}>Onzas (oz)
                </option>
                <option value="ton"
                    {{ old('unidad_medida_peso', $producto?->unidad_medida_peso) == 'ton' ? 'selected' : '' }}>
                    Toneladas (ton)</option>
                <option value="st"
                    {{ old('unidad_medida_peso', $producto?->unidad_medida_peso) == 'st' ? 'selected' : '' }}>Stones
                    (st)</option>
            </select>
            {!! $errors->first(
                'unidad_medida_peso',
                '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
            ) !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="peso_bruto" class="form-label" inputmode="numeric" pattern="[0-9]*"
                onkeypress="return event.charCode >= 48 && event.charCode <= 57">{{ __('Peso Bruto') }}</label>
            <input type="text" name="peso_bruto" class="form-control @error('peso_bruto') is-invalid @enderror"
                value="{{ old('peso_bruto', $producto?->peso_bruto) }}" id="peso_bruto" placeholder="Peso Bruto">
            {!! $errors->first('peso_bruto', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="medida_volumen" class="form-label">{{ __('Medida Volumen') }}</label>
            <input type="text" name="medida_volumen"
                class="form-control @error('medida_volumen') is-invalid @enderror"
                onkeypress="return isNumberKey(event)" value="{{ old('medida_volumen', $producto?->medida_volumen) }}"
                id="medida_volumen" placeholder="Medida Volumen">
            {!! $errors->first(
                'medida_volumen',
                '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
            ) !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="ean" class="form-label">{{ __('Ean') }}</label>
            <input type="text" name="ean" inputmode="numeric" pattern="[0-9]*"
                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                class="form-control @error('ean')
is-invalid
@enderror" value="{{ old('ean', $producto?->ean) }}"
                id="ean" placeholder="Ean">
            {!! $errors->first('ean', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Crear') }}</button>
    </div>
</div>
<script>
    function isNumberKey(evt) {
        const charCode = evt.charCode || evt.keyCode;
        const value = evt.target.value;

        // Permitir números (0-9)
        if (charCode >= 48 && charCode <= 57) {
            return true;
        }

        // Permitir solo un punto decimal (.)
        if (charCode === 46 && !value.includes('.')) {
            return true;
        }

        // Bloquear cualquier otro carácter
        return false;
    }
</script>
