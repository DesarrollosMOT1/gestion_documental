<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $unidades?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="unidad" class="form-label">{{ __('Unidad Equivalente') }}</label>
            <select id="unidad" name="unidad" onchange="handleUnidadChange()" class="form-control">
                <option value="">Seleccione una unidad equivalente</option>
            </select>
            {!! $errors->first('unidad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="cantidad" class="form-label">{{ __('Cantidad') }}</label>
            <input type="number" name="cantidad" class="form-control" id="cantidad" required min="1"
                max="1000" step="1">
        </div>
    </div>

    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Crear') }}</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('{{ route('unidades.get-all') }}')
            .then(response => response.json())
            .then(data => {
                const tipoSelect = document.getElementById('unidad');
                tipoSelect.innerHTML = '';

                const optBase = document.createElement('option');
                optBase.value = "base";
                optBase.textContent = "base";
                tipoSelect.appendChild(optBase);

                if (data.length > 0) {
                    data.forEach(option => {
                        const opt = document.createElement('option');
                        opt.value = option.id;
                        opt.textContent = option.name;
                        tipoSelect.appendChild(opt);
                    });
                } else {
                    console.log('No se encontraron unidades equivalentes');
                }

                // Ejecutar la función al cargar los datos para que se valide si la opción por defecto es "base"
                handleUnidadChange();
            })
            .catch(error => console.error('Error al cargar las unidades equivalentes:', error));
    });

    function handleUnidadChange() {
        const unidadSelect = document.getElementById('unidad');
        const cantidadInput = document.getElementById('cantidad');

        if (unidadSelect.value === 'base') {
            // Si la opción seleccionada es "base", bloquear el campo de cantidad y poner el valor en 1
            cantidadInput.value = 1;
            cantidadInput.setAttribute('readonly', true);
        } else {
            // Si es otra opción, permitir editar el campo cantidad
            cantidadInput.removeAttribute('readonly');
        }
    }
</script>
